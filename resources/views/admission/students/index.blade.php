@extends('layouts.admin')
@section('page-content')
    <div class="custom-container">
        <h1>{{ $section->grade }}-{{ $section->name }}</h1>
        <div class="bread-crumb">
            <a href="{{ url('admin') }}">Dashoboard</a>
            <div>/</div>
            <a href="{{ route('admin.sections.index') }}">Sections</a>
            <div>/</div>
            <div>{{ $section->grade }}</div>
        </div>

        <!-- search -->
        <div class="flex justify-between items-center flex-wrap gap-6 mt-12">
            <div class="flex relative w-full md:w-1/3">
                <input type="text" id='searchby' placeholder="Search ..." class="custom-search w-full"
                    oninput="search(event)">
                <i class="bx  bx-search absolute top-2 right-2"></i>
            </div>
            <div class="flex gap-3 flex-wrap">
                <a href="{{ route('admin.section.students.create', $section) }}"
                    class="text-sm p-2 border hover:bg-teal-400">New <i class="bi bi-person-add text-teal-600"></i></a>
                <a href="{{ url('admin/students/import', $section) }}" class="text-sm p-2 border hover:bg-teal-50">Import <i
                        class="bi bi-file-earmark-excel text-teal-600"></i></a>
                <a href="{{ route('admin.section.lecture.schedule.index', [$section, 0]) }}"
                    class="p-2 border rounded hover:bg-slate-200"><i class="bi-clock text-teal-600"></i></a>
                <a href="{{ route('admin.section.cards.index', $section) }}"
                    class="p-2 border rounded hover:bg-slate-200"><i class="bi-person-badge text-indigo-600"></i></a>
                <form action="{{ route('admin.sections.clean', $section) }}" method="post"
                    onsubmit="return confirmClean(event)">
                    @csrf
                    <button class="btn-red rounded p-2"><i class="bx bx-recycle text-base"></i></button>
                </form>
                <form action="{{ route('admin.sections.destroy', $section) }}" method="post"
                    onsubmit="return confirmDel(event)">
                    @csrf
                    @method('delete')
                    <button class="btn-red rounded p-2"><i class="bx  bx-trash text-base"></i></button>
                </form>
            </div>

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
                        <th class="w-10">Roll No</th>
                        <th class="w-40 text-left">Name</th>
                        <th class="w-40 text-left">Father</th>
                        <th class="w-24">BForm</th>
                        <th class="w-24">Actions</th>
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
                            <td>{{ $student->bform }}</td>
                            <td>
                                <div class="flex items-center justify-center">
                                    <a href="{{ route('admin.section.students.edit', [$section, $student]) }}"><i
                                            class="bx  bx-pencil text-green-600"></i></a>
                                    <span class="text-slate-300 px-2">|</span>
                                    <form action="{{ route('admin.section.students.destroy', [$section, $student]) }}"
                                        method="post" onsubmit="return confirmDel(event)">
                                        @csrf
                                        @method('DELETE')
                                        <button><i class="bx  bx-trash text-red-600"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>

    <script type="text/javascript">
        function confirmDel(event) {
            event.preventDefault(); // prevent form submit
            var form = event.target; // storing the form

            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.value) {
                    form.submit();
                }
            })
        }

        function confirmClean(event) {
            event.preventDefault(); // prevent form submit
            var form = event.target; // storing the form

            Swal.fire({
                title: 'Are you sure?',
                text: "You are going to clean this class!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.value) {
                    form.submit();
                }
            })
        }


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
    </script>
@endsection
