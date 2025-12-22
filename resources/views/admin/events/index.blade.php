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
                <div class="">
                    <a href="{{ route('admin.events.create') }}"
                        class="fixed w-12 h-12 bottom-4 right-4 rounded-full btn-blue flex items-center justify-center"><i
                            class="bi bi-plus text-xl"></i></a>
                </div>
            </div>
            <div class="overflow-x-auto w-full mt-8">
                <table class="table-fixed w-full borderless">
                    <thead>
                        <tr>
                            <th class="text-left">Name</th>
                            <th>Category</th>
                            <th>Detail</th>
                            <th>Date</th>
                            <th>Photo</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($events as $event)
                            <tr>
                                <td class="text-left">{{ $event->name }}</td>
                                <td>{{ $event->category }}</td>
                                <td>{{ $event->detail }}</td>
                                <td>{{ $event->event_date }}</td>
                                <td>
                                    @if ($event->photo)
                                        <img src="{{ asset('storage/' . $event->photo) }}" width="80" class="mx-auto">
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('admin.events.edit', $event) }}"
                                        class="btn-green rounded-full btn-sm">Edit</a>
                                    <form action="{{ route('admin.events.destroy', $event) }}" method="POST"
                                        style="display:inline-block;">
                                        @csrf @method('DELETE')
                                        <button class="btn-red btn-sm rounded-full"
                                            onclick="return confirm('Are you sure?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{ $events->links() }}
        @endsection
