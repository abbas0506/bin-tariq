<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Section;
use Illuminate\Http\Request;

class AttendanceController extends Controller
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
    public function list()
    {
        // load data from current date initially
        $date = session('filter_date') ?? now()->toDateString();
        $sections = Section::withCount([
            'students as attendance_count' => function ($q) use ($date) {
                $q->whereHas('attendances', function ($q2) use ($date) {
                    $q2->whereDate('date', $date);
                })
                    ->where('status', 1); // active students (optional)
            },

            'students as presence_count' => function ($q) use ($date) {
                $q->whereHas('attendances', function ($q2) use ($date) {
                    $q2->whereDate('date', $date)
                        ->where('status', 1); // present
                })
                    ->where('status', 1); // active students
            },
        ])
            ->has('students')
            ->get();


        $total_presence = Attendance::whereDate('date', $date)->where('status', 1)->count();
        $total_attendance = Attendance::whereDate('date', $date)->count();
        return view('attendance.index', compact('sections', 'date', 'total_presence', 'total_attendance'));
    }

    // Filter 
    public function filter(Request $request)
    {
        $request->validate([
            'date' => 'required',
        ]);

        return  redirect()->route('attendance.list')->with('filter_date', $request->date);
    }

    // Clear attendance of selected date
    public function clear(Request $request)
    {
        $request->validate([
            'clear_date' => 'required',
        ]);
        Attendance::whereDate('date', $request->clear_date)->delete();
        return  redirect()->route('attendance.index')->with('filter_date', $request->clear_date);
    }
}
