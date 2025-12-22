<?php

namespace App\Http\Controllers\Library;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Rack;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Exception;

class PrintController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return view('library.print.index');
    }

    // Simple lists of teachers
    public function printTeachersList()
    {
        $teachers = Profile::all();
        $pdf = PDF::loadview('library.print.teachers.list', compact('teachers'))->setPaper('a4', 'portrait');
        $pdf->set_option("isPhpEnabled", true);
        $file = "teachers.pdf";
        return $pdf->stream($file);
    }


    // Simple lists of Rack Books
    public function printRackBooksList($id)
    {
        $rack = Rack::findOrFail($id);
        $pdf = PDF::loadview('library.print.rack-books.list', compact('rack'))->setPaper('a4', 'portrait');
        $pdf->set_option("isPhpEnabled", true);
        $file = "teachers.pdf";
        return $pdf->stream($file);
    }


    // Teachers QR Codes
    public function  printTeachersQr(Request $request)
    {

        $request->validate([
            'from' => 'required',
            'to' => 'required',
        ]);
        try {
            $from = $request->from;
            $to = $request->to;
            $teachers = Profile::whereBetween('cnic', [$from, $to])->get();

            $pdf = PDF::loadview('library.print.teachers.qr', compact('teachers'))->setPaper('a4', 'portrait');
            $pdf->set_option("isPhpEnabled", true);
            $file = "teachers.pdf";
            return $pdf->stream($file);
        } catch (Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
            // something went wrong
        }
    }



    public function printRackBooksQr(Request $request, $id)
    {
        $request->validate([
            'from' => 'required',
            'to' => 'required',
        ]);
        try {
            $rack = Rack::findOrFail($id);
            $from = $request->from;
            $to = $request->to;
            $books = $rack->books->whereBetween('id', [$from, $to]);

            $pdf = PDF::loadview('library.print.rack-books.qr', compact('rack', 'books'))->setPaper('a4', 'portrait');
            $pdf->set_option("isPhpEnabled", true);
            $file = "rack-books.pdf";
            return $pdf->stream($file);
        } catch (Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
            // something went wrong
        }
    }

    // Specific QR
    public function  printSpecificQr(Request $request)
    {

        $request->validate([
            'qr' => 'required',
        ]);
        try {
            $qr = $request->qr;
            $pdf = PDF::loadview('library.print.specific-qr', compact('qr'))->setPaper('a4', 'portrait');
            $pdf->set_option("isPhpEnabled", true);
            $file = "specific-qr.pdf";
            return $pdf->stream($file);
        } catch (Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
            // something went wrong
        }
    }
}
