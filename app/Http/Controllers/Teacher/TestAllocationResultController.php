<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Allocation;
use App\Models\Test;
use App\Models\TestAllocation;
use Exception;
use Illuminate\Http\Request;
use App\Models\Result;
use Illuminate\Support\Facades\DB;

class TestAllocationResultController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($id)
    {
        //
        $testAllocation = TestAllocation::with('results')->findOrFail($id);
        // if result already submitted, dont enter edit mode
        if ($testAllocation->result_date)
            return view('teacher.results.show', compact('testAllocation'));
        else
            return view('teacher.results.index', compact('testAllocation'));
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($testAllocationId, $id)
    {
        //
        $result = Result::with('student')->findOrFail($id);
        $testAllocation = TestAllocation::findOrFail($testAllocationId);
        return view('teacher.results.show', compact('testAllocation', 'result'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $testAllocation = TestAllocation::with('results')->findOrFail($id);
        return view('teacher.results.edit', compact('testAllocation'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //

        $request->validate([
            'max_marks' => 'required|numeric|min:1|max:100',
            'result_ids_array' => 'required',
            'obtained_marks_array' => 'required',
        ]);

        $testAllocation = TestAllocation::findOrFail($id);

        $resultIdsArray = array();
        $resultIdsArray = $request->result_ids_array;
        $obtained_marksMarksArray = array();
        $obtained_marksMarksArray = $request->obtained_marks_array;

        DB::beginTransaction();
        try {
            $testAllocation->update([
                'max_marks' => $request->max_marks,
            ]);
            foreach ($resultIdsArray as $key => $id) {
                $result = Result::findOrFail($id);
                $result->update([
                    'obtained_marks' => $obtained_marksMarksArray[$key],
                ]);
            }
            DB::commit();
            return redirect()->route('teacher.test-allocation.results.index', $testAllocation)->with('success', 'Successfully saved');
        } catch (Exception $e) {
            db::rollBack();
            return redirect()->back()->withErrors($e->getMessage());
            // something went wrong
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($testAllocationId, $id)
    {
        //

        try {
            $result = Result::findOrFail($id);
            $result->delete();
            return redirect()->back()->with('success', 'Successfully deleted!');
        } catch (Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }
    }

    public function unlock(Request $request, $id)
    {

        $testAllocation = TestAllocation::findOrFail($id);

        try {
            $testAllocation->update([
                'result_date' => null,
            ]);
            return redirect()->route('admin.test.allocations.index', $testAllocation->test)->with('success', 'Successfully deleted!');
        } catch (Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }
    }
}
