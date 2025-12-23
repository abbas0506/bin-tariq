<?php

namespace App\Http\Controllers\Principal;

use App\Http\Controllers\Controller;
use App\Models\Assignment;
use App\Models\Task;
use App\Models\user;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AssignmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($id)
    {
        //
        $task = Task::findOrFail($id);
        $taskId = $task->id;
        $users = user::whereDoesntHave('assignments', function ($q) use ($taskId) {
            $q->where('task_id', $taskId);
        })->get();
        return view('principal.tasks.assignments.create', compact('task', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $id)
    {
        //
        $request->validate([
            'user_id' => 'required|numeric',
        ]);
        $task = Task::findOrFail($id);
        try {
            $task->assignments()->create([
                'user_id' => $request->user_id,
                'status' => 0,
            ]); // user IDs

            return redirect()->route('principal.tasks.show', $task)->with('success', "Successfully updated");
        } catch (Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
            // something went wrong
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Assignment $assignment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Assignment $assignment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task, Assignment $assignment)
    {
        //
        try {
            $assignment->update([
                'status' => $assignment->status ? 0 : 1,
            ]);
            return redirect()->back()->with('success', "Successfully updated");
        } catch (Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
            // something went wrong
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task, Assignment $assignment)
    {
        //
        // $model = Assignment::findOrFail($id);
        try {
            $assignment->delete();
            return redirect()->back()->with('success', 'Successfully deleted');
        } catch (Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
            // something went wrong
        }
    }
}
