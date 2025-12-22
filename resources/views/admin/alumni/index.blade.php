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
                    <div>Alumni</div>
                </div>
            </div>
        </div>

        <!-- page message -->
        @if ($errors->any())
            <x-message :errors='$errors'></x-message>
        @else
            <x-message></x-message>
        @endif

        <div class="container-light overflow-x-auto px-0">
            <div class="flex items-center justify-between mb-4">
                <div class="flex relative w-full md:w-1/3">
                    <input type="text" id='searchby' placeholder="Search ..." class="custom-search w-full"
                        oninput="search(event)">
                    <i class="bx  bx-search absolute top-2 right-2"></i>
                </div>
            </div>
            <div class="overflow-x-auto w-full mt-8">
                <table class="table table-bordered w-full">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Phone</th>
                            <th>Address</th>
                            <th>Photo</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($alumni as $a)
                            <tr>
                                <td>{{ $loop->index + 1 }}</td>
                                <td>{{ $a->name }}</td>
                                <td>{{ $a->phone }}</td>
                                <td>{{ $a->address }}</td>
                                <td>
                                    @if ($a->photo)
                                        <img src="{{ asset('storage/' . $a->photo) }}" width="32" height="32">
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('admin.alumni.edit', $a) }}" class="btn btn-warning btn-sm"><i
                                            class="bx  bx-pencil"></i></a>
                                    <form action="{{ route('admin.alumni.destroy', $a) }}" method="POST"
                                        style="display:inline-block">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-danger btn-sm" onclick="return confirm('Delete?')"><i
                                                class="bi-trash3"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>
    {{ $alumni->links() }}
@endsection
