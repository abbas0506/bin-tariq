@extends('layouts.library')
@section('page-content')
<div class="custom-container">
    <h2>Edit Library Rule</h2>
    <div class="bread-crumb">
        <a href="{{url('library')}}">Dashoboard</a>
        <div>/</div>
        <a href="{{route('library.library-rules.index')}}">Library Rules</a>
        <div>/</div>
        <div>Edit</div>
    </div>
    <div class="h-96 flex justify-center items-center">
        <div class="w-full md:w-1/2 mx-auto mt-8">
            <!-- page message -->
            @if($errors->any())
            <x-message :errors='$errors'></x-message>
            @else
            <x-message></x-message>
            @endif

            <form action="{{route('library.library-rules.update', $libraryRule)}}" method='post' class="mt-4" onsubmit="return validate(event)">
                @csrf
                @method('PATCH')
                <div class="grid grid-cols-2 md:grid-cols-1 gap-x-4 gap-y-1">
                    <div class="">
                        <label>Max Books *</label>
                        <input type="number" name='max_books' class="custom-input" placeholder="Type here" value="{{$libraryRule->max_books}}">
                    </div>
                    <div class="">
                        <label>Max Days *</label>
                        <input type="number" name='max_days' class="custom-input" placeholder="Type here" value="{{$libraryRule->max_days}}">
                    </div>
                    <div class="">
                        <label>Fine / Day *</label>
                        <input type="number" name='fine_per_day' class="custom-input" placeholder="Type here" value="{{$libraryRule->fine_per_day}}">
                    </div>
                    <div class="flex mt-4">
                        <button type="submit" class="btn-teal rounded p-2">Update Now</button>
                    </div>
            </form>

        </div>
    </div>
</div>
@endsection