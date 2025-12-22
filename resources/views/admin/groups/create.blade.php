@extends('layouts.admin')
@section('page-content')
<div class="responsive-container">
    <h2>Groups</h2>
    <div class="bread-crumb">
        <a href="/">Home</a>
        <div>/</div>
        <a href="{{route('admin.groups.index')}}">Groups</a>
        <div>/</div>
        <div>New</div>
    </div>

    <div class="w-full md:w-3/4 mx-auto mt-12">
        <h1 class="text-teal-600 mt-8">New Group</h1>
        <!-- page message -->
        @if($errors->any())
        <x-message :errors='$errors'></x-message>
        @else
        <x-message></x-message>
        @endif
        <form action="{{route('admin.groups.store')}}" method='post' class="mt-4" onsubmit="return validate(event)">
            @csrf
            <div class="grid grid-cols-1 gap-y-2">
                <div>
                    <label>Full Name</label>
                    <input type="text" name='name' class="custom-input" placeholder="Pre Medical" value="">
                </div>

                <div>
                    <label>Short Name <span class="text-sm">(if any)</span></label>
                    <input type="text" name='short' class="custom-input" placeholder="For example: Medical" value="">
                </div>
                <div>
                    <label>Fee</label>
                    <input type="number" name='fee' class="custom-input" min=0 placeholder="3000" value="">
                </div>
            </div>
            <button type="submmit" class="btn-teal rounded p-2 w-32 mt-6">Update Now</button>
        </form>

    </div>
</div>
@endsection