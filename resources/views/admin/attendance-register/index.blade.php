@extends('layouts.admin')
@section('page-content')
    <div class="custom-container">
        <h1>Attendance Register</h1>
        <div class="bread-crumb">
            <a href="{{ url('/') }}">Home</a>
            <div>/</div>
            <div>Attendance Register</div>
        </div>

        <div class="md:w-4/5 mx-auto bg-white md:p-8 p-4 rounded border mt-3 relative">

            <!-- page message -->
            @if ($errors->any())
                <x-message :errors='$errors'></x-message>
            @else
                <x-message></x-message>
            @endif
            <form method="POST" action="{{ route('admin.attendance-register.store') }}" target="_blank">
                @csrf

                <label>Year</label>
                <select name="year" required>
                    @foreach ($years as $year)
                        <option value="{{ $year }}">{{ $year }}</option>
                    @endforeach
                </select>

                <hr class="mt-3">

                <label>Months</label><br>
                <div class="grid grid-cols-4 gap-2">
                    @foreach ($months as $num => $name)
                        <div>
                            <label style="margin-right:15px;">
                                <input type="checkbox" name="months[]" value="{{ $num }}">
                                {{ $name }}
                            </label>
                        </div>
                    @endforeach
                </div>
                <br><br>
                <button type="submit" class="btn-blue rounded">Generate PDF</button>
            </form>
        </div>
    </div>
@endsection
