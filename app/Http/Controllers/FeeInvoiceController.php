<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\FeeInvoice;
use App\Models\FeeStructure;
use App\Models\FeeType;
use App\Models\Section;
use App\Models\Transaction;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FeeInvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', FeeInvoice::class);

        // $feeInvoices = FeeInvoice::all();
        $feeInvoices = FeeInvoice::with(['student.section'])
            ->latest()
            ->paginate(5);
        return view('fee.invoices.index', compact('feeInvoices'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $this->authorize('create', FeeInvoice::class);
        $sections = Section::whereHas('students')->get();
        $months = config('enums.months');
        $fee_types = FeeType::all();
        return view('fee.invoices.create', compact('sections', 'fee_types', 'months'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', FeeInvoice::class);

        $request->validate([
            'month' => 'numeric',
            'year' => 'numeric',
            'due_date' => 'required|date',
            'fee_type_ids_array' => 'required|array|min:1', // must be an array with at least 1 item

        ]);

        $sectionIdsArray = array();
        $sectionIdsArray = $request->section_ids_array;

        $feeTypeIdsArray = array();
        $feeTypeIdsArray = $request->fee_type_ids_array;

        $year = $request->year;
        DB::beginTransaction();
        try {

            $sections = Section::whereIn('id', $sectionIdsArray)->get();

            foreach ($sections as $section) {
                foreach ($section->students as $student) {
                    // start transaction
                    $transaction = Transaction::create([
                        'date' => now()->format('Y-m-d'),
                        'reference' => 'Student Fee',
                        'description' => null,
                        'created_by' => Auth::user()->id,
                    ]);

                    $lastInvoice = FeeInvoice::where('year', $year)
                        ->lockForUpdate()
                        ->latest('id')
                        ->first();

                    $nextNumber = $lastInvoice
                        ? intval(substr($lastInvoice->invoice_no, -4)) + 1
                        : 1;

                    $invoiceNo = sprintf('F%d-%05d', $year - 2000, $nextNumber);
                    $invoiceAmount = $student->fees()->whereIn('fee_type_id', $feeTypeIdsArray)->sum('amount');


                    $feeInvoice = $transaction->feeInvoices()->create([
                        'student_id' => $student->id,
                        'month' => $request->month,
                        'year' => $request->year,
                        'due_date' => $request->due_date,
                        'invoice_no' => $invoiceNo,
                        'amount' => $invoiceAmount,
                    ]);
                    // Make sure it's an array
                    foreach ($feeTypeIdsArray as $feeTypeId) {
                        $feeInvoice->feeInvoiceItems()->create([
                            'fee_type_id' => $feeTypeId,
                            'amount' => $student->fees()->where('fee_type_id', $feeTypeId)->first()->amount,
                        ]);
                    }

                    // transaction lines
                    // Dr to fee receivable
                    $transaction->lines()->create([
                        'account_id' => Account::where('code', '1003')->value('id'),
                        'debit'      => $invoiceAmount,
                        'credit'     => 0,
                    ]);

                    //Cr to fee Income
                    $transaction->lines()->create([
                        'account_id' => Account::where('code', '4001')->value('id'),
                        'debit'     => 0,
                        'credit'      => $invoiceAmount,
                    ]);
                }
            }

            DB::commit();
            return redirect()->route('fee-invoices.index')->with('success', 'Successfully created');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors($e->getMessage());
            // something went wrong
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
        $feeInvoice = FeeInvoice::findOrFail($id);
        $this->authorize('view', $feeInvoice);

        return view('fee.invoices.show', compact('feeInvoice'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        //
        $feeInvoice = FeeInvoice::findOrFail($id);
        $this->authorize('update', $feeInvoice);


        $sections = Section::all();
        return view('fee.invoices.edit', compact('feeInvoice'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //
        DB::beginTransaction();
        try {

            $feeInvoice = FeeInvoice::find($id);
            $this->authorize('update', $feeInvoice);

            $feeInvoice->update([
                'status' => 1,
            ]);

            // transaction lines
            // Dr to cash
            $feeInvoice->transaction->lines()->create([
                'account_id' => Account::where('code', '1001')->value('id'),
                'debit'      => $feeInvoice->amount,
                'credit'     => 0,
            ]);

            //Cr to fee Income
            $feeInvoice->transaction->lines()->create([
                'account_id' => Account::where('code', '1003')->value('id'),
                'debit'     => 0,
                'credit'      => $feeInvoice->amount,
            ]);

            DB::commit();
            return redirect()->route('fee-invoices.show', $feeInvoice)->with('success', 'Successfully updated');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors($e->getMessage());
            // something went wrong
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
        $feeInvoice = FeeInvoice::findOrFail($id);
        $this->authorize('delete', $feeInvoice);

        try {
            $feeInvoice->delete();
            return redirect()->route('fee.invoices.index')->with('success', 'Successfully deleted');
        } catch (Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
            // something went wrong
        }
    }
}
