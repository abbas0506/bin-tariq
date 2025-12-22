@extends('layouts.library')
@section('page-content')
<div class="custom-container">
    <h2>Confirm Return</h2>
    <div class="bread-crumb">
        <a href="{{url('library')}}">Dashoboard</a>
        <div>/</div>
        <div>Return</div>
        <div>/</div>
        <div>Confirm</div>
    </div>

    <div class="w-full md:w-3/4 mx-auto mt-16">
        <!-- page message -->
        @if($errors->any())
        <x-message :errors='$errors'></x-message>
        @else
        <x-message></x-message>
        @endif

        @if($bookIssuance)
        <form action="{{route('library.book-return.confirm.post',$bookIssuance)}}" method='post' class="mt-4" onsubmit="return validate(event)">
            @csrf
            @method('PATCH')
            <input type="hidden" name="book_issuance_id" value="{{$bookIssuance->id}}">
            <div class="flex flex-col md:flex-row bg-green-50">
                <div class="w-24 flex justify-center items-center bg-green-100">
                    <i class="bi bi-book"></i>
                </div>
                <div class="flex-1 p-5">
                    <p>{{$bookIssuance->book->title}}</p>
                    <label>{{$bookIssuance->book->author}}, {{$bookIssuance->book->publish_year}}</label>
                    <label for="">Issued On {{$bookIssuance->created_at}}</label>
                </div>
            </div>
            <div class="flex flex-col md:flex-row bg-blue-50 mt-5">
                <div class="w-24 flex justify-center items-center bg-blue-100">
                    <i class="bi bi-person"></i>
                </div>
                <div class="flex-1 p-5">
                    <p for="">{{$bookIssuance->reader->name}}</p>
                    <label for="">
                        @if($bookIssuance->user_type=='App\Models\Student')
                        {{$bookIssuance->reader->section->fullName()}} ({{$bookIssuance->reader->rollno}})
                        @else
                        {{$bookIssuance->reader->designation}}
                        @endif
                    </label>
                </div>
            </div>

            <div class="flex mt-4 float-right">
                <button type="submit" class="btn-teal rounded px-4">Return Book</button>
            </div>

        </form>
        @else
        <div class="flex h-16 px-5 md:px-0 md:h-40 items-center justify-center border rounded-sm">
            <h2 class="text-red-800">The book reference found incorrect! <a href="{{route('library.book-return.scan')}}" class="link ml-8">Go back</a></h2>
        </div>
        @endif

    </div>
</div>
@endsection