@extends('layouts.library')
@section('page-content')
<div class="custom-container">
    <h2>Racks / {{$rack->label}}</h2>
    <div class="bread-crumb">
        <a href="{{url('library')}}">Dashoboard</a>
        <div>/</div>
        <a href="{{route('library.racks.index')}}">Racks</a>
        <div>/</div>
        <a href="{{route('library.rack.books.index', $rack)}}">{{ $rack->label}}</a>
        <div>/</div>
        <div>Books</div>
        <div>/</div>
        <div>Edit</div>
    </div>

    <div class="w-full md:w-3/4 mx-auto mt-8">
        <!-- page message -->
        @if($errors->any())
        <x-message :errors='$errors'></x-message>
        @else
        <x-message></x-message>
        @endif

        <form action="{{route('library.rack.books.update', [$rack, $book])}}" method='post' class="mt-4" onsubmit="return validate(event)">
            @csrf
            @method('PATCH')
            <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                <div class="col-span-2 md:col-span-3">
                    <label>Book Title *</label>
                    <input type="text" name='title' class="custom-input" placeholder="Type here" value="{{$book->title}}">
                </div>
                <div class="col-span-2 md:col-span-3">
                    <label>Author *</label>
                    <input type="text" name='author' class="custom-input" placeholder="Type here" value="{{$book->author}}">
                </div>

                <div>
                    <label>Publish Year</label>
                    <input type="number" name='publish_year' class="custom-input" placeholder="Type here" value="{{$book->publish_year}}" min="1800" max="{{date('Y')}}">
                </div>
                <div>
                    <label>How Many Copies? *</label>
                    <input type="number" name='num_of_copies' class="custom-input" placeholder="Type here" value="{{$book->num_of_copies}}" min="1" max="50">
                </div>
                <div>
                    <label>Unit Price *</label>
                    <input type="number" name='price' class="custom-input" placeholder="Type here" value="{{$book->price}}" min="0" max="100000">
                </div>
                <div>
                    <label>Language *</label>
                    <select name="language_id" id="" class="custom-input">
                        @foreach($languages as $language)
                        <option value="{{$language->id}}" @selected($book->language_id==$language->id)>{{$language->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label>Domain *</label>
                    <select name="domain_id" id="" class="custom-input">
                        @foreach($domains as $domain)
                        <option value="{{$domain->id}}" @selected($book->domain_id==$domain->id)>{{$domain->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="flex mt-4">
                <button type="submit" class="btn-teal rounded p-2">Update Now</button>
            </div>
        </form>

    </div>
</div>
@endsection