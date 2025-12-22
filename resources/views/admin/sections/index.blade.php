@extends('layouts.admin')
@section('page-content')
    <div class="custom-container">
        <h1>Classes</h1>
        <div class="bread-crumb">
            <a href="{{ url('/') }}">Dashoboard</a>
            <div>/</div>
            <div>Classes</div>
            <div>/</div>
            <div>All</div>
        </div>
        <div class="md:w-4/5 mx-auto bg-white md:p-8 p-4 rounded border mt-8">
            <table class="table-auto borderless w-full mt-5">
                <thead>
                    <tr class="tr">
                        <th class="text-left">Class</th>
                        <th class="w-24">Strength</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($sections->sortBy('grade') as $section)
                        <tr class="tr">
                            <td class="text-left"><a href="{{ route('admin.sections.show', $section) }}"
                                    class="link">{{ $section->fullName() }}</a>
                                @if ($section->students()->createdToday()->count())
                                    <span class="text-green-600 text-xs ml-2"><i
                                            class="bi-arrow-up"></i>{{ $section->students()->createdToday()->count() }}</span>
                                @endif
                            </td>
                            <td>{{ $section->students->count() }}</td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>
    <a href="{{ route('admin.sections.create') }}"
        class="fixed bottom-8 right-8 flex rounded-full w-12 h-12 btn-blue justify-center items-center text-2xl"><i
            class="bi bi-plus"></i></a>
@endsection
