<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lecture;
use App\Models\Section;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Exception;

class TeacherWiseScheduleController extends Controller
{
    //
    public function  index()
    {
        $teachers = Teacher::has('allocations')->get()->sortByDesc('bps'); //get active sections
        $lectures = Lecture::all();
        return view('admin.schedule.teacher-wise.index', compact('teachers', 'lectures'));
    }

    public function print()
    {
        // on the basis of print mode, create pdf
        if (session('teacher_ids'))
            $teachers = Teacher::whereIn('id', session('teacher_ids'))->get();
        else
            $teachers = Teacher::has('allocations')->get()->sortByDesc('bps');;

        $lectures = Lecture::all();
        $pdf = PDF::loadview('admin.schedule.teacher-wise.pdf', compact('teachers', 'lectures'))->setPaper('a4', 'portrait');
        $pdf->set_option("isPhpEnabled", true);
        $file = "teacher-schedule.pdf";
        return $pdf->stream($file);
    }

    public function post(Request $request)
    {
        $request->validate([
            'teacher_ids_array' => 'required',
        ]);
        try {
            $teacherIdsArray = array();
            $teacherIdsArray = $request->teacher_ids_array;
            session([
                'teacher_ids' => $teacherIdsArray,
                'print_mode' => $request->print_mode,
            ]);

            return redirect()->route('admin.teacher-schedule.print');
        } catch (Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
            // something went wrong
        }
    }
}
