<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Fee;
use App\Models\Section;
use App\Models\Student;
use App\Models\Voucher;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($id)
    {
        //
        $section = Section::findOrFail($id);
        // show all vouchers that include any student of this section
        $vouchers = Voucher::whereHas('fees.student', function ($query) use ($id) {
            $query->where('section_id', $id)
                ->where('due_date', '>=', today());
        })->get();
        return view('teacher.section-fee.index', compact('section', 'vouchers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($sectionId, $voucherId)
    {
        //
        $section = Section::findOrFail($sectionId);
        $voucher = Voucher::findOrFail($voucherId);
        // students who need to pay this voucher
        $students = Student::where('section_id', $sectionId)
            ->whereHas('fees', function ($query) use ($voucherId) {
                $query->where('voucher_id', $voucherId);
            })
            ->get();
        return view('teacher.section-fee.show', compact('section','voucher','students'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($sectionId, $voucherId)
    {
        //
        $section = Section::findOrFail($sectionId);
        $voucher=Voucher::findOrFail($voucherId);
        $fees = $section->fees()->where('voucher_id', $voucherId)->get();
        return view('teacher.section-fee.edit', compact('section', 'fees','voucher'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $sectionId, $voucherId)
    {
        //
        $request->validate([
            'fee_ids' => 'required',
            'fee_ids_checked' => 'required',
        ]);


        DB::beginTransaction();
        try {
            $fee_ids = $request->fee_ids;
            $fee_ids_checked = $request->fee_ids_checked;
            $fees = Fee::whereIn('id', $fee_ids)->get();

            $fees->each(function ($fee) use ($fee_ids_checked) {
                $fee->update([
                    'status' => in_array($fee->id, $fee_ids_checked),
                ]);
            });

            DB::commit();
            return redirect()->route('teacher.section.fee.show', [$sectionId, $voucherId])->with('success', 'fee successfully updated');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors($e->getMessage());
            // something went wrong
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Fee $fee)
    {
        //
    }
}
