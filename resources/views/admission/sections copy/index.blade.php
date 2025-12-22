@extends('layouts.admission')
@section('page-content')

<div class="custom-container">
    <h1>Sections</h1>
    <div class="bread-crumb">
        <a href="/">Dashboard</a>
        <div>/</div>
        <div>Sections</div>
    </div>

    <!-- page message -->
    @if($errors->any())
    <x-message :errors='$errors'></x-message>
    @else
    <x-message></x-message>
    @endif

    @php $sr=1; @endphp
    <div class="overflow-x-auto w-full mt-8">
        <div class="grid grid-cols-1 md:grid-cols-2 bg-white gap-6">
            @foreach($sections as $section)
            <div class="border p-8">
                <div class="flex items-center bg-slate-100">
                    <a href="{{route('admission.sections.show',$section)}}" class="link text-lg font-bold">{{$section->grade}}-{{ $section->name}}</a>
                    <div class="ml-8"> <i class="bi-people"></i> {{$section->students->count()}}</div>
                </div>

                <div class="flex items-center border-b py-2">
                    <p class="flex-1">Import Students</p>
                    <a href="{{route('admission.section.students.create',$section)}}" class="text-teal-600 hover:text-teal-800"><i class="bi bi-upload"></i></a>
                </div>

                <div class="flex items-center border-b py-2">
                    <p class="flex-1">Clean Section</p>
                    <form action="{{ route('admission.sections.clean', $section) }}" method="post" onsubmit="return confirmClean(event)">
                        @csrf
                        <button><i class="bx bx-recycle text-base text-orange-500"></i></button>
                    </form>
                </div>

                <div class="flex items-center border-b py-2">
                    <p class="flex-1">Refresh Roll Nos </p>
                    <a href="{{ route('admission.sections.refresh.rollno', $section) }}"><i class="bi bi-repeat text-blue-600"></i></a>
                </div>

                <div class="flex items-center border-b py-2">
                    <p class="flex-1">Students List </p>
                    <a href="{{ route('admission.sections.print.listOfStudents', $section) }}" target="_blank"><i class="bi bi-printer text-blue-600"></i></a>
                </div>

                <div class="flex items-center border-b py-2">
                    <p class="flex-1">Attendance List </p>
                    <a href="{{ route('admission.sections.print.attendanceList', $section) }}" target="_blank"><i class="bi bi-printer text-blue-600"></i></a>
                </div>

                <div class="flex items-center border-b py-2">
                    <p class="flex-1">List of Serial Nos.</p>
                    <a href="{{ route('admission.sections.print.listOfSrNo', $section) }}"><i class="bi bi-printer text-blue-600"></i></a>
                </div>
            </div>

            @endforeach
        </div>
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