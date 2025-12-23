<?php

namespace App\Http\Controllers\Principal;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Section;
use App\Models\Student;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Colors\Rgb\Channels\Red;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
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
        return view('principal.attendance.index', compact('sections', 'date', 'total_presence', 'total_attendance'));
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
        //will auto marks all students present for the date
        //get current date

    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
        $student = Student::find($id);
        return view('principal.attendance.history', compact('student'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
    }
    public function filter(Request $request)
    {
        $request->validate([
            'date' => 'required',
        ]);

        return  redirect()->route('principal.attendance.index')->with('filter_date', $request->date);
    }
    public function clear(Request $request)
    {
        $request->validate([
            'clear_date' => 'required',
        ]);
        Attendance::whereDate('date', $request->clear_date)->delete();
        return  redirect()->route('principal.attendance.index')->with('filter_date', $request->clear_date);
    }
    public function attendanceByDate($sectionId, $date)
    {
        $section = Section::findOrFail($sectionId);
        $attendances = $section->attendances()->whereDate('date', $date)->get();
        return view('principal.attendance.viewbydate', compact('attendances', 'section', 'date'));
    }
}
