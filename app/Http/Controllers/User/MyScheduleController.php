<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Allocation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MyScheduleController extends Controller
{
    //
    public function index()
    {
        $schedules = Auth::user()->allocations;
        return view('user.my-schedule.index', compact('schedules'));
    }
}
