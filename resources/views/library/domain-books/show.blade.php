@extends('layouts.library')
@section('page-content')
<div class="custom-container">
    <div class="flex items-center">
        <div class="w-5/6">
            <h2>{{ $domain->name }} / Book</h2>
            <div class="bread-crumb">
                <a href="{{url('library')}}">Dashoboard</a>
                <div>/</div>
                <a href="{{route('library.domain.books.index', $domain)}}">{{ $domain->name }}</a>
                <div>/</div>
                <div>Book</div>

            </div>

        </div>
    </div>
    <div class="container px-5 md:px-48 mt-2 relative">
        <a href="{{ route('library.domain.books.index', $domain) }}" class="absolute top-2 right-2 p-2 hover:bg-slate-200 rounded"><i class="bi-x-lg"></i></a>
        <div class="grid md:grid-cols-2 gap-4 mt-8 ">
            <div class="col-span-2 border-b">
                <label for="">Book</label>
                <h2>{{$book->title}}</h2>
                <p>@ {{$book->author}}</p>
            </div>
            <div>
                <label for="">Pubish year</label>
                <p>{{$book->publish_year}}</p>
            </div>
            <div>
                <label>Copies</label>
                <p>{{$book->num_of_copies}}</p>
            </div>
            <div>
                <label>Price</label>
                <p>{{$book->price}}</p>
            </div>

            <div>
                <label>Language</label>
                <p>{{$book->language->name}}</p>
            </div>

            <div>
                <label>Domain</label>
                <p>{{$book->domain->name}}</p>
            </div>
            <div>
                <label>Book Rack</label>
                <p>{{$book->rack->label}}</p>
            </div>

        </div>

    </div>
</div>
</div>
@endsection