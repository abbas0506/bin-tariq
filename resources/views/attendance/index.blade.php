@extends('layouts.app')
@section('page-content')
    <div class="custom-container">
        <h1>Class: {{ $section->name }}</h1>
        <div class="bread-crumb">
            <a href="{{ url('/') }}">Dashoboard</a>
            <div>/</div>
            <a href="{{ route('attendance.summary') }}">Attendance</a>
            <div>/</div>
            <div>{{ $section->name }}</div>
        </div>
        <script>
            function search(event) {
                var searchtext = event.target.value.toLowerCase();
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
                });
            }

            function showTab(tab) {
                var presentBtn = document.getElementById('tab-present');
                var absentBtn = document.getElementById('tab-absent');
                var presentList = document.getElementById('present-list');
                var absentList = document.getElementById('absent-list');

                if (tab === 'present') {
                    presentList.classList.remove('hidden');
                    absentList.classList.add('hidden');

                    presentBtn.classList.remove('bg-white', 'border', 'text-slate-700');
                    presentBtn.classList.add('bg-indigo-600', 'text-white');

                    absentBtn.classList.remove('bg-indigo-600', 'text-white');
                    absentBtn.classList.add('bg-white', 'border', 'text-slate-700');
                } else {
                    presentList.classList.add('hidden');
                    absentList.classList.remove('hidden');

                    absentBtn.classList.remove('bg-white', 'border', 'text-slate-700');
                    absentBtn.classList.add('bg-indigo-600', 'text-white');

                    presentBtn.classList.remove('bg-indigo-600', 'text-white');
                    presentBtn.classList.add('bg-white', 'border', 'text-slate-700');
                }
            }

            // initialize default tab on load
            document.addEventListener('DOMContentLoaded', function() {
                var presentCount = parseInt(document.getElementById('count-present').innerText || '0', 10);
                if (presentCount > 0) showTab('present');
                else showTab('absent');
            });
        </script>
        <div class="flex items-center justify-between px-4 mb-4 mt-8 text-xs md:text-sm">
            <div class="flex items-center gap-2 flex-wrap">
                <button id="tab-present" onclick="showTab('present')"
                    class="inline-flex items-center px-4 py-2 rounded-full bg-indigo-600 text-white shadow-sm transition">
                    <i class="bi bi-check-lg mr-2"></i>
                    <span class="font-small">Present</span>
                    <span class="ml-2 text-sm text-indigo-100">({{ $attendances->where('status', 1)->count() }})</span>
                </button>

                <button id="tab-absent" onclick="showTab('absent')"
                    class="inline-flex items-center px-4 py-2 rounded-full bg-white border text-slate-700 shadow-sm transition">
                    <i class="bi bi-x-lg mr-2"></i>
                    <span class="text-sm">Absent</span>
                    <span class="ml-2 text-sm text-slate-500">({{ $attendances->where('status', 0)->count() }})</span>
                </button>
            </div>

            <div class="flex items-center">
                @if (\Carbon\Carbon::parse($date)->isToday())
                    <a href="{{ route('section.attendance.edit', [$section, 1]) }}" aria-label="Edit attendance"
                        class="inline-flex items-center px-3 py-2 rounded-md bg-transparent text-slate-700 border hover:bg-slate-50 hover:border-slate-200 transition">
                        <i class="bx bx-pencil"></i>
                    </a>
                @endif
            </div>
        </div>

        <table class="table-auto borderless w-full mt-4">
            <thead>
                <tr>
                    <th class="w-10">#</th>
                    <th class="text-left">Name</th>
                </tr>
            </thead>

            <tbody id="present-list">
                @foreach ($attendances->where('status', 1) as $attendance)
                    <tr class="tr tr-present">
                        <td>{{ $attendance->student->rollno }}</td>
                        <td class="text-left text-xs md:text-sm ">
                            <a href="{{ route('section.attendance.show', [$section, $attendance]) }}"
                                class="link">{{ $attendance->student->name }}</a>
                            <br>
                            <span class="text-slate-400 text-xs">{{ $attendance->student->father_name }}</span>
                            <br>
                            <span class="text-slate-400 text-xs"><i
                                    class="bi-telephone"></i>{{ $attendance->student->phone }}</span>
                        </td>
                    </tr>
                @endforeach
            </tbody>

            <tbody id="absent-list" class="hidden">
                @foreach ($attendances->where('status', 0) as $attendance)
                    <tr class="tr tr-absent">
                        <td>{{ $attendance->student->rollno }}</td>
                        <td class="text-left text-xs md:text-sm ">
                            <a href="{{ route('section.attendance.show', [$section, $attendance]) }}"
                                class="link">{{ $attendance->student->name }}</a>
                            <br>
                            <span class="text-slate-400 text-xs">{{ $attendance->student->father_name }}</span>
                            <br>
                            <span class="text-slate-400 text-xs"><i
                                    class="bi-telephone"></i>{{ $attendance->student->phone }}</span>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="text-center mt-8">
            <a href="{{ route('attendance.summary') }}" class="btn-blue rounded py-2 px-5">Close</a>
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
