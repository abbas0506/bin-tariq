<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Section;
use Illuminate\Http\Request;

class SectionAttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($id)
    {
        //
        $section = Section::find($id);
        return view('attendance.index', compact('section'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($id)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $id)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id, $attendanceId)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id, $attendanceId)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id, $attendanceId)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id, $attendanceId)
    {
        //
    }

    // public function attendanceByDate($sectionId, $date)
    // {
    //     $section = Section::findOrFail($sectionId);
    //     $attendances = $section->attendances()->whereDate('date', $date)->get();
    //     return view('attendance.viewbydate', compact('attendances', 'section', 'date'));
    // }
}
