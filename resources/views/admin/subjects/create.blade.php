@extends('layouts.admin')
@section('page-content')
<div class="custom-container">
    <h2>New Subjects</h2>
    <div class="bread-crumb">
        <a href="/">Home</a>
        <div>/</div>
        <a href="{{route('admin.subjects.index')}}">subjects</a>
        <div>/</div>
        <div>New</div>
    </div>

    <div class="md:w-3/4 mx-auto mt-12 bg-white md:p-8 rounded">
        <!-- page message -->
        @if($errors->any())
        <x-message :errors='$errors'></x-message>
        @else
        <x-message></x-message>
        @endif
        <form action="{{route('admin.subjects.store')}}" method='post' class="w-full grid gap-6" onsubmit="return validate(event)">
            @csrf
            <div class="grid gap-4">
                <div class="w-1/2">
                    <label>Short Name</label>
                    <input type="text" name='short_name' class="custom-input" placeholder="Short name" value="">
                </div>
                <div>
                    <label>Full Name</label>
                    <input type="text" name='name' class="custom-input" placeholder="Full name" value="">
                </div>
                <div>
                    <button type="submmit" class="btn-teal rounded p-2 w-32">Create Now</button>
                </div>
            </div>

        </form>

    </div>
</div>
@endsection