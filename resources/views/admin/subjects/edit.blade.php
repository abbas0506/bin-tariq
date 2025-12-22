@extends('layouts.admin')
@section('page-content')
<div class="custom-container">
    <h2>Edit Subjects</h2>
    <div class="bread-crumb">
        <a href="/">Home</a>
        <div>/</div>
        <a href="{{route('admin.subjects.index')}}">subjects</a>
        <div>/</div>
        <div>New</div>
    </div>

    <div class="flex h-80 justify-center items-center w-full md:w-1/2 mx-auto">
        <!-- page message -->
        @if($errors->any())
        <x-message :errors='$errors'></x-message>
        @else
        <x-message></x-message>
        @endif
        <form action="{{route('admin.subjects.update',$subject)}}" method='post' class="w-full" onsubmit="return validate(event)">
            @csrf
            @method('PATCH')
            <div class="grid gap-4">
                <div class="w-1/2">
                    <label>Short Name</label>
                    <input type="text" name='short_name' class="custom-input" placeholder="Short name" value="{{$subject->short_name}}">
                </div>
                <div>
                    <label>Full Name</label>
                    <input type="text" name='name' class="custom-input" placeholder="Full name" value="{{$subject->name}}">
                </div>
                <div>
                    <button type="submmit" class="btn-teal rounded p-2 w-32">Update Now</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection