<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\Teacher;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $tasks = Task::all();
        return view('admin.tasks.index', compact('tasks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $teachers=Teacher::all();
        return view('admin.tasks.create', compact('teachers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'description' => 'required',
            'due_date' => 'required|date',
            'grouped' => 'nullable',
            'teacher_ids_array' => 'required_if:grouped,on',
        ]);

        $teacherIdsArray = array();
        $teacherIdsArray = $request->teacher_ids_array;

        // $grades = Grade::whereIn('id', $gradeIdsArray)->get();

        DB::beginTransaction();
        try {
            $task = Task::create([
                'description' => $request->description,
                'due_date' => $request->due_date,
                ]);

            if($request->grouped){
                
                $teacherIdsArray = array();
                $teacherIdsArray = $request->teacher_ids_array;
                // Assign to multiple teachers
                $task->teachers()->attach($teacherIdsArray); // teacher IDs
            }else{
                
                $task->assignments()->create([
                    'teacher_id'=>Auth::user()->teacher?->id,
                ]);
            }
            DB::commit();
            return redirect()->route('admin.tasks.index')->with('success', 'Successfully created');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors($e->getMessage());
            // something went wrong
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
        $task=Task::findOrFail($id);
        return view('admin.tasks.show', compact('task'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        //
        return view('admin.tasks.edit', compact('task'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //
        $request->validate([
           'description' => 'required',
            'due_date' => 'required|date',
        ]);

        $model = Task::findOrFail($id);
        try {
            $model->update($request->all());
            return redirect()->route('admin.tasks.index')->with('success', 'Successfully updated');
        } catch (Exception $ex) {
            return redirect()->back()->withErrors($ex->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        //
        try {
            $task->delete();
            return redirect()->route('admin.tasks.index')->with('success', 'Successfully deleted');
        } catch (Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
            // something went wrong
        }
    }
}
