@extends('layouts.admin')

@section('page-content')
    <div class="container">
        <div class="bread-crumb">
            <a href="{{ url('admin') }}">Home</a>
            <i class="bx bx-chevron-right"></i>
            <a href="{{ route('admin.users.index') }}">Users</a>
            <i class="bx bx-chevron-right"></i>
            <div>Edit</div>
        </div>

        <!-- page message -->
        @if ($errors->any())
            <x-message :errors='$errors'></x-message>
        @else
            <x-message></x-message>
        @endif
        <div class="container-light">

        </div>
    </div>
    </div>
@endsection
