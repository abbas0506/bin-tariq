@extends('layouts.library')
@section('page-content')
<div class="custom-container">
    <div class="flex items-center">
        <div class="w-5/6">
            <h2>New Rack</h2>
            <div class="bread-crumb">
                <a href="{{url('library')}}">Dashoboard</a>
                <div>/</div>
                <a href="{{route('library.racks.index')}}">Racks</a>
                <div>/</div>
                <div>New</div>
            </div>
        </div>
    </div>

    <div class="h-96 flex justify-center items-center">
        <div class="w-full md:w-3/4 mx-auto mt-8">
            <!-- page message -->
            @if($errors->any())
            <x-message :errors='$errors'></x-message>
            @else
            <x-message></x-message>
            @endif

            <form action="{{route('library.racks.store')}}" method='post' class="mt-4" onsubmit="return validate(event)">
                @csrf
                <div class="grid grid-cols-2 md:grid-cols-3 gap-x-4 gap-y-1">

                    <div class="col-span-2 md:col-span-3">
                        <label>Rack label *</label>
                        <input type="text" name='label' class="custom-input" placeholder="Type here" value="">
                    </div>
                    <div class="flex mt-4">
                        <button type="submit" class="btn-teal rounded p-2">Create Now</button>
                    </div>
            </form>

        </div>
    </div>
</div>
@endsection