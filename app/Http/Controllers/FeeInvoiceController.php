<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Fee;
use App\Models\FeeInvoice;
use App\Models\FeeStructure;
use App\Models\FeeType;
use App\Models\Section;
use App\Models\Transaction;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf as PDF;

class FeeInvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', FeeInvoice::class);

        $sections = Section::all();
        // $feeInvoices = FeeInvoice::all();
        if (session('feeInvoices'))
            $feeInvoices = session('feeInvoices');
        else
            $feeInvoices = FeeInvoice::with(['student.section'])
                ->where('status', 0)
                ->latest()
                ->paginate(5);

        // $feeInvoices = $feeInvoices->where('status', 0);
        return view('fee.invoices.index', compact('feeInvoices', 'sections'));
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

        $month = $request->month;
        $year  = $request->year;


        // $feeReceivable = Account::where('code', '1005')->first(); // Fee Receivable
        // $feeIncome     = Account::where('code', '4001')->first(); // Fee Income

        DB::beginTransaction();
        try {

            $sections = Section::whereIn('id', $sectionIdsArray)->get();

            foreach ($sections as $section) {
                foreach ($section->students as $student) {
                    $lastInvoice = FeeInvoice::where('year', $year)
                        ->lockForUpdate()
                        ->latest('id')
                        ->first();

                    $nextNumber = $lastInvoice
                        ? intval(substr($lastInvoice->invoice_no, -4)) + 1
                        : 1;

                    $invoiceNo = sprintf('F%02d%d-%05d', $month, $year - 2000, $nextNumber);
                    $invoiceAmount = $student->fees()->whereIn('fee_type_id', $feeTypeIdsArray)->sum('amount');

                    $feeInvoice = FeeInvoice::create([
                        'student_id' => $student->id,
                        'month' => $request->month,
                        'year' => $request->year,
                        'due_date' => $request->due_date,
                        'invoice_no' => $invoiceNo,
                        'amount' => 20,
                    ]);
                }
            }

            DB::commit();
            return redirect()->route('bulk-invoices.index')->with('success', 'Successfully created');
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
        // $this->authorize('view', $feeInvoice);
        // $paymentMethods = Account::where('is_payment_method', true)->get();
        // return view('fee.invoices.show', compact('feeInvoice', 'paymentMethods'));
        $user = Auth::user();
        if ($user->isIncharge()) {
            $section = $user->accessibleSections();
            $fees = Fee::where('bulk_invoice_id', $id)
                ->whereHas('student', function ($query) use ($section) {
                    $query->where('section_id', $section->id);
                })
                ->with('student') // optional: eager load student
                ->get();
        } else {
            $fees = Fee::with('student')
                ->where('bulk_invoice_id', $id)
                ->latest()
                ->paginate(5);
        }
        return view('fee.invoices.show', compact('feeInvoice', 'fees'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        //

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
            // Debit → Cash / Bank / JazzCash / Easypaisa
            $feeInvoice->transaction->lines()->create([
                'account_id' => $request->payment_account_id,
                'debit'      => $feeInvoice->amount,
                'credit'     => 0,
            ]);

            $feeReceivable = Account::where('code', '1005')->first(); // Fee Receivable

            //Cr to fee recievable
            $feeInvoice->transaction->lines()->create([
                'account_id' => $feeReceivable->id,
                'debit'     => 0,
                'credit'      => $feeInvoice->amount,
            ]);

            DB::commit();
            return redirect()->route('bulk-invoices.show', $feeInvoice)->with('success', 'Successfully updated');
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
    public function searchById(Request $request)
    {
        $request->validate([
            'invoice_no' => 'required|string',
        ]);
        $feeInvoices = FeeInvoice::with(['student.section'])
            ->where('invoice_no', $request->invoice_no)
            ->latest()
            ->paginate(5);
        return redirect()->route('bulk-invoices.index')->with('feeInvoices', $feeInvoices);
    }
    public function searchByName(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
        ]);
        $name = $request->name;
        $feeInvoices = FeeInvoice::with(['student.section'])
            ->whereHas('student', function ($q) use ($name) {
                $q->where('name', 'like', "%{$name}%");
            })
            ->latest()
            ->paginate(5);
        return redirect()->route('bulk-invoices.index')->with('feeInvoices', $feeInvoices);
    }

    public function searchByClass(Request $request)
    {
        $request->validate([
            'section_id' => 'required|numeric',
        ]);
        $name = $request->name;
        $sectionId = $request->section_id;

        $feeInvoices = FeeInvoice::with(['student.section'])
            ->whereHas('student', function ($q) use ($sectionId) {
                $q->where('section_id', $sectionId);
            })
            ->latest()
            ->paginate(5);
        return redirect()->route('bulk-invoices.index')->with('feeInvoices', $feeInvoices);
    }
    public function  print(Request $request)
    {
        $request->validate([
            'invoice_ids' => 'required|array|min:1',
        ]);
        $invoiceIds = array();
        $invoiceIds = $request->invoice_ids;

        $feeInvoices = FeeInvoice::whereIn('id', $invoiceIds)->get();
        $pdf = PDF::loadview('reports.fee-invoice', compact('feeInvoices'))->setPaper('a4', 'portrait');
        $pdf->set_option("isPhpEnabled", true);
        $file = "FeeInvoice - " . rand(10, 99) . ".pdf";
        return $pdf->stream($file);
    }
}
