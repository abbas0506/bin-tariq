<?php

namespace App\Http\Controllers;

use App\Models\Fee;
use App\Models\Section;
use App\Models\Voucher;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VoucherController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $this->authorize('viewAny', Voucher::class);

        $vouchers = Voucher::all();
        return view('vouchers.index', compact('vouchers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $this->authorize('create', Voucher::class);
        $sections = Section::whereHas('students')->get();
        return view('vouchers.create', compact('sections'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', Voucher::class);

        $request->validate([
            'name' => 'required',
            'due_date' => 'required|date',
        ]);

        $sectionIdsArray = array();
        $sectionIdsArray = $request->section_ids_array;

        DB::beginTransaction();
        try {

            $voucher = Voucher::create([
                'name' => $request->name,
                'due_date' => $request->due_date,
            ]);
            $sections = Section::whereIn('id', $sectionIdsArray)->get();
            foreach ($sections as $section) {
                if ($request->is_tutionfee) {
                    foreach ($section->students as $student) {
                        $student->fees()->create([
                            'voucher_id' => $voucher->id,
                            'amount' => $student->fee,
                        ]);
                    }
                } else {
                    foreach ($section->students as $student) {
                        $student->fees()->create([
                            'voucher_id' => $voucher->id,
                            'amount' => $request->amount,
                        ]);
                    }
                }
            }

            DB::commit();
            return redirect()->route('vouchers.index')->with('success', 'Successfully created');
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
        $voucher = Voucher::findOrFail($id);
        $this->authorize('view', $voucher);

        $sections = Section::all();
        return view('vouchers.show', compact('voucher', 'sections'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        //
        $voucher = Voucher::findOrFail($id);
        $this->authorize('update', $voucher);


        $sections = Section::all();
        return view('vouchers.edit', compact('voucher', 'sections'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //
        $request->validate([
            'name' => 'required',
            'due_date' => 'required|date',
        ]);

        try {
            $voucher = Voucher::find($id);
            $this->authorize('update', $voucher);

            $voucher->update([
                'name' => $request->name,
                'due_date' => $request->due_date,
            ]);
            return redirect()->route('vouchers.show', $voucher)->with('success', 'Successfully updated');
        } catch (Exception $e) {
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
        $voucher = Voucher::findOrFail($id);
        $this->authorize('delete', $voucher);

        try {
            $voucher->delete();
            return redirect()->route('vouchers.index')->with('success', 'Successfully deleted');
        } catch (Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
            // something went wrong
        }
    }
}
