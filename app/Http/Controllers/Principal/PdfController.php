<?php

namespace App\Http\Controllers\Principal;

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
    public function printuserCards()
    {

        try {
            if (session('users')) {
                $users = session('users');
                $pdf = PDF::loadview('principal.user-cards.pdf-lg', compact('users'))->setPaper('a4', 'portrait');
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
