@extends('layouts.app')
@section('page-content')
    <div class="custom-container">
        <h1>New user </h1>
        <div class="bread-crumb">
            <a href="{{ url('/') }}">Dashoboard</a>
            <div>/</div>
            <a href="{{ route('users.index') }}">users</a>
            <div>/</div>
            <div>New</div>
        </div>

        <div class="md:w-4/5 border rounded mx-auto mt-12 p-5 md:p-8 relative">
            <!-- close button -->
            <a href="{{ route('users.index') }}" class="absolute top-2 right-2 p-2 hover:bg-slate-200 rounded"><i
                    class="bi-x-lg"></i></a>

            <div class="w-full mt-8">
                <!-- page message -->
                @if ($errors->any())
                    <x-message :errors='$errors'></x-message>
                @else
                    <x-message></x-message>
                @endif

                <form action="{{ route('users.store') }}" method='post' class="mt-4" onsubmit="return validate(event)">
                    @csrf
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label>Name *</label>
                            <input type="text" name='name' class="custom-input" placeholder="Type here">
                        </div>
                        <div>
                            <label>Father</label>
                            <input type="text" name='father_name' class="custom-input" placeholder="Type here">
                        </div>
                        <div class="">
                            <label>CNIC</label>
                            <input type="text" name='cnic' class="custom-input cnic" placeholder="Type here">
                        </div>
                        <div class="">
                            <label>Phone</label>
                            <input type="text" name='phone' class="custom-input phone" placeholder="Type here">
                        </div>
                        <div class="">
                            <label>Email*</label>
                            <input type="email" name='email' class="custom-input" placeholder="Type here">
                        </div>
                        <div class="">
                            <label>Salary</label>
                            <input type="number" name='salary' class="custom-input" placeholder="Type here">
                        </div>
                    </div>
                    <div class="text-right mt-8">
                        <button type="submit" class="btn-teal rounded p-2">Create Now</button>
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
