@extends('layouts.admin')
@section('page-content')
<div class="responsive-container">
    <h1>{{$section->fullName()}} / Student </h1>
    <div class="container md:w-2/3 mx-auto mt-12">
        <div class="content-section relative">
            <a href="{{route('admin.section.students.index',$section)}}" class="absolute top-2 right-2 p-2 hover:bg-slate-200 rounded"><i class="bi-x-lg"></i></a>
            <h2 class="p-4 border border-dashed border-slate-200">{{ $student->name }}</h2>

            <div class="grid grid-cols-1 md:grid-cols-3 w-full md:w-3/4 mx-auto mt-8">

                <div class="col-span-2 p-4">
                    <div class="grid grid-cols-2 gap-x-4 gap-y-1">
                        <!-- <div></div> -->
                        <label for="">Class</label>
                        <div>{{$student->section?->roman()}}</div>
                        <label>Roll No</label>
                        <div>{{$student->rollno}}</div>
                        <label>B Form</label>
                        <div>{{$student->bform}}</div>
                    </div>
                </div>
                <div class="flex justify-center items-center border bg-slate-100 p-4">
                    {!! DNS2D::getBarcodeHTML($student->bform, 'QRCODE',4,4) !!}
                </div>
            </div>
        </div>
        @endsection