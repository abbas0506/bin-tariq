<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Allocation;
use App\Models\Grade;
use App\Models\Result;
use App\Models\Section;
use App\Models\Test;
use App\Models\TestAllocation;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CollectiveTestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $tests = Test::whereNull('teacher_id')->get();
        return view('admin.tests.index', compact('tests'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $sections = Section::all();
        return view('admin.tests.create', compact('sections'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'title' => 'required',
            'max_marks' => 'required|numeric',
            'sections_array' => 'required',
        ]);

        $sectionIdsArray = array();
        $sectionIdsArray = $request->sections_array;

        // $grades = Grade::whereIn('id', $gradeIdsArray)->get();

        DB::beginTransaction();
        try {
            $test = Test::create([
                'title' => $request->title,
                'max_marks' => $request->max_marks,
            ]);
            $sections = Section::whereIn('id', $sectionIdsArray)->get();
            foreach ($sections as $section) {
                foreach ($section->allocations as $allocation) {
                    $testAllocation = $test->testAllocations()->create([
                        'section_id' => $allocation->section_id,
                        'lecture_no' => $allocation->lecture_no,
                        'subject_id' => $allocation->subject_id,
                        'teacher_id' => $allocation->teacher_id,
                        'max_marks' => $request->max_marks,
                        'test_date' => now(),
                    ]);
                }
            }

            DB::commit();
            return redirect()->route('admin.tests.index')->with('success', 'Successfully created');
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
        $test = Test::findOrFail($id);
        return view('admin.tests.show', compact('test'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $test = Test::findOrFail($id);
        return view('admin.tests.edit', compact('test'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $request->validate([
            'title' => 'required',
        ]);

        $model = Test::findOrFail($id);
        try {
            $model->update($request->all());
            return redirect()->back()->with('success', 'Successfully updated');
        } catch (Exception $ex) {
            return redirect()->back()->withErrors($ex->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $model = Test::findOrFail($id);
        try {
            $model->delete();
            return redirect()->route('admin.tests.index')->with('success', 'Successfully deleted');
        } catch (Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
            // something went wrong
        }
    }
    public function lock(Request $request, string $id)
    {
        //
        $test = Test::findOrFail($id);
        try {
            $test->update([
                'is_open' => false,
            ]);
            return redirect()->back()->with('success', 'Successfully locked');
        } catch (Exception $ex) {
            return redirect()->back()->withErrors($ex->getMessage());
        }
    }
    public function unlock(Request $request, string $id)
    {
        //
        $test = Test::findOrFail($id);
        try {
            $test->update([
                'is_open' => true,
            ]);
            return redirect()->back()->with('success', 'Successfully unlocked');
        } catch (Exception $ex) {
            return redirect()->back()->withErrors($ex->getMessage());
        }
    }
}
