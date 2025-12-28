<?php

namespace App\Http\Controllers;

use App\Models\Fee;
use App\Models\Section;
use App\Models\Student;
use App\Models\Voucher;
use Exception;
use Illuminate\Http\Request;

class VoucherPaymentController extends Controller
{
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

        return view('vouchers.payments.index', compact('voucher', 'section', 'fees'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($voucherId, $feeId)
    {
        //
        // $voucher = Voucher::find($voucherId);
        // $fee = Fee::find($feeId);
        // $student = $fee->student;

        // return view('vouchers.payments.create', compact('voucher', 'student', 'fee'));
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
    public function show($voucherId, $sectionId, $studentId)
    {
        //
        $voucher = Voucher::find($voucherId);
        $section = Section::find($sectionId);
        $student = Student::find($studentId);

        return view('vouchers.payments.show', compact('voucher', 'section', 'student'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($voucherId, $sectionId, $feeId)
    {
        //
        $voucher = Voucher::find($voucherId);
        $section = Section::find($sectionId);
        $fee = Fee::find($feeId);
        $student = $fee->student;

        return view('vouchers.payments.edit', compact('voucher', 'section', 'student', 'fee'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $voucherId, $sectionId, $feeId)
    {
        //

        try {
            $fee = Fee::find($feeId);
            $section = Section::find($sectionId);
            $voucher = Voucher::find($voucherId);
            if (!$request->amount)
                $fee->update(
                    [
                        'status' => 1,
                    ]
                );
            else {
                $fee->update(
                    [
                        'status' => $request->status,
                        'amount' => $request->amount
                    ]
                );
            }
            return redirect()->route('voucher.section.payments.index', [$voucher, $section])->with('success', 'Successfully updated');
        } catch (Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
            // something went wrong
        }
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
            return redirect()->route('voucher.section.payments.index', [$voucherId, $sectionId])->with('success', 'Successfully deleted');
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
        return view('vouchers.payments.import', compact('voucher', 'section', 'students'));
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
                    'amount' => $student->fee,

                ]);
            }
            return redirect()->route('voucher.section.payments.index', [$voucherId, $sectionId])->with('success', 'Successfully imported!');
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
