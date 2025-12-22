@extends('layouts.admin')
@section('page-content')
<div class="custom-container">
    <h2>Classes / Edit</h2>
    <div class="bread-crumb">
        <a href="{{url('admin')}}">Dashoboard</a>
        <div>/</div>
        <a href="{{route('admin.sections.index')}}">Sections</a>
        <div>/</div>
        <div>Edit</div>
    </div>

    <!-- page message -->
    @if($errors->any())
    <x-message :errors='$errors'></x-message>
    @else
    <x-message></x-message>
    @endif

    <div class="w-full md:w-3/4 mx-auto mt-8">
        <h1 class="text-teal-600 mt-8">Edit Clas</h1>
        <form action="{{route('admin.sections.update', $section)}}" method='post' class="mt-4" onsubmit="return validate(event)">
            @csrf
            @method('PATCH')
            <div class="grid grid-cols-2 gap-2">
                <div>
                    <label>Class Grade</label>
                    <select name="grade" id="" class="custom-input p-2">
                        @forelse($grades as $grade)
                        <option value="{{$grade->id}}" @selected($section->grade==$grade->id)>{{ $grade->roman_name }}</option>
                        @empty
                        <option value="">No group available</option>
                        @endforelse
                    </select>
                </div>
                <div>
                    <label>Section Label </label>
                    <input type="text" name='name' class="custom-input" placeholder="e.g A" value="{{ $section->name }}">
                </div>

                <div>
                    <label>Induction Year</label>
                    <input type="number" name='starts_at' class="custom-input" placeholder="Type here" value="{{date('Y')}}" min="2018" max="{{date('Y')}}">
                </div>
                <div>
                    <label>Incharge</label>
                    <select name="incharge_id" id="" class="custom-input p-2">
                        @forelse($teachers as $teacher)
                        <option value="{{$teacher->id}}" @selected($section->incharge_id == $teacher->id)>{{ $teacher->name }}</option>
                        @empty
                        <option value="">No teacher available</option>
                        @endforelse
                    </select>
                </div>
            </div>
            <div class="flex mt-4">
                <button type="submit" class="btn-teal rounded p-2">Update Now</button>
            </div>
        </form>

    </div>
</div>
@endsection