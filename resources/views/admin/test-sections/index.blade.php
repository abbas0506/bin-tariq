@extends('layouts.admin')
@section('page-content')
    <div class="custom-container">
        <h1>Print Results</h1>
        <div class="bread-crumb">
            <a href="{{ url('/') }}">Dashoboard</a>
            <div>/</div>
            <a href="{{ route('admin.tests.index') }}">Tests</a>
            <div>/</div>
            <div>Results</div>
            <div>/</div>
            <div>Print</div>
        </div>



        <div class="md:w-4/5 mx-auto mt-8">
            <h2 class="text-slate-800">{{ $test->title }}</h2>
            <div class="text-slate-500 text-sm">Created at: {{ $test->created_at->format('d/m/Y') }}</div>
        </div>

        <div class="flex justify-center items-center w-12 h-12 mx-auto rounded-full border">
            <i class="bi-printer"></i>
        </div>


        <div class="grid gap-4 overflow-x-auto md:w-4/5 mx-auto mt-6">

            @foreach ($sections->sortBy('grade') as $section)
                <div class="grid md:grid-cols-2 text-center items-center gap-3 md:p-8 p-4 border rounded">
                    <div class="">Class {{ $section->fullName() }} <br> <span class="text-slate-500 text-sm"><i
                                class="bi-people"></i>
                            {{ $section->students->count() }}</span>
                    </div>

                    <div class="grid gap-1">
                        <a href="{{ route('admin.test.section.result.print', [$test, $section]) }}" target="_blank"
                            class="btn-cyan rounded text-xs md:text-sm">Summary</a>

                        <a href="{{ route('admin.test.section.positions.print', [$test, $section]) }}" target="_blank"
                            class="btn-blue rounded text-xs md:text-sm">Positions</a>
                        <a href="{{ route('admin.test.section.report-cards.print', [$test, $section]) }}" target="_blank"
                            class="btn-sky rounded text-xs md:text-sm">Report Cards</a>
                    </div>
                </div>
            @endforeach

        </div>
    </div>
    </div>
@endsection
