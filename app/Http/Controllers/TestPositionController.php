<?php

namespace App\Http\Controllers;

use App\Models\Section;
use App\Models\Student;
use App\Models\Test;
use App\Models\TestAllocation;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use LDAP\Result;

class TestPositionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function print($testId, $sectionId)
    {
        //
        $section = Section::findOrFail($sectionId);
        $test = Test::findOrFail($testId);

        // calculate test ranking

        $students = Student::with('results.testAllocation')
            ->whereHas('results.testAllocation', function ($query) use ($testId) {
                $query->where('test_id', $testId);
            })
            ->where('section_id', $sectionId)
            ->get();

        $studentPercentages = $students->map(function ($student) use ($test) {
            // obtained_marks marks, total marks
            $obtained_marks = $student->results->where('testAllocation.test_id', $test->id)->sum('obtained_marks');
            $total = $student->results->where('testAllocation.test_id', $test->id)->sum('testAllocation.max_marks');

            // Avoid division by zero
            $percentage = $total > 0 ? ($obtained_marks / $total) * 100 : 0;

            return [
                'id' => $student->id,
                'rollno' => $student->rollno,
                'name' => $student->name,
                'max_marks' => $total,
                'obtained_marks' => $obtained_marks,
                'percentage' => round($percentage, 0),
            ];
        });

        // Sort by percentage descending
        $sortedPercentages = $studentPercentages->sortByDesc('percentage');

        $sortedResult = collect();
        $i = 0;
        foreach ($sortedPercentages as $sortedPercentage) {
            $sortedResult->push([
                'id' => $sortedPercentage['id'],
                'rollno' => $sortedPercentage['rollno'],
                'name' => $sortedPercentage['name'],
                'max_marks' => $sortedPercentage['max_marks'],
                'obtained_marks' => $sortedPercentage['obtained_marks'],
                'percentage' => $sortedPercentage['percentage'],
                'position' => ++$i,
            ]);
        }

        $pdf = PDF::loadview('shared-pdf.test-positions', compact('test', 'section', 'sortedResult'))->setPaper('a4', 'portrait');
        $pdf->set_option("isPhpEnabled", true);
        $file = "positions - " . $section->fullName() . ".pdf";
        return $pdf->stream($file);
    }
}
