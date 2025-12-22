<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Carbon\Carbon;

class AttendanceRegisterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //

        $years = range(now()->year, now()->year + 1);
        $months = [
            1 => 'January',
            2 => 'February',
            3 => 'March',
            4 => 'April',
            5 => 'May',
            6 => 'June',
            7 => 'July',
            8 => 'August',
            9 => 'September',
            10 => 'October',
            11 => 'November',
            12 => 'December',
        ];

        return view('admin.attendance-register.index', compact('years', 'months'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create() {}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $teachers = Teacher::all()->sortBy('seniority');
        $teacherChunks = $teachers->chunk(4)->map(function ($chunk) {
            return $chunk->pad(4, null);
        });
        // $teacherChunks = $teachers->chunk(4);
        set_time_limit(0); // 🔥 no timeout
        ini_set('memory_limit', '512M');

        $year = $request->year;
        $months = collect($request->months)->sort();

        $holidays = [
            '02-05' => 'Kashmir Day',
            '05-01' => 'Labour Day',
            '08-14' => 'Independence Day',
            '12-25' => 'Quaid-e-Azam Day',
        ];

        $holidayMap = [];

        foreach ($holidays as $md => $name) {
            [$month, $day] = explode('-', $md);

            $holidayMap[(int)$month][(int)$day] = $name;
        }

        // Build months data

        $monthData = $months->map(function ($month) use ($year) {
            $date = Carbon::create($year, $month, 1);

            return [
                'month_number' => $month,
                'month_name' => $date->format('F'),
                'month_days' => $date->daysInMonth,
            ];
        });


        $pdf = PDF::loadView('admin.attendance-register.pdf', compact(
            'teacherChunks',
            'monthData',
            'year',
            'holidayMap'
        ))->setPaper('A4', 'portrait');








        return $pdf->stream("Teacher_Attendance_Register_$year.pdf");
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
