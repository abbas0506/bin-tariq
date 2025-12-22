@extends('layouts.library')
@section('page-content')
<div class="custom-container">
    <div class="flex items-center">
        <div class="flex-1">
            <div class="bread-crumb">
                <div>Library</div>
                <div>/</div>
                <div>Dashboard</div>
            </div>
        </div>
        <div class="text-slate-500">{{ today()->format('d/m/Y') }}</div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mt-5">
        <a href="{{route('library.books.index')}}" class="pallet-box">
            <div class="flex-1 ">
                <div class="title">Books</div>
                <div class="h2">{{$books->count()}}</div>
            </div>
            <div class="ico bg-teal-100">
                <i class="bi bi-book text-teal-600"></i>
            </div>
        </a>
        <a href="{{route('library.book-issuance.issued')}}" class="pallet-box">
            <div class="flex-1 ">
                <div class="title">Issued Books</div>
                <div class="h2">{{$bookIssuances->count()}}</div>
            </div>
            <div class="ico bg-blue-100">
                <i class="bi bi-upc text-blue-600"></i>
            </div>
        </a>
        <a href="{{route('library.book-issuance.delayed')}}" class="pallet-box">
            <div class="flex-1">
                <div class="title">Delayed Books</div>
                <div class="h2">{{$bookIssuances->where('due_date', '<' , today())->count()}}</div>
            </div>
            <div class="ico bg-green-100">
                <i class="bi bi-clock-history text-green-600"></i>
            </div>
        </a>
        <a href="{{route('library.book-issuance.default')}}" class="pallet-box">
            <div class="flex-1">
                <div class="title">Defaulters</div>
                <div class="h2">{{$defaulters->count()}}</div>
            </div>
            <div class="ico bg-orange-100">
                <i class="bi bi-person-slash text-orange-600"></i>
            </div>
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 mt-8 gap-6">
        <!-- middle panel  -->
        <div class="md:col-span-2">
            <!-- update news  -->
            <div class="p-4 bg-white">
                <h2>Today's Activity</h2>
                <div class="overflow-x-auto w-full">
                    @php $sr=1; @endphp
                    <table class="table-auto borderless w-full mt-4 xs">
                        <thead>
                            <tr class="">
                                <th>Sr</th>
                                <th>Book</th>
                                <th>Reader</th>
                                <th>Issued On</th>
                                <th>Due On</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach($bookIssuances->where('created_at','>=',today())->sortByDesc('updated_at') as $bookIssuance)
                            <tr class="tr even:bg-transparent border-b">
                                <td>{{$sr++}}</td>
                                <td class="text-left">{{$bookIssuance->book->title}}
                                    <br>
                                    <span class="text-xs text-slate-600">{{$bookIssuance->book->reference()}}-{{$bookIssuance->copy_no}} @ {{$bookIssuance->book->author}}</span>
                                </td>
                                <td class="text-left">
                                    {{$bookIssuance->reader->name}}
                                    <br>
                                    <label for="">
                                        @if($bookIssuance->user_type=='App\Models\Student')
                                        {{$bookIssuance->reader->section->fullName()}} ({{$bookIssuance->reader->rollno}})
                                        @else
                                        {{$bookIssuance->reader->designation}}
                                        @endif
                                    </label>
                                </td>
                                <td>{{$bookIssuance->created_at->format('d/m/Y')}}</td>
                                <td>{{$bookIssuance->due_date->format('d/m/Y')}}</td>
                            </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>

        </div>
        <!-- middle panel end -->
        <!-- right side bar starts -->
        <div class="">
            <div class="bg-sky-100 p-4">
                <h2>Basic Configuration</h2>
                <ul class="mt-2">
                    <li>
                        <a href="{{route('library.domains.index')}}" class="flex items-center p-2">
                            <i class="bi-diagram-3"></i>
                            <span class="ml-3">Domains</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{route('library.racks.index')}}" class="flex items-center p-2">
                            <i class="bi bi-hdd-rack"></i>
                            <span class="ml-3">Racks</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{route('library.library-rules.index')}}" class="flex items-center p-2">
                            <i class="bi bi-bookmark-check"></i>
                            <span class="ml-3">Library Rules</span>
                        </a>
                    </li>

                </ul>
            </div>
        </div>
    </div>
</div>
@endsection