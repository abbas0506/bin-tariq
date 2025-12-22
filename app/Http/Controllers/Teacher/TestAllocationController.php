<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Teacher;
use App\Models\Test;
use App\Models\TestAllocation;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TestAllocationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($id)
    {
        //

        $teacher = Teacher::where('user_id', Auth::user()->id)->first();
        $testAllocations=$teacher->testAllocations()->where('test_id', $id)->get();
        $test = Test::with('testAllocations')->findOrFail($id);
        return view('teacher.test-allocations.index', compact('test', 'testAllocations'));
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
    public function update(Request $request, $testId, $testAllocationId)
    {
        //
        $testAllocation = TestAllocation::findOrFail($testAllocationId);

        try {
            $testAllocation->update([
                'result_date' => now(),
            ]);
            return redirect()->route('teacher.test-allocation.results.index', $testAllocation)->with('success', 'Successfully submitted');
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
    }
}
