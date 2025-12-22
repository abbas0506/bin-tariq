<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Exception;

class SingleTeacherScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function print()
    {
        if (session('teacher_ids'))
            $teachers = Teacher::whereIn('id', session('teacher_ids'))->get();
        else
            $teachers = Teacher::has('allocations')->get()->sortByDesc('bps');;

        $pdf = PDF::loadview('admin.schedule.teacher-wise.pdf', compact('teachers'))->setPaper('a4', 'landscape');
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
            ]);
            return redirect()->route('admin.teacher-schedule.print');
        } catch (Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
            // something went wrong
        }
    }
}
