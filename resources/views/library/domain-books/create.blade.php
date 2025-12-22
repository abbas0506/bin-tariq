@extends('layouts.library')
@section('page-content')
<div class="custom-container">
    <div class="flex items-center">
        <div class="w-5/6">
            <h2>{{ $domain->name }} / New Book</h2>
            <div class="bread-crumb">
                <a href="{{url('library')}}">Dashoboard</a>
                <div>/</div>
                <a href="{{route('library.domain.books.index', $domain)}}">{{ $domain->name }}</a>
                <div>/</div>
                <div>Books</div>
                <div>/</div>
                <div>New</div>
            </div>

        </div>
    </div>

    <div class="w-full md:w-3/4 mx-auto mt-12">
        <!-- page message -->
        @if($errors->any())
        <x-message :errors='$errors'></x-message>
        @else
        <x-message></x-message>
        @endif

        <form action="{{route('library.domain.books.store', $domain)}}" method='post' class="mt-4" onsubmit="return validate(event)">
            @csrf
            <!-- <input type="hidden" name="domain_id" value="{{ $domain->id }}"> -->
            <div class="grid grid-cols-2 md:grid-cols-3 gap-x-4 gap-y-1">
                <div class="col-span-2 md:col-span-3">
                    <label>Book Title *</label>
                    <input type="text" name='title' class="custom-input" placeholder="Type here" value="">
                </div>
                <div class="col-span-2 md:col-span-3">
                    <label>Author *</label>
                    <input type="text" name='author' class="custom-input" placeholder="Type here" value="">
                </div>
                <div>
                    <label>Publish Year</label>
                    <input type="number" name='publish_year' class="custom-input" placeholder="Type here" value="{{date('Y')}}" min="1900" max="{{date('Y')}}">
                </div>
                <div>
                    <label>How Many Copies? *</label>
                    <input type="number" name='num_of_copies' class="custom-input" placeholder="Type here" value="1" min="1" max="50">
                </div>
                <div>
                    <label>Unit Price *</label>
                    <input type="number" name='price' class="custom-input" placeholder="Type here" value="0" min="0" max="100000">
                </div>
                <div>
                    <label>Language *</label>
                    <select name="language_id" id="" class="custom-input">
                        @foreach($languages as $language)
                        <option value="{{$language->id}}" @selected($language->id==session('recent_language_id'))>{{$language->name}}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label>Book Rack *</label>
                    <select name="rack_id" id="" class="custom-input">
                        <option value="">Select --</option>
                        @foreach($racks as $rack)
                        <option value="{{$rack->id}}" @selected($rack->id==session("recent_rack_id"))>{{$rack->label}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="flex mt-4">
                <button type="submit" class="btn-teal rounded p-2">Create Now</button>
            </div>
        </form>

    </div>
</div>
@endsection