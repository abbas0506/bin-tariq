@extends('layouts.admin')
@section('page-content')
    <div class="custom-container">
        <h1>Absence History</h1>
        <div class="bread-crumb">
            <a href="{{ url('/') }}">Dashoboard</a>
            <div>/</div>
            <a href="{{ route('admin.attendance.index') }}">Attendance</a>
            <div>/</div>
            <div>History</div>
        </div>

        <div class="overflow-x-auto bg-white w-full mt-8">
            <h2><i class="bi-person mr-3"></i>{{ $student->name }}</h2>
            <table class="table-auto borderless w-full mt-2">
                <thead>
                    <tr>
                        <th class="w-10">#</th>
                        <th class="w-48 text-left">Date</th>
                        <th class="w-6">Day</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($student->attendances->where('status', 0) as $attendance)
                        <tr class="tr">
                            <td>{{ $loop->index + 1 }}</td>
                            <td class="text-left">{{ $attendance->created_at->format('d-m-Y') }}</td>
                            <td>{{ $attendance->created_at->locale('ur')->isoFormat('dddd') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
        <div class="text-center mt-8">
            <a href="{{ route('admin.attendance.index') }}" class="btn-blue rounded py-2 px-5">Close</a>
        </div>
    </div>
@endsection
