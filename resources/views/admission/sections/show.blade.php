@extends('layouts.admission')
@section('page-content')
    <div class="custom-container">
        <h1>{{ $section->grade }}-{{ $section->name }}</h1>
        <div class="bread-crumb">
            <a href="{{ url('/') }}">Dashoboard</a>
            <div>/</div>
            <a href="{{ route('admission.sections.index') }}">Sections</a>
            <div>/</div>
            <div>{{ $section->grade }}-{{ $section->name }}</div>
        </div>

        <!-- search -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-3 mt-12">
            <div class="flex relative w-full md:w-1/3">
                <input type="text" id='searchby' placeholder="Search ..." class="custom-search w-full"
                    oninput="search(event)">
                <i class="bx  bx-search absolute top-2 right-2"></i>
            </div>

            <form action="{{ route('admission.sections.refresh.srno', $section) }}" method="post"
                onsubmit="return confirmRefreshAdmissionNo(event)" class="flex items-center gap-x-2">
                @csrf
                <input type="number" value="" class="custom-input w-32 py-0" name='startvalue'
                    placeholder="Start value" required>
                <button class="btn-red rounded">Sr No &nbsp <i class="bi-repeat"></i></button>
            </form>

            <a href="{{ route('admission.sections.refresh.rollno', $section) }}" class="btn-blue rounded">Roll No &nbsp <i
                    class="bi bi-repeat"></i></a>
            <div class="flex space-x-2 items-center">
                <a href="{{ route('admission.section.students.create', $section) }}" class="btn-teal rounded">Export &nbsp <i
                        class="bi bi-upload"></i></a>
                <form action="{{ route('admission.sections.clean', $section) }}" method="post"
                    onsubmit="return confirmClean(event)">
                    @csrf
                    <button class="btn-orange rounded"><i class="bx bx-recycle text-base"></i></button>
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
                        <th class="w-16">Roll No</th>
                        <th class="w-40 text-left">Name</th>
                        <th class="w-40 text-left">father_name</th>
                        <th class="w-24">BForm</th>
                        <th class="w-20">Marks</th>
                        <th class="w-20">Serial #</th>
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
                            <td>{{ $student->score }}</td>
                            <td>{{ $student->admission_no }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>

    <script type="text/javascript">
        function confirmRefreshAdmissionNo(event) {
            event.preventDefault(); // prevent form submit
            var form = event.target; // storing the form

            Swal.fire({
                title: 'Are you sure?',
                text: "Admission No will be refreshed!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, do it!'
            }).then((result) => {
                if (result.value) {
                    form.submit();
                }
            })
        }

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
