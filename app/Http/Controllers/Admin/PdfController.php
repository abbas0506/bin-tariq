<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\Section;
use App\Models\TestAllocation;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Exception;
use Illuminate\Support\Facades\Log;

class PdfController extends Controller
{
    //
    public function printTeacherCards()
    {

        try {
            if (session('teachers')) {
                $teachers = session('teachers');
                $pdf = PDF::loadview('admin.teacher-cards.pdf-lg', compact('teachers'))->setPaper('a4', 'portrait');
                $pdf->set_option("isPhpEnabled", true);
                $file = "cards.pdf";
                return $pdf->stream($file);
            } else {
                echo "Nothing to print";
            }
        } catch (Exception $ex) {
            Log::error('An error occurred: ' . $ex->getMessage(), [
                'file' => $ex->getFile(),
                'line' => $ex->getLine(),
            ]);
        }
    }
}
