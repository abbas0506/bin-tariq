@extends('layouts.admin')
@section('page-content')
<div class="custom-container">
    <!-- Title     -->
    <h1></h1>
    <div class="flex flex-wrap items-center gap-2">
        <div class="flex-1">
            <div class="bread-crumb">
                <a href="{{ url('/') }}">Home</a>
                <div>/</div>
                <div>Events</div>
                <div>/</div>
                <div>Create</div>
            </div>
        </div>
    </div>

    <!-- page message -->
    @if($errors->any())
    <x-message :errors='$errors'></x-message>
    @else
    <x-message></x-message>
    @endif

    <!-- New Event form -->
    <form method="POST" action="{{ route('admin.events.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
            <div class="">
                <label>Category</label>
                <select type="text" name="category" class="custom-input" required value="{{ old('name') }}">
                    <option value="sports">Sports</option>
                    <option value="annual day">Annual Day</option>
                    <option value="prize distribution">Prize Distribution</option>
                    <option value="competition">Competition</option>
                </select>
            </div>
            <div class="">
                <label>Name</label>
                <input type="text" name="name" class="custom-input" required value="{{ old('name') }}">
            </div>


            <div class="col-span-2">
                <label>Detail</label>
                <textarea name="detail" class="custom-input">{{ old('detail') }}</textarea>
            </div>

            <div class="">
                <label>Event Date</label>
                <input type="date" name="event_date" class="custom-input" required value="{{ old('event_date') }}">
            </div>

            <div class="">
                <label>Photo</label>
                <input type="file" name="photo" class="custom-input">
            </div>
            <div>
                <a href="{{ route('admin.events.index') }}" class="btn-gray px-5 rounded-full">Back</a>
                <button class="btn-blue border px-5 rounded-full">Create</button>
            </div>

        </div>
    </form>

    @endsection