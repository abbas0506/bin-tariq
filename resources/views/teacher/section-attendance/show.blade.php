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
        <!-- <div class="flex justify-between items-center flex-wrap gap-6 mt-12"> -->
        <div class="flex relative w-full md:w-1/3">
            <input type="text" id='searchby' placeholder="Search ..." class="custom-search w-full" oninput="search(event)">
            <i class="bx  bx-search absolute top-2 right-2"></i>
        </div>

        <!-- page message -->
        @if ($errors->any())
            <x-message :errors='$errors'></x-message>
        @else
            <x-message></x-message>
        @endif

        <div class="flex justify-between items-center px-3 mt-8">
            <h2><i class="bi-clock mr-3"></i>{{ now()->format('d-m-Y') }}</h2>
            <a href="{{ route('teacher.section.attendance.edit', [$section, 1]) }}" class="btn-blue rounded"><i
                    class="bx  bx-pencil"></i></a>
        </div>

        <div class="overflow-x-auto bg-white w-full py-4">
            <table class="table-auto borderless w-full mt-4">
                <thead>
                    <tr>
                        <th class="w-10">#</th>
                        <th class="w-48 text-left">Name</th>
                        <th class="w-10"><i class="bi-exclamation-triangle"></i></th>
                        <th class="w-6"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($attendances->sortBy('status') as $attendance)
                        <tr class="tr">
                            <td>{{ $attendance->student->rollno }}</td>
                            <td class="text-left text-xs md:text-sm ">{{ $attendance->student->name }} <br>
                                <span class="text-slate-400 text-xs">{{ $attendance->student->father_name }}</span>
                                @if (!$attendance->status)
                                    <br>
                                    <span class="text-slate-400 text-xs"><i
                                            class="bi-telephone"></i>{{ $attendance->student->phone }}</span>
                                @endif
                            </td>
                            <td>
                                @if ($attendance->student->currentAbsences()->count())
                                    <span class="text-blue-600 text-xs"> <i
                                            class="bi-arrow-up"></i>{{ $attendance->student->currentAbsences()->count() }}</span>
                                @endif
                                {{ $attendance->student->previousAbsences()->count() ?: '' }}
                            </td>
                            <td>
                                @if ($attendance->status)
                                    <i class="bi-check text-teal-600"></i>
                                @else
                                    <i class="bi-x text-red-600"></i>
                                @endif
                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="text-center mt-8">
                <a href="{{ route('teacher.section.attendance.index', $section) }}"
                    class="btn-blue rounded py-2 px-5">Close</a>
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
