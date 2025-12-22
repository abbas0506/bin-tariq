@extends('layouts.admission')
@section('page-content')

<div class="custom-container">
    <h1>Sections</h1>
    <div class="bread-crumb">
        <a href="/">Dashboard</a>
        <div>/</div>
        <div>Sections</div>
    </div>

    <!-- page message -->
    @if($errors->any())
    <x-message :errors='$errors'></x-message>
    @else
    <x-message></x-message>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 mt-12 w-full md:w-3/4 mx-auto gap-4">
        @foreach($sections as $section)
        <a href="{{route('admission.sections.show',$section)}}" class="p-4 ring-1 shadow-[0_0_20px_rgba(0,100,0,0.2)] rounded-md ">
            <h2>{{ $section->grade }}-{{ $section->name }}</h2>
            <div>{{ $section->students->count() }}</div>
        </a>
        @endforeach
    </div>
</div>
<a href="{{ route('admin.sections.create') }}" class="fixed bottom-8 right-8 flex rounded-full w-12 h-12 btn-blue justify-center items-center text-2xl"><i class="bi bi-plus"></i></a>
@endsection