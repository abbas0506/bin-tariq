@extends('layouts.teacher')
@section('page-content')
    <div class="custom-container">
        <h1>Class: {{ $section->fullName() }}</h1>
        <div class="bread-crumb">
            <a href="{{ url('/') }}">Dashoboard</a>
            <div>/</div>
            <a href="{{ route('teacher.section.attendance.index', $section) }}">Attendance</a>
            <div>/</div>
            <div>Create</div>
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

        <div class="overflow-x-auto bg-white w-full mt-8">
            <h2><i class="bi-clock mr-3"></i>{{ now()->format('d-m-Y') }}</h2>
            <form action="{{ route('teacher.section.attendance.store', [$section]) }}" method="post" class="mt-3">
                @csrf
                <table class="table-auto borderless w-full">
                    <thead>
                        <tr>
                            <th class="w-10">#</th>
                            <th class="w-48 text-left">Name</th>
                            <th class="w-6"><input type="checkbox" id='chkAll' class="rounded" onclick="checkAll()">

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($section->students->sortBy('rollno') as $student)
                            <tr class="tr">
                                <td>{{ $student->rollno }}</td>
                                <td class="text-left text-xs md:text-sm">{{ $student->name }} <br> <span
                                        class="text-slate-400">{{ $student->father_name }}</span></td>
                                <td>
                                    <div class="flex items-center justify-center">
                                        <input type="checkbox" class="w-4 h-4 rounded" name="student_ids_array[]"
                                            value="{{ $student->id }}">
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="text-center mt-8">
                    <a href="{{ route('teacher.section.attendance.index', $section) }}"
                        class="btn-gray rounded py-2 mr-3">Cancel</a>
                    <button type="submit" class="btn-blue rounded py-2">Submit Now</button>
                </div>
            </form>
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
