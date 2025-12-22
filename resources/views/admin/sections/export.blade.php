@extends('layouts.admin')
@section('page-content')
    <div class="custom-container">
        <h1>Move/Export Students</h1>
        <div class="bread-crumb">
            <a href="{{ url('admin') }}">Dashoboard</a>
            <div>/</div>
            <a href="{{ route('admin.sections.index') }}">Sections</a>
            <div>/</div>
            <a href="{{ route('admin.sections.show', $section) }}">{{ $section->fullName() }}</a>
            <div>/</div>
            <div>Export</div>
        </div>

        <form action="{{ route('admin.sections.export.post') }}" method="post">
            @csrf

            <!-- search -->
            <div class="flex relative w-full md:w-1/3 mt-5">
                <input type="text" id='searchby' placeholder="Search ..." class="custom-search w-full"
                    oninput="search(event)">
                <i class="bx  bx-search absolute top-2 right-2"></i>
            </div>

            <!-- page message -->
            @if ($errors->any())
                <x-message :errors='$errors'></x-message>
            @else
                <x-message></x-message>
            @endif

            <div class="overflow-x-auto bg-white w-full mt-8">

                <table class="table-auto borderless w-full">
                    <thead>
                        <tr>
                            <th class="w-8">#</th>
                            <th class="w-40 text-left">Name</th>
                            <th class="w-40 text-left">Father</th>
                            <th class="w-24">Group</th>
                            <th class="w-24">Photo</th>
                            <th class="w-6"><input type="checkbox" id='chkAll' class="rounded" onclick="checkAll()">
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($section->students->sortBy('rollno') as $student)
                            <tr class="tr">
                                <td>{{ $student->rollno }}</td>
                                <td class="text-left"><a
                                        href="{{ route('admin.section.students.show', [$section, $student]) }}"
                                        class="link">{{ $student->name }}</a></td>
                                <td class="text-left">{{ $student->father_name }}</td>
                                <td>{{ $student->group?->namename }}</td>
                                <td><img src="{{ asset('storage/' . $student->photo) }}" alt="photo"
                                        class="rounded mx-auto w-8 h-8"></td>
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
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2">
                <div class="mt-4 w-full">
                    <label for="">Export To</label>
                    <select name="export_section_id" id="" class="custom-input-borderless py-1">
                        @foreach ($exportSections as $exSec)
                            <option value="{{ $exSec->id }}">Class {{ $exSec->fullName() }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <button type="submit" class="btn-blue float-right mt-5 rounded py-2">Move / Export</button>
                </div>
            </div>
        </form>
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
