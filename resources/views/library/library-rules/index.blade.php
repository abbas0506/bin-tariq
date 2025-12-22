@extends('layouts.library')
@section('page-content')
    <div class="custom-container">
        <h2>Library Rules</h2>
        <div class="bread-crumb">
            <a href="{{ url('library') }}">Dashoboard</a>
            <div>/</div>
            <div>Library Rules</div>
            <div>/</div>
            <div>All</div>
        </div>
        <div class="mt-16">

            <!-- page message -->
            @if ($errors->any())
                <x-message :errors='$errors'></x-message>
            @else
                <x-message></x-message>
            @endif
            @php $sr=1; @endphp
            <div class="overflow-x-auto w-full mt-2">
                <table class="table-fixed w-full">
                    <thead>
                        <tr class="border-b border-slate-200">
                            <th class="w-12">Sr</th>
                            <th class="w-32">Reader Type</th>
                            <th class="w-20">Max Books</th>
                            <th class="w-20">Max Days</th>
                            <th class="w-20">Fine / Day</th>
                            <th class="w-20">Edit</th>
                        </tr>
                    </thead>
                    <tbody>


                        @foreach ($libraryRules as $libraryRule)
                            <tr class="tr">

                                <td>{{ $sr++ }}</td>
                                <td>
                                    @if ($libraryRule->user_type == 'App\Models\Student')
                                        Student
                                    @else
                                        Teacher
                                    @endif
                                </td>
                                <td>{{ $libraryRule->max_books }}</td>
                                <td>{{ $libraryRule->max_days }}</td>
                                <td>{{ $libraryRule->fine_per_day }}</td>
                                <td>
                                    <a href="{{ route('library.library-rules.edit', $libraryRule) }}"><i
                                            class="bx  bx-pencil text-green-600"></i></a>
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
