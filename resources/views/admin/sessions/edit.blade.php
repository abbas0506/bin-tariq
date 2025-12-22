@extends('layouts.admin')
@section('page-content')

<div class="custom-container">
    <h1>Session Management</h1>
    <div class="bread-crumb">
        <a href="{{url('admin')}}">Dashoboard</a>
        <div>/</div>
        <a href="{{route('admin.sessions.index')}}">Sessions</a>
        <div>/</div>
        <div>{{ $session->title() }}</div>
        <div>/</div>
        <div>Edit</div>
    </div>

    <div class="flex items-center justify-center w-full h-full">

        <div class="flex flex-col w-full md:w-3/4 mt-16">
            <p><i class="bi bi-gear mr-2"></i><span class="text-lg font-semibold">Session {{$session->title()}}</span></p>
            <hr class="my-3">

            <div class="flex justify-between items-center">
                <div class="flex items-center w-full">
                    <label class="mr-2">Current Status:</label>
                    <div class="flex flex-1 justify-between items-center">

                        @if($session->active==1)
                        <i class="bi bi-toggle2-on text-teal-600 text-lg"></i>
                        <form action="{{route('admin.sessions.update', $session)}}" method='post'>
                            @csrf
                            @method('PATCH')
                            <button type="submmit" class="btn-red">Lock session</button>
                        </form>
                        @else
                        <i class="bi bi-toggle2-off text-red-600 text-lg"></i>
                        <form action="{{route('admin.sessions.update', $session)}}" method='post'>
                            @csrf
                            @method('PATCH')
                            <button type="submmit" class="btn-teal">Unlock session</button>
                        </form>
                        @endif
                    </div>

                </div>
            </div>
        </div>
    </div>
    @endsection