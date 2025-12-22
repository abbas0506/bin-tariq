<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Assignment;
use App\Models\Teacher;
use App\Models\Test;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PharIo\Manifest\Author;

class DashboardController extends Controller
{
    public function index()
    {
        //
        $tests = Test::all();
        $section = Auth::user()->teacher?->sectionAsIncharge();
        $tasks = Assignment::where('teacher_id', Auth::user()->teacher?->id)
            ->where('status', 0)   // not completed
            ->with('task')
            ->get()
            ->pluck('task');
        // echo Auth::user()->roles()->first()->name;
        return view('teacher.dashboard', compact('section', 'tests','tasks'));
    }

    /**
     * Show the form for creating a new resource.
     */
}
