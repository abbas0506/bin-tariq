<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Section;
use App\Models\Student;
use Exception;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf as PDF;

class SectionCardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($id)
    {
        //
        $section = Section::findOrFail($id);
        return view('admin.student-cards.index', compact('section'));
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
    public function store(Request $request, $id)
    {
        //
        $request->validate([
            'student_ids_array' => 'required',
        ]);


        try {
            $studentIdsArray = array();
            $studentIdsArray = $request->student_ids_array;
            $students = Student::whereIn('id', $studentIdsArray)->get();
            session([
                'students' => $students,
            ]);
            return redirect()->route('admin.section.cards.print');
        } catch (Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
            // something went wrong
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    public function print()
    {

        if (session('students')) {
            $students = session('students');

            $pdf = PDF::loadview('admin.student-cards.print', compact('students'))->setPaper('a4', 'portrait');
            $pdf->set_option("isPhpEnabled", true);
            $file = "cards.pdf";
            return $pdf->stream($file);
        } else {
            echo "Nothing to print";
        }
    }
}
