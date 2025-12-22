<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\cr;
use App\Models\Fee;
use App\Models\Section;
use App\Models\Student;
use App\Models\Voucher;
use Exception;
use Illuminate\Http\Request;

class VoucherPayerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($voucherId, $sectionId)
    {
        //
        $voucher = Voucher::findOrFail($voucherId);
        $section = Section::findOrFail($sectionId);
        $fees = Fee::where('voucher_id', $voucherId)
            ->whereHas('student', function ($query) use ($sectionId) {
                $query->where('section_id', $sectionId);
            })
            ->with('student') // optional: eager load student
            ->get();

        return view('admin.vouchers.payers.index', compact('voucher', 'section', 'fees'));
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
    public function show($id)
    {
        //

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
    {
        //

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($voucherId, $sectionId, $id)
    {
        //
        try {
            $fee = Fee::findOrFail($id);
            $fee->delete();
            return redirect()->route('admin.voucher.section.payers.index', [$voucherId, $sectionId])->with('success', 'Successfully deleted');
        } catch (Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
            // something went wrong
        }
    }

    public function import($voucherId, $sectionId)
    {
        $voucher = Voucher::findOrFail($voucherId);
        $section = Section::findOrFail($sectionId);

        // missing students
        $students = Student::where('section_id', $sectionId)
            ->whereDoesntHave('fees', function ($query) use ($voucherId) {
                $query->where('voucher_id', $voucherId);
            })
            ->get();
        return view('admin.vouchers.payers.import', compact('voucher', 'section', 'students'));
    }
    public function postImport(Request $request, $voucherId, $sectionId)
    {
        $request->validate([
            'student_ids_array' => 'required',
        ]);


        try {
            $voucher = Voucher::findOrFail($voucherId);
            $section = Section::findOrFail($sectionId);

            // Get selected student IDs
            $studentIdsArray = array();
            $studentIdsArray = $request->student_ids_array;
            $students = Student::whereIn('id', $studentIdsArray)->get();

            foreach ($students as $student) {
                // Bulk update
                $student->fees()->create([
                    'voucher_id' => $voucher->id,
                ]);
            }
            return redirect()->route('admin.voucher.section.payers.index', [$voucherId, $sectionId])->with('success', 'Successfully imported!');
        } catch (Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
            // something went wrong
        }
    }
    public function postClean($voucherId, $sectionId)
    {
        //
        try {
            Fee::where('voucher_id', $voucherId)
                ->whereHas('student', function ($query) use ($sectionId) {
                    $query->where('section_id', $sectionId);
                })
                ->delete();
            return redirect()->back()->with('success', 'Successfully cleaned');
        } catch (Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
            // something went wrong
        }
    }
}
