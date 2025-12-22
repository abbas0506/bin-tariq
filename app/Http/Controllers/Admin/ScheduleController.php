<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Allocation;
use App\Models\Group;
use Illuminate\Http\Request;
use App\Models\Section;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\User;
use Exception;
use Barryvdh\DomPDF\Facade\Pdf as PDF;

class ScheduleController extends Controller
{
    //
    public function index()
    {
        // $sections = Section::all()->sortBy('grade.grade'); //get active sections
        // return view('admin.allocations.index', compact('sections'));
    }

    // create

    public function create($sectionId, $lecture_no)
    {
        $section = Section::findOrFail($sectionId);
        $subjects = Subject::all();
        $teachers = Teacher::all();
        return view('admin.schedule.section-wise.create', compact('section', 'subjects', 'teachers', 'lecture_no'));
    }

    public function store(Request $request, $sectionId, $lecture_no)
    {
        //
        $request->validate([
            'subject_id' => 'required',
            'teacher_id' => 'required|numeric'
        ]);

        try {
            Allocation::create([
                'section_id' => $sectionId,
                'lecture_no' => $lecture_no,
                'subject_id' => $request->subject_id,
                'teacher_id' => $request->teacher_id,
            ]);
            return redirect('admin/class-schedule')->with('success', 'Successfully created');
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
    public function edit($sectionId, $lecture_no, $allocation_id)
    {
        //
        $section = Section::findOrFail($sectionId);
        $subjects = Subject::all();
        $teachers = Teacher::all();

        $allocation = Allocation::findOrFail($allocation_id);
        return view('admin.schedule.section-wise.edit', compact('allocation', 'subjects', 'teachers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $sectionId, $lecture_no, $allocationId)
    {
        //
        $request->validate([
            'subject_id' => 'required|numeric',
            'teacher_id' => 'required|numeric',
        ]);

        $model = Allocation::findOrFail($allocationId);
        try {
            $model->update($request->all());
            return redirect('admin/class-schedule')->with('success', 'Successfully updated');
        } catch (Exception $ex) {
            return redirect()->back()->withErrors($ex->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($sectionId, $lecture_no, $id)
    {
        //
        $model = Allocation::findOrFail($id);
        try {
            $model->delete();
            return redirect()->route('admin.class-schedule')->with('success', 'Successfully deleted');
        } catch (Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
            // something went wrong
        }
    }
}
