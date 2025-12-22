<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Allocation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MyScheduleController extends Controller
{
    //
    public function index()
    {
        $schedules = Allocation::where('teacher_id', Auth::user()->teacher?->id)->get();
        return view('teacher.my-schedule.index', compact('schedules'));
    }
}
