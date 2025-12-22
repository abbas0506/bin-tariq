@extends('layouts.teacher')
@section('page-content')
    <div class="custom-container">
        <h1>{{ $section->fullName() }} / New Student </h1>
        <div class="bread-crumb">
            <a href="{{ url('/') }}">Home</a>
            <div>/</div>
            <a href="{{ route('teacher.students.index', $section) }}">{{ $section->fullName() }}</a>
            <div>/</div>
            <div>Students / New</div>
        </div>

        <div class="content-section relative">
            <div class="w-full md:w-2/3 mx-auto mt-8">
                <!-- page message -->
                @if ($errors->any())
                    <x-message :errors='$errors'></x-message>
                @else
                    <x-message></x-message>
                @endif

                <form action="{{ route('teacher.students.store') }}" method='post' class="mt-4"
                    onsubmit="return validate(event)">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="md:col-span-2">
                            <label>Name *</label>
                            <input type="text" name='name' class="custom-input" placeholder="Type here">
                        </div>
                        <div>
                            <label>Father</label>
                            <input type="text" name='father_name' class="custom-input" placeholder="Type here">
                        </div>
                        <div>
                            <label>Phone</label>
                            <input type="text" name='phone' id='phone' class="custom-input phone"
                                placeholder="Type here">
                        </div>
                        <div class="">
                            <label>BForm *</label>
                            <input type="text" name='bform' id='cnic' class="custom-input cnic"
                                placeholder="Type here">
                        </div>
                        <div class="">
                            <label>Roll No *</label>
                            <input type="text" name='rollno' class="custom-input" placeholder="Type here">
                        </div>
                    </div>
                    <div class="text-right text-sm mt-8">
                        <!-- close button -->
                        <a href="{{ route('teacher.students.index', $section) }}" class="btn-gray py-2 rounded">Cancel</a>
                        <button type="submit" class="btn-teal p-2 rounded">Create Now</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
@endsection
@section('script')
    <script type="module">
        $(document).ready(function() {

            $('.cnic').on('input', function() {
                let value = $(this).val().replace(/\D/g, '').substring(0, 13);
                let formatted = value;
                if (value.length > 5) formatted = value.substring(0, 5) + '-' + value.substring(5);
                if (value.length > 12) formatted = formatted.substring(0, 13) + '-' + value.substring(12);
                $(this).val(formatted);
            });

            // Auto-insert dash for Phone
            $('.phone').on('input', function() {
                let value = $(this).val().replace(/\D/g, '').substring(0, 12);
                let formatted = value;
                if (value.length > 4) formatted = value.substring(0, 4) + '-' + value.substring(4);
                $(this).val(formatted);
            });

        });
    </script>
@endsection
