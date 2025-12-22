@extends('layouts.admin')
@section('page-content')
<div class="custom-container">
    <div class="flex flex-wrap items-center gap-2">
        <div class="flex-1">
            <div class="bread-crumb">
                <a href="{{ url('/') }}">Home</a>
                <div>/</div>
                <div>Events</div>
                <div>/</div>
                <div>Edit</div>
            </div>
        </div>
    </div>

    <!-- page message -->
    @if($errors->any())
    <x-message :errors='$errors'></x-message>
    @else
    <x-message></x-message>
    @endif
    <form method="POST" action="{{ route('admin.events.update', $event) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="">
            <label>Photo</label>
            @if($event->photo)
            <img src="{{ asset('storage/' . $event->photo) }}" width="100"><br>
            @endif
            <input type="file" name="photo" class="custom-input">
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
            <div class="">
                <label>Category</label>
                <select name="category" class="custom-input" required>
                    <option value="sports" @selected(old('category', $event->category) == 'sports')>Sports</option>
                    <option value="annual day" @selected(old('category', $event->category) == 'annual day')>Annual Day</option>
                    <option value="prize distribution" @selected(old('category', $event->category) == 'prize distribution')>Prize Distribution</option>
                    <option value="competition" @selected(old('category', $event->category) == 'competition')>Competition</option>
                </select>
            </div>
            <div class="">
                <label>Name</label>
                <input type="text" name="name" class="custom-input" required value="{{ old('name', $event->name) }}">
            </div>

            <div class="">
                <label>Detail</label>
                <textarea name="detail" class="custom-input">{{ old('detail', $event->detail) }}</textarea>
            </div>

            <div class="">
                <label>Event Date</label>
                <input type="date" name="event_date" class="custom-input" required value="{{ old('event_date', $event->event_date) }}">
            </div>


            <div>
                <button class="btn-blue rounded-full px-5">Update</button>
                <a href="{{ route('admin.events.index') }}" class="btn-gray px-5 rounded-full">Back</a>
            </div>
        </div>
    </form>
</div>
@endsection