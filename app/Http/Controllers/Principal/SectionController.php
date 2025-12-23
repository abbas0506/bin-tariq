<?php

namespace App\Http\Controllers\Principal;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Exception;
use Illuminate\Http\Request;
use App\Imports\StudentImport;
use App\Models\Section;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class SectionController extends Controller
{
    public function index()
    {
        //
        $sections = Section::all();
        return view('principal.sections.index', compact('sections'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        return view('principal.sections.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'name' => 'nullable|max:50',
            'level' => 'required',
        ]);

        try {
            Section::create($request->all());
            return redirect()->route('principal.sections.index')->with('success', 'Successfully created');
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
        $section = Section::findOrFail($id);
        return view('principal.sections.show', compact('section'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $section = Section::find($id);
        return view('principal.sections.edit', compact('section'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $request->validate([
            'name' => 'nullable|max:50',
            'level' => 'required',
        ]);

        try {
            $section = Section::find($id);
            $section->update($request->all());
            return redirect()->route('principal.sections.index')->with('success', 'Successfully created');
        } catch (Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
            // something went wrong
        }
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $model = Section::findOrFail($id);
        try {
            $model->delete();
            return redirect()->route('principal.sections.index')->with('success', 'Successfully deleted');
        } catch (Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
            // something went wrong
        }
    }

    public function clean($id)
    {
        //
        $section = Section::findOrFail($id);
        return view('principal.sections.clean', compact('section'));
    }
    // remove all students
    public function postClean(Request $request, $sectionId)
    {
        //
        $request->validate([
            'student_ids_array' => 'required',
        ]);


        try {
            $studentIdsArray = array();
            $studentIdsArray = $request->student_ids_array;
            // Bulk removal
            Student::whereIn('id', $studentIdsArray)->delete();
            return redirect()->back()->with('success', 'Students removed successfully!');
        } catch (Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
            // something went wrong
        }
    }


    public function export($id)
    {

        // save selected class for later usage at students import actually
        $section = Section::find($id);
        $exportSections = Section::where('id', '!=', $id)->get();
        return view('principal.sections.export', compact('section', 'exportSections'));
    }
    /**
     * import data from excel
     */
    public function postExport(Request $request)
    {
        $request->validate([
            'student_ids_array' => 'required',
        ]);


        try {
            $studentIdsArray = array();
            $studentIdsArray = $request->student_ids_array;
            $request->validate([
                'student_ids_array' => 'required|array',
                'export_section_id' => 'required|integer|exists:sections,id',
            ]);

            // Get selected student IDs
            $studentIdsArray = $request->student_ids_array;

            // Bulk update
            Student::whereIn('id', $studentIdsArray)
                ->update(['section_id' => $request->export_section_id]);

            return redirect()->back()->with('success', 'Students updated successfully!');
        } catch (Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
            // something went wrong
        }
    }
    public function import($id)
    {

        // save selected class for later usage at students import actually
        session(['section_id' => $id]);
        $section = Section::findOrFail($id);
        return view('principal.sections.import', compact('section'));
    }
    /**
     * import data from excel
     */
    public function postImport(Request $request)
    {
        try {
            Excel::import(new StudentImport, $request->file('file'));
            return redirect()->route('principal.sections.index')->with('success', 'Students imported successfully');
        } catch (Exception $ex) {
            return redirect()->back()->withErrors($ex->getMessage());
        }
    }
    public function resetIndex(Section $section)
    {
        return view('principal.sections.reset', compact('section'));
    }

    public function resetAdmNo(Request $request, $id)
    {

        // refresh serial no starting from the start value
        $request->validate([
            'startvalue' => 'required',
        ]);

        // reset all existing admission nos.
        $section = Section::findOrFail($id);
        Student::where('section_id', $id)->update(['admission_no' => null]);

        // Student::whereHas('section', function ($q) use ($section) {
        //     $q->where('grade', $section->level);
        // })->update(['admission_no' => null]);

        $srNo = $request->startvalue;

        DB::beginTransaction();
        try {

            $students = $section->students->sortBy('rollno');
            foreach ($students as $student) {
                $student->admission_no = $srNo;
                $student->save();
                $srNo++;
            }
            DB::commit();
            return redirect()->route('principal.sections.show', $section)->with('success', 'Successfully cleaned');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors($e->getMessage());
            // something went wrong
        }
    }

    public function resetRollNo($id)
    {
        //refresh section rollno

        $srNo = 1;
        DB::beginTransaction();
        try {
            $section = Section::findOrFail($id);
            $students = $section->students->sortByDesc('score')->sortBy('group_id');

            foreach ($students as $student) {
                $student->rollno = $srNo;
                $student->save();
                $srNo++;
            }
            DB::commit();
            return redirect()->route('principal.sections.show', $section)->with('success', 'Successfully re-ordered');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors($e->getMessage());
            // something went wrong
        }
    }
    public function print(Section $section)
    {
        return view('principal.sections.print', compact('section'));
    }
}
