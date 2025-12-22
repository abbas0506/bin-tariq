@extends('layouts.admin')
@section('page-content')
<div class="custom-container">
    <h1>{{$section->fullName()}} / New Student </h1>
    <div class="bread-crumb">
        <a href="{{url('admin')}}">Dashoboard</a>
        <div>/</div>
        <a href="{{route('admin.sections.index')}}">Sections</a>
        <div>/</div>
        <a href="{{route('admin.section.students.index', $section)}}">{{$section->fullName()}}</a>
        <div>/</div>
        <div>Students / New</div>
    </div>

    <div class="content-section relative">
        <!-- close button -->
        <a href="{{ route('admin.section.students.index', $section) }}" class="absolute top-2 right-2 p-2 hover:bg-slate-200 rounded"><i class="bi-x-lg"></i></a>

        <div class="w-full md:w-2/3 mx-auto mt-8">
            <!-- page message -->
            @if($errors->any())
            <x-message :errors='$errors'></x-message>
            @else
            <x-message></x-message>
            @endif

            <form action="{{route('admin.section.students.store', $section)}}" method='post' class="mt-4" onsubmit="return validate(event)">
                @csrf
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label>Name *</label>
                        <input type="text" name='name' class="custom-input" placeholder="Type here">
                    </div>
                    <div>
                        <label>Father</label>
                        <input type="text" name='father_name' class="custom-input" placeholder="Type here">
                    </div>
                    <div class="">
                        <label>CNIC *</label>
                        <input type="text" name='bform' class="custom-input" placeholder="Type here">
                    </div>
                    <div class="">
                        <label>Roll No *</label>
                        <input type="text" name='rollno' class="custom-input" placeholder="Type here">
                    </div>
                </div>
                <div class="text-right mt-8">
                    <button type="submit" class="btn-teal rounded p-2">Create Now</button>
                </div>
            </form>

        </div>
    </div>
</div>
@endsection