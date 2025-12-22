@extends('layouts.admin')
@section('page-content')


<div class="custom-container">
    <h2>Import Students to {{ $section->fullName() }}</h2>
    <div class="bread-crumb">
        <a href="{{url('admin')}}">Cancel & Go Back</a>
    </div>

    <div class="content-section relative  p-5 md:p-12">
        <a href="{{route('admin.section.students.index',$section)}}" class="absolute top-2 right-2 p-2 hover:bg-slate-200 rounded"><i class="bi-x-lg"></i></a>
        <!-- page message -->
        @if($errors->any())
        <x-message :errors='$errors'></x-message>
        @else
        <x-message></x-message>
        @endif

        <!-- smaple format for .xlsx -->
        <div class="collapsible">
            <div class="head border border-dashed mt-8">
                <div class="flex items-center space-x-2">
                    <i class="bx bxs-chevron-down bx-burst text-blue-600"></i>
                    <h2 class=""><span class="text-slate-600 text-xs">Excel sheet format?</span></h2>
                </div>
            </div>

            <div class="body">
                <p>Please ensure that excel file is in proper format as following</p>
                <table class="table-auto w-full">
                    <thead>
                        <tr class="text-sm">
                            <th>rollno</th>
                            <th>name</th>
                            <th>Father</th>
                            <th>bform</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>Ali Hamza</td>
                            <td>Qadir Khan</td>
                            <td>3640212345670</td>

                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>

                    </tbody>
                </table>

            </div>
        </div>
        <form action="{{url('admin/students/import')}}" method="POST" enctype="multipart/form-data" class="flex flex-col">
            @csrf

            <div class="flex flex-col border rounded-sm bg-gray-100 p-3">
                <label for="upload" class="">Please upload an Excel file</label>
                <input type="file" name='file' class="mt-3" id='upload'>

            </div>

            <div class="flex items-center space-x-4 mt-6">
                <button type="submit" class="btn-teal rounded p-2 w-24">Import</button>
            </div>

        </form>
    </div>

    @endsection