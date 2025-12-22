@extends('layouts.admin')
@section('page-content')

<div class="custom-container">
    <h1>Reset Index</h1>
    <div class="bread-crumb">
        <a href="{{url('admin')}}">Dashoboard</a>
        <div>/</div>
        <a href="{{route('admin.sections.index')}}">Sections</a>
        <div>/</div>
        <a href="{{route('admin.sections.show', $section)}}">{{$section->fullName()}}</a>
        <div>/</div>
        <div>Reset</div>
    </div>

    <!-- page message -->
    @if($errors->any())
    <x-message :errors='$errors'></x-message>
    @else
    <x-message></x-message>
    @endif

    <div class="w-full md:w-1/2 mx-auto shadow-xl rounded-lg p-8 mt-8">
        <h1 class="text-center">Section: {{ $section->fullName() }} ({{ $section->students->count() }})</h1>
        <p class="text-center text-red-600 leading-tight">Reset action occurs on the basis of student score in class. This is destructive activity, do if only you understand the consequences</p>
        <div class="grid place-items-center p-8 gap-3">
            <form action="{{ route('admin.sections.reset.rollno', $section) }}" method="post" onsubmit="return confirmDel(event)">
                @csrf
                <button class="btn-blue rounded px-3 py-4">Reset Roll #</button>
            </form>
        </div>
        <hr>
        <!-- <div class="grid gap-5 p-8"> -->
        <!-- <p class="text-slate-600">Reset section roll numbers on the basis of student score</p> -->
        <form action="{{ route('admin.sections.reset.admno', $section) }}" method="post" class="grid gap-5 p-8" onsubmit="return confirmDel(event)">
            @csrf
            <input type="text" name="startvalue" class="custom-input text-center mx-auto" placeholder="1234" required>
            <button class="btn-blue rounded px-3 py-4">Reset Admission #</button>
        </form>
        <!-- </div> -->
    </div>
</div>

<script type="text/javascript">
    function confirmDel(event) {
        event.preventDefault(); // prevent form submit
        var form = event.target; // storing the form

        Swal.fire({
            title: 'Are you sure?',
            text: "Reset action is destructive!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, perform reset!'
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
</script>

@endsection