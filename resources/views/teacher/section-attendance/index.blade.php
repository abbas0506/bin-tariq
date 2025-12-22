@extends('layouts.teacher')
@section('page-content')
    <div class="custom-container">
        <h1>Class: {{ $section->fullName() }}</h1>
        <div class="bread-crumb">
            <a href="{{ url('/') }}">Dashoboard</a>
            <div>/</div>
            <a href="{{ route('teacher.section.attendance.index', $section) }}">Attendance</a>
            <div>/</div>
            <div>{{ $section->fullName() }}</div>
        </div>

        <!-- search -->

        <!-- page message -->
        @if ($errors->any())
            <x-message :errors='$errors'></x-message>
        @else
            <x-message></x-message>
        @endif

        <div class="md:w-4/5 mx-auto bg-white md:p-8 p-4 rounded border mt-12">
            <div class="grid text-center gap-8">
                <h2 class="text-xl md:text-4xl"><i class="bi-people"></i>
                    {{ $present }}/{{ $section->students->count() }}
                    , {{ round(($present / $section->students->count()) * 100, 1) }}%</h2>

                @if ($present)
                    <a href="{{ route('teacher.section.attendance.show', [$section, 1]) }}" class="btn-blue rounded py-2">
                        View Attendance</a>
                @else
                    <a href="{{ route('teacher.section.attendance.create', $section) }}" class="btn-blue rounded py-2">
                        Start Attendance</a>
                @endif

            </div>

        </div>
    </div>
    <script>
        function search(event) {
            var searchtext = event.target.value.toLowerCase();
            var str = 0;
            $('.tr').each(function() {
                if (!(
                        $(this).children().eq(0).prop('outerText').toLowerCase().includes(searchtext) ||
                        $(this).children().eq(1).prop('outerText').toLowerCase().includes(searchtext)
                    )) {
                    $(this).addClass('hidden');
                } else {
                    $(this).removeClass('hidden');
                }
            });
        }

        function checkAll() {

            $('.tr').each(function() {
                if (!$(this).hasClass('hidden'))
                    $(this).children().find('input[type=checkbox]').prop('checked', $('#chkAll').is(':checked'));
                // updateChkCount()
            });
        }
    </script>
@endsection
