<?php

namespace App\Http\Controllers;

use App\Models\Allocation;
use App\Models\Section;
use App\Models\Test;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf as PDF;

class ResultDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function print($testId, $sectionId)
    {
        //
        $test = Test::findOrFail($testId);
        $section = Section::findOrFail($sectionId);
        $lectureNos = Allocation::where('section_id', $section->id)->pluck('lecture_no')->unique();

        $allocations = $section->allocations->sortBy('lecture_no');

        $pdf = PDF::loadview('shared-pdf.section-result', compact('test', 'section', 'lectureNos', 'allocations'))->setPaper('a4', 'portrait');
        $pdf->set_option("isPhpEnabled", true);
        $file = "results.pdf";
        return $pdf->stream($file);
    }
}
