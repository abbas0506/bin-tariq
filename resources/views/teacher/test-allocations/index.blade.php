@extends('layouts.teacher')
@section('page-content')
    <h1>{{ $test->title }}</h1>
    <div class="bread-crumb">
        <a href="{{ url('/') }}">Home</a>
        <div>/</div>
        <a href="{{ route('teacher.tests.index') }}">Tests</a>
        <div>/</div>
        <div>Subjects</div>
    </div>
    <div class="divider my-3"></div>
    @php
        $colors = config('globals.colors');
    @endphp

    <div class="content-section">

        <!-- page message -->
        @if ($errors->any())
            <x-message :errors='$errors'></x-message>
        @else
            <x-message></x-message>
        @endif

        @if (Auth::user()->teacher?->isIncharge())
            @php $section = Auth::user()->teacher->sectionAsIncharge(); @endphp
            <h2 class="mt-8 flex items-center"><i class="bi-diagram-3 mr-2"></i> My Class: {{ $section->fullName() }}
            </h2>
            <div class="flex flex-col md:flex-row flex-wrap text-xs md:text-sm items-center gap-1 md:gap-4 mt-4">
                <div class="flex justify-center items-center w-10 h-10 p-3 rounded-full bg-teal-200">
                    <i class="bi-printer text-xl"></i>
                </div>

                <a href="{{ route('shared.test.section.result.print', [$test, $section]) }}" target="_blank"
                    class="link px-2">Result Summary</a>
                <a href="{{ route('shared.test.section.positions.print', [$test, $section]) }}" target="_blank"
                    class="link px-2">Class Positions</a>
                <a href="{{ route('shared.test.section.report-cards.print', [$test, $section]) }}" target="_blank"
                    class="link px-2">Result Cards</a>
            </div>
            <div class="divider mt-8"></div>
        @endif

        <h2 class="mt-8"><i class="bi-book mr-2"></i> My Subjects
            @if ($testAllocations->count())
                <span class="text-xs ml-3">
                    {{ $testAllocations->whereNotNull('result_date')->count() }}/{{ $testAllocations->count() }}
                    ({{ round(($testAllocations->whereNotNull('result_date')->count() / $testAllocations->count()) * 100, 0) }}%)</span>
            @endif
        </h2>
        <div class="overflow-x-auto w-full mt-4">
            <table class="table-fixed borderless w-full">
                <thead>
                    <tr>
                        <th class="w-8">Sr</th>
                        <th class="w-48 text-left">Subject</th>

                    </tr>
                </thead>
                <tbody>
                    @foreach ($testAllocations as $testAllocation)
                        <tr class="tr @if ($testAllocation->hasBeenSubmitted()) submitted @endif">
                            <td>{{ $loop->index + 1 }}</td>
                            <td class="text-left">
                                <a href="{{ route('teacher.test-allocation.results.index', $testAllocation) }}"
                                    class="flex items-center link">
                                    {{ $testAllocation->subject->name }} - {{ $testAllocation->section->fullName() }}
                                    @if ($testAllocation->hasBeenSubmitted())
                                        <i class="bi-check text-teal-600"></i>
                                    @endif
                                </a>
                                <label class="text-slate-400">Marks: {{ $testAllocation->max_marks }} <i
                                        class="bi-person ml-3"></i>
                                    {{ $testAllocation->appearingStudents->count() }}</label>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
