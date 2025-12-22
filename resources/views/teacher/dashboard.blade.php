@extends('layouts.teacher')
@section('page-content')
    <!--welcome  -->
    <div class="flex items-center">
        <div class="flex-1">
            <div class="bread-crumb">
                <div><i class="bi-house"></i></div>
                <div>/</div>
                <div>Home</div>
            </div>
        </div>
        <label class="text-slate-500">{{ today()->format('d/m/Y') }}</label>
    </div>

    <!-- pallets -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-8">
        @if ($section)
            <a href="{{ route('teacher.students.index') }}" class="pallet-box bg-gradient-to-r from-teal-100 to-white ">
                <div class="flex-1">
                    <h2>My Class</h2>
                    <p class="text-xs text-slate-400">Total Strength: {{ $section->students->count() }}

                    </p>
                </div>
                <div class="ico bg-teal-100 text-teal-600">
                    <i class="bi-people"></i>
                </div>
            </a>
        @else
            <a href="{{ route('teacher.my-schedule.index') }}" class="pallet-box bg-gradient-to-r from-teal-100 to-white ">
                <div class="flex-1 items-center">
                    <h2>My Schedule</h2>
                    <p class="text-xs text-slate-400">Lectures Count:
                        {{ Auth::user()->teacher?->allocations->count() }}

                    </p>
                </div>
                <div class="ico bg-teal-100 text-teal-600">
                    <i class="bi-person-workspace"></i>
                </div>
            </a>
        @endif
        <a href="{{ route('teacher.tests.index') }}" class="pallet-box bg-gradient-to-r from-indigo-100 to-white">
            <div class="flex-1 items-center">
                <h2>Assessment</h2>
                <p class="text-xs text-slate-400">Currently Active Tests: {{ $tasks->count() }}</p>
            </div>
            <div class="ico bg-indigo-100 text-indigo-400">
                <i class="bi-file-earmark-text"></i>
            </div>
        </a>

    </div>

    <div
        class="w-full p-5 bg-gradient-to-b  from-sky-100 to-white border border-sky-200 rounded-lg text-xs md:text-sm mt-8">
        <div class="flex items-center gap-x-2">
            <div class="w-6 text-xl text-slate-600"><i class="bi-list-task"></i> </div>
            <div>
                <h2 class="text-slate-600 relative">Pending Tasks <span
                        class="absolute top-0 inline-block w-2 h-2 bg-red-500 rounded-full animate-ping"></span></h2>
                <div class="text-slate-400">
                    Waiting for your response ...
                </div>
            </div>
        </div>
        <hr class="my-2">
        <ul class="grid gap-y-4 mx-auto ml-8">
            @foreach ($tasks as $task)
                <li class="text-slate-600">{{ $task->description }}
                    <br>
                    <span class="text-slate-400 text-xs">Due date: {{ $task->due_date->format('d-m-Y') }}</span>
                </li>
            @endforeach
        </ul>
    </div>
@endsection
