@extends('layouts.library')
@section('page-content')
<div class="custom-container">
    <h2>Print</h2>
    <div class="bread-crumb">
        <a href="{{url('library')}}">Dashoboard</a>
        <div>/</div>
        <div>Print <i class="bi-printer ml-2"></i></div>
    </div>

    <div class="container bg-white p-5 md:p-8 mt-12">
        <!-- page message -->
        @if($errors->any())
        <x-message :errors='$errors'></x-message>
        @else
        <x-message></x-message>
        @endif

        <label for="">Print a Specific QR</label>

        <form action="{{route('library.print.specific-qr')}}" method="get" class="flex items-center gap-x-4">
            @csrf
            <input type="text" name='qr' placeholder="QR Code" class="custom-input text-center text-sm py-2">
            <button type="submit" class="btn-orange py-1"><i class="bi-qr-code"></i></button>
        </form>
    </div>
    <div class="container bg-white p-5 md:p-8 mt-4">
        <ul class="mt-8">
            <li class="border-b py-2 text-xl"><i class="bi-file-earmark-pdf mr-2"></i>*.pdf Format</li>
            <li class="border-b py-3"><a href="{{ route('library.teachers.index') }}" class="link"><i class="bi-arrow-right mx-4"></i>Teachers List & QR</a></li>
            <li class="border-b py-3"><a href="{{ route('library.racks.index') }}" class="link"><i class="bi-arrow-right mx-4"></i>Rack Wise Books List & QR</a></li>
            <li class="border-b py-3"><a href="#" class="link"><i class="bi-arrow-right mx-4"></i>Section Wise Students List, QR & Library Cards</a></li>
            <li class="border-b py-3"><a href="#" class="link"><i class="bi-arrow-right mx-4"></i>List of Delayed Books</a></li>
            <li class="border-b py-3"><a href="#" class="link"><i class="bi-arrow-right mx-4"></i>List of Defaulters</a></li>
            <li class="border-b py-3"><a href="#" class="link"><i class="bi-arrow-right mx-4"></i>List of Black Listed Readers</a></li>
        </ul>

    </div>
</div>
@endsection