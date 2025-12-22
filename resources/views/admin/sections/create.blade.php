@extends('layouts.admin')
@section('page-content')
<div class="custom-container">
    <h2>New Class</h2>
    <div class="bread-crumb">
        <a href="{{url('admin')}}">Dashoboard</a>
        <div>/</div>
        <a href="{{route('admin.sections.index')}}">Sections</a>
        <div>/</div>
        <div>New</div>
    </div>

    <!-- page message -->
    @if($errors->any())
    <x-message :errors='$errors'></x-message>
    @else
    <x-message></x-message>
    @endif

    <div class="w-full md:w-3/4 mx-auto mt-8">
        <h1 class="text-teal-600 mt-8">New Class / Section</h1>
        <form action="{{route('admin.sections.store')}}" method='post' class="mt-4" onsubmit="return validate(event)">
            @csrf
            <div class="grid gap-2">
                <div>
                    <label for="">Grade</label>
                    <select name="grade" id="" class="custom-input-borderless">
                        @foreach(range(1,10) as $grade)
                        <option value="{{ $grade }}">{{ $grade }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label>Section Label <span class="text-red-600"> (Leave blank if single section) </span></label>
                    <input type="text" name='name' class="custom-input-borderless" placeholder="A, B, C, ..." value="">
                </div>
            </div>
            <div class="flex justify-end mt-4">
                <button type="submit" class="btn-teal rounded p-2">Create Now</button>
            </div>
        </form>

    </div>
</div>
@endsection