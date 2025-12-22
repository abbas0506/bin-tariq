<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
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
        $vouchers = Voucher::all();
        return view('admin.vouchers.index', compact('vouchers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $sections = Section::all();
        return view('admin.vouchers.create', compact('sections'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'amount' => 'required|numeric',
            'due_date' => 'required|date',
            'section_ids_array' => 'required',
        ]);

        $sectionIdsArray = array();
        $sectionIdsArray = $request->section_ids_array;

        // $grades = Grade::whereIn('id', $gradeIdsArray)->get();

        DB::beginTransaction();
        try {
            $voucher = Voucher::create([
                'name' => $request->name,
                'amount' => $request->amount,
                'due_date' => $request->due_date,
            ]);
            $sections = Section::whereIn('id', $sectionIdsArray)->get();
            foreach ($sections as $section) {
                foreach ($section->students as $student) {
                    $student->fees()->create([
                        'voucher_id' => $voucher->id,
                    ]);
                }
            }
            DB::commit();
            return redirect()->route('admin.vouchers.index')->with('success', 'Successfully created');
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
        $sections = Section::all();
        return view('admin.vouchers.show', compact('voucher', 'sections'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        //
        $voucher = Voucher::findOrFail($id);
        $sections = Section::all();
        return view('admin.vouchers.edit', compact('voucher', 'sections'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //
        $request->validate([
            'name' => 'required',
            'amount' => 'required|numeric',
            'due_date' => 'required|date',
        ]);

        try {
            $voucher = Voucher::findOrFail($id);
            $voucher->update([
                'name' => $request->name,
                'amount' => $request->amount,
                'due_date' => $request->due_date,
            ]);
            return redirect()->route('admin.vouchers.show', $voucher)->with('success', 'Successfully updated');
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
        try {
            $voucher->delete();
            return redirect()->route('admin.vouchers.index')->with('success', 'Successfully deleted');
        } catch (Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
            // something went wrong
        }
    }
}
