@extends('layouts.admin')
@section('page-content')

<div class="custom-container">
    <h1>Groups Management</h1>
    <div class="bread-crumb">
        <a href="/">Home</a>
        <div>/</div>
        <a href="{{route('admin.groups.index')}}">Groups</a>
        <div>/</div>
        <div>{{ $group->short }}</div>
        <div>/</div>
        <div>Edit</div>
    </div>

    <div class="md:w-2/3 mx-auto">

        <div class="flex flex-col w-full mt-16">
            <h1 class="text-teal-600">Edit {{ $group->name }}</h1>
            <!-- page message -->
            @if($errors->any())
            <x-message :errors='$errors'></x-message>
            @else
            <x-message></x-message>
            @endif

            <form action="{{route('admin.groups.update', $group)}}" method='post' class="mt-4">
                @csrf
                @method('PATCH')
                <div class="grid grid-cols-1 gap-y-2">
                    <div>
                        <label>Full Name</label>
                        <input type="text" name='name' class="custom-input" placeholder="Software Engineering" value="{{$group->name}}">
                    </div>

                    <div>
                        <label>Short Name <span class="text-sm">(if any)</span></label>
                        <input type="text" name='short' class="custom-input" placeholder="For example: SE" value="{{$group->short}}">
                    </div>
                    <div>
                        <label>Fee</label>
                        <input type="number" name='fee' class="custom-input" min=0 placeholder="3000" value="{{$group->fee}}">
                    </div>

                    <button type="submmit" class="btn-teal rounded p-2 mt-6 w-32">Update Now</button>
                </div>
            </form>



        </div>
    </div>
    @endsection