@extends('layouts.app')
@section('page-content')
    <div class="custom-container">
        <h1>Absence History</h1>
        <div class="bread-crumb">
            <a href="{{ url('/') }}">Dashoboard</a>
            <div>/</div>
            <a href="{{ route('section.attendance.index', $section) }}">Attendance</a>
            <div>/</div>
            <div>History</div>
        </div>

        <!-- Absence Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:w-4/5 mx-auto mt-8">
            <!-- Card 1: Current Month Absence -->
            <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-orange-500">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-slate-700 font-semibold text-sm">Current Month</h3>
                    <i class="bi bi-calendar-month text-orange-500 text-2xl"></i>
                </div>
                <div class="flex items-center justify-between">
                    <div class="flex items-baseline gap-2">
                        <span class="text-3xl font-bold text-slate-800">{{ $currentMonthAbsences }}</span>
                        <span class="text-sm text-slate-500">/ {{ $currentMonthTotal }}</span>
                        <span class="text-xs text-slate-600 ml-1">{{ $currentMonthRate }}%</span>
                    </div>
                    @if ($currentMonthTrend === 'up')
                        <i class="bx bx-trending-up text-red-500 text-2xl font-bold"></i>
                    @else
                        <i class="bx bx-trending-down text-green-500 text-2xl font-bold"></i>
                    @endif
                </div>
            </div>

            <!-- Card 2: Overall Session Absence -->
            <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-indigo-500">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-slate-700 font-semibold text-sm">Overall ({{ $sessionStart->format('M Y') }} - Now)</h3>
                    <i class="bi bi-pie-chart text-indigo-500 text-2xl"></i>
                </div>
                <div class="flex items-center justify-between">
                    <div class="flex items-baseline gap-2">
                        <span class="text-3xl font-bold text-slate-800">{{ $totalAbsencesInPeriod }}</span>
                        <span class="text-sm text-slate-500">/ {{ $totalDaysInPeriod }}</span>
                        <span class="text-xs text-slate-600 ml-1">{{ $absenceRateOverall }}%</span>
                    </div>
                    @if ($absenceRateOverall < 15)
                        <span class="text-2xl">😊</span>
                    @else
                        <span class="text-2xl">😔</span>
                    @endif
                </div>
            </div>
        </div>

        <div class="md:w-4/5 mx-auto overflow-x-auto bg-white w-full mt-8">
            <h2>{{ $student->name }} <br><span class="text-slate-500">{{ $student->father_name }}</span></h2>
            @if ($attendances->count())
                <table class="table-auto borderless w-full mt-2">
                    <thead>
                        <tr>
                            <th class="w-10">#</th>
                            <th class="w-48 text-left">Date</th>
                            <th class="w-6">Day</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($attendances as $attendance)
                            <tr class="tr">
                                <td>{{ $loop->index + 1 }}</td>
                                <td class="text-left">{{ $attendance->created_at->format('d-m-Y') }}</td>
                                <td>{{ $attendance->created_at->locale('ur')->isoFormat('dddd') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <h2 class="text-center mt-8 border-y py-2 text-red-600">No data found</h2>
            @endif

        </div>
        <div class="text-center mt-8">
            <a href="{{ route('section.attendance.index', $section) }}" class="btn-blue rounded py-2 px-5">Close</a>
        </div>
    </div>
@endsection
