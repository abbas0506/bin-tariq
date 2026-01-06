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
