<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Allocation;
use App\Models\Lecture;
use Illuminate\Http\Request;
use App\Models\Section;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\User;
use Exception;
use Barryvdh\DomPDF\Facade\Pdf as PDF;

class SectionWiseScheduleController extends Controller
{
    //
    public function index()
    {
        $lectures = Lecture::all();
        $sections = Section::all()->sortByDesc('grade'); //get active sections
        return view('admin.schedule.section-wise.index', compact('sections', 'lectures'));
    }

    public function print()
    {

        if (session('section_ids'))
            $sections = Section::whereIn('id', session('section_ids'))->get();
        else
            $sections = Section::all();

        $lectures = Lecture::all();
        $pdf = PDF::loadview('admin.schedule.section-wise.pdf', compact('sections', 'lectures'))->setPaper('a4', 'landscape');
        $pdf->set_option("isPhpEnabled", true);
        $file = "schedule_" . today()->format('dmy');
        return $pdf->stream($file);
    }


    public function clear(Request $request)
    {
        $allocations = Allocation::all();
        try {
            foreach ($allocations as $allocation)
                $allocation->delete();
            return redirect('admin/class-schedule')->with('success', 'Successfuly removed all entries!');
        } catch (Exception $ex) {
            return back()->with('error', $ex->getMessage());
        }
    }

    public function post(Request $request)
    {
        $request->validate([
            'section_ids_array' => 'required',
        ]);


        try {
            $sectionIdsArray = array();
            $sectionIdsArray = $request->section_ids_array;
            session([
                'section_ids' => $sectionIdsArray,
            ]);
            return redirect()->route('admin.class-schedule.print');
        } catch (Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
            // something went wrong
        }
    }
}
