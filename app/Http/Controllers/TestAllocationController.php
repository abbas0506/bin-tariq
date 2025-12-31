<?php

namespace App\Http\Controllers;

use App\Models\Allocation;
use App\Models\Section;
use App\Models\User;
use App\Models\Test;
use App\Models\TestAllocation;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TestAllocationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($id)
    {
        //
        $test = Test::findOrFail($id);
        $testAllocations = $test->testAllocations;
        return view('tests.show', compact('test'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($id)
    {
        //
        $test = Test::findOrFail($id);

        #identify classes/section of this test
        $sectionIds = $test->testAllocations->pluck('section_id')->unique()->toArray();
        $allocations = Allocation::whereIn('section_id', $sectionIds)->get();


        $unallocated = Allocation::whereIn('section_id', $sectionIds)
            ->whereNotExists(function ($query) use ($test) {
                $query->select(DB::raw(1))
                    ->from('test_allocations')
                    ->where('test_allocations.test_id', $test->id)
                    ->whereColumn('test_allocations.section_id', 'allocations.section_id')
                    ->whereColumn('test_allocations.lecture_no', 'allocations.lecture_no')
                    ->whereColumn('test_allocations.subject_id', 'allocations.subject_id');
            })
            ->get();

        return view('tests.test-allocations.create', compact('test', 'unallocated'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $testId)
    {
        //
        $request->validate([
            'allocation_id' => 'required|numeric',
        ]);

        $test = Test::findOrFail($testId);
        $allocation = Allocation::findOrFail($request->allocation_id);
        try {
            $test->testAllocations()->create([
                'section_id' => $allocation->section_id,
                'lecture_no' => $allocation->lecture_no,
                'subject_id' => $allocation->subject_id,
                'user_id' => $allocation->user_id,
                'max_marks' => $test->max_marks,
                'test_date' => $test->test_date,
            ]);
            return redirect()->route('test.allocations.index', $test)->with('success', 'Successfully created');
        } catch (Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
            // something went wrong
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($testId, $id)
    {
        //
        $test = Test::findOrFail($testId);
        $testAllocation = TestAllocation::findOrFail($id);
        return view('tests.test-allocations.show', compact('test', 'testAllocation'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit($testId, $id)
    {
        //
        $test = Test::findOrFail($testId);
        $testAllocation = TestAllocation::findOrFail($id);
        $users = User::whereHas('roles', function ($q) {
            $q->where('name', 'teacher');
        })->get();
        return view('tests.test-allocations.edit', compact('test', 'testAllocation', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $testId, string $id)
    {
        //
        $request->validate([
            'max_marks' => 'required|numeric|min:1',
            'user_id' => 'required',
        ]);

        $test = Test::findOrFail($testId);
        try {


            if ($request->unlock) {
                $test->testAllocations()->findOrFail($id)->update([
                    // 'max_marks' => $request->max_marks,
                    'result_date' => null,
                ]);
            } else {
                $test->testAllocations()->findOrFail($id)->update([
                    'user_id' => $request->user_id,
                    'max_marks' => $request->max_marks,
                ]);
            }
            return redirect()->route('test.test-allocations.index', $test)->with('success', 'Successfully created');
        } catch (Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
            // something went wrong
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($testId, string $id)
    {
        //
        $model = TestAllocation::findOrFail($id);
        try {
            $model->delete();
            return redirect()->route('tests.show', $testId)->with('success', 'Successfully deleted');
        } catch (Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
            // something went wrong
        }
    }


    public function lock(Request $request, $id)
    {
        //
        $testAllocation = TestAllocation::findOrFail($id);
        try {
            $testAllocation->update([
                'result_date' => now(),
            ]);
            return redirect()->back()->with('success', 'Successfully locked');
        } catch (Exception $ex) {
            return redirect()->back()->withErrors($ex->getMessage());
        }
    }
    public function unlock(Request $request, $id)
    {
        //
        $testAllocation = TestAllocation::findOrFail($id);
        try {
            $testAllocation->update([
                'result_date' => null,
            ]);
            return redirect()->back()->with('success', 'Successfully unlocked');
        } catch (Exception $ex) {
            return redirect()->back()->withErrors($ex->getMessage());
        }
    }
}
