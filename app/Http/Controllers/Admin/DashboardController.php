<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\Assignment;
use App\Models\Attendance;
use App\Models\Book;
use App\Models\Clas;
use App\Models\Grade;
use App\Models\Section;
use App\Models\Student;
use App\Models\Task;
use App\Models\Teacher;
use App\Models\Test;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $sections = Section::all();
        $students = Student::all();
        $tests = Test::all();
        // admin task have no teacher id
        $assignments = Assignment::where('teacher_id', Auth::user()->teacher?->id)->get();
        $attendances = Attendance::where('date', today())->where('status', 1)->get();
        $applications = Application::all();

        return view('admin.dashboard', compact('sections', 'students', 'tests', 'attendances','assignments'));
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
