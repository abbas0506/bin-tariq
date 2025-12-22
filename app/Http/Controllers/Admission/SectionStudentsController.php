<?php

namespace App\Http\Controllers\Admission;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\Section;
use App\Models\Student;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SectionStudentsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($id)
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($id)
    {
        //
        $section = Section::findOrFail($id);
        $alreadyIncluded = Student::join('sections', 'section_id', 'sections.id')->where('grade', 11)->pluck('bform');

        $applications = Application::whereNotIn('bform', $alreadyIncluded)->whereNotNull('amount_paid')->get();
        return view('admission.students.create', compact('applications', 'section'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $sectionId)
    {
        //
        $request->validate([
            'application_ids_array' => 'required',
        ]);
        DB::beginTransaction();

        try {
            $section = Section::findOrFail($sectionId);
            $applicationIdsArray = array();
            $applicationIdsArray = $request->application_ids_array;
            $applications = Application::whereIn('id', $applicationIdsArray)->get();
            $rollno = 1;
            foreach ($applications->sortByDesc('obtained_marks') as $application) {
                $section->students()->create([
                    'name' => $application->name,
                    'father_name' => $application->father_name,
                    'bform' => $application->bform,
                    'phone' => $application->phone,
                    'group_id' => $application->group_id,
                    'marks' => $application->obtained_marks,
                    'rollno' => $rollno++,
                ]);
            }
            DB::commit();
            return redirect()->route('admission.sections.show', $section)->with('success', 'Successfully imported!');
        } catch (Exception $e) {
            DB::rollBack();
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
    public function destroy(string $studentId, $sectionId)
    {
        //
        try {
            $section = Section::findOrFail($sectionId);
            $section->students()->find($studentId)->delete();
            return redirect()->route('admission.sections.show', $section)->with('success', 'Successfully deleted!');
        } catch (Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }
    }
}
