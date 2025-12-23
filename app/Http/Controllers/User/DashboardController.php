<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Assignment;
use App\Models\User;
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
        $section = Auth::user()->user?->sectionAsIncharge();
        $tasks = Assignment::where('user_id', Auth::user()->user?->id)
            ->where('status', 0)   // not completed
            ->with('task')
            ->get()
            ->pluck('task');
        // echo Auth::user()->roles()->first()->name;
        return view('user.dashboard', compact('section', 'tests', 'tasks'));
    }

    /**
     * Show the form for creating a new resource.
     */
}
