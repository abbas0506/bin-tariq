@extends('layouts.library')
@section('page-content')
<div class="custom-container">
    <h2>Issue Book</h2>
    <div class="bread-crumb">
        <a href="{{url('library')}}">Dashoboard</a>
        <div>/</div>
        <div>Issue Book</div>
    </div>

    <div class="w-full md:w-3/4 mx-auto mt-16">
        <!-- page message -->
        @if($errors->any())
        <x-message :errors='$errors'></x-message>
        @else
        <x-message></x-message>
        @endif

        <form action="{{route('library.book-issuance.confirm')}}" method='post' class="mt-4" onsubmit="return validate(event)">
            @csrf

            <input type="hidden" name='book_id' value="{{$book->id}}">
            <input type="hidden" name='copy_no' value="{{$copy_no}}">
            <input type="hidden" name='user_id' value="{{$reader->id}}">
            <input type="hidden" name='user_type' value="{{$readerType}}">

            <div class="flex flex-col md:flex-row bg-green-50">
                <div class="w-24 flex justify-center items-center bg-green-100">
                    <i class="bi bi-book"></i>
                </div>
                <div class="flex-1 p-5">
                    <p>{{$book->title}}</p>
                    <label>{{$book->author}}, {{$book->publish_year}}</label>
                </div>
            </div>

            <div class="flex flex-col md:flex-row bg-blue-50 mt-5">
                <div class="w-24 flex justify-center items-center bg-blue-100">
                    <i class="bi bi-person"></i>
                </div>
                <div class="flex-1 p-5">
                    <p for="">{{$reader->name}}</p>
                    @if($reader instanceof App\Models\Student)
                    Student
                    @else
                    Teacher
                    @endif
                </div>
            </div>
            <div class="mt-6 relative">
                <label for="">Already in possession: {{$reader->bookIssuances()->inPossession()->count()}} book(s) </label>
                @if($reader->bookIssuances()->inPossession()->exists())
                <div class="overflow-x-auto w-full ">
                    @php $sr=1; @endphp
                    <table class="table-auto w-full mt-2 xs">
                        <thead>
                            <tr class="border-b border-slate-200">
                                <th>Sr</th>
                                <th>Title</th>
                                <th>Author</th>
                                <th>Copy #</th>
                                <th>Due Date</th>
                                <th>Latency</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($reader->bookIssuances()->inPossession()->get()->sortByDesc('created_at') as $book_issuance)
                            <tr class="tr">
                                <td class="">{{$sr++}}</td>
                                <td class="text-left">{{$book_issuance->book->title}}</td>
                                <td>{{$book_issuance->book->author}}</td>
                                <td>{{$book_issuance->copy_no}}</td>
                                <td>{{$book_issuance->due_date}}</td>
                                <td>{{$book_issuance->latency()}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @endif
            </div>

            <div class="flex mt-4 float-right">
                <button type="submit" class="btn-teal rounded px-4">Issue Book</button>
            </div>

        </form>

    </div>
</div>
@endsection