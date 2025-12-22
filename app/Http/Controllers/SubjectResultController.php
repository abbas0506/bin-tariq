<?php

namespace App\Http\Controllers;

use App\Models\TestAllocation;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf as PDF;

class SubjectResultController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function print($id)
    {
        //
        $testAllocation = TestAllocation::findOrFail($id);
        $pdf = PDF::loadview('shared-pdf.subject-result', compact('testAllocation'))->setPaper('a4', 'portrait');
        $pdf->set_option("isPhpEnabled", true);
        $file = "subject result.pdf";
        return $pdf->stream($file);
    }
}
