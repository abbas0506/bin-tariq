@extends('layouts.teacher')
@section('page-content')
    <h1>Assessment</h1>
    <div class="bread-crumb">
        <a href="{{ url('/') }}">Home</a>
        <div>/</div>
        <div>Tests</div>
    </div>
    <div class="divider my-3"></div>
    <div class="content-section">
        <!-- page message -->
        @if ($errors->any())
            <x-message :errors='$errors'></x-message>
        @else
            <x-message></x-message>
        @endif

        <div class="grid gap-6 md:w-2/3 mx-auto mt-12">
            @foreach ($tests as $test)
                <a href="{{ route('teacher.test.test-allocations.index', $test) }}"
                    class="flex justify-between items-center p-4 border rounded-lg bg-slate-50 hover:bg-slate-100">
                    <p class="flex-1 text-slate-600">{{ $test->title }}</p>
                    @if ($test->is_open)
                        <div class=""><i class="bi-arrow-right"></i></div>
                    @else
                        <div class="w-12 h-12 rounded-full flex justify-center items-center">
                            <i class="bi-lock-fill text-red-600"></i>
                        </div>
                    @endif

                </a>
            @endforeach




        </div>

        <script type="text/javascript">
            function delme(formid) {

                event.preventDefault();

                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.value) {
                        //submit corresponding form
                        $('#del_form' + formid).submit();
                    }
                });
            }
        </script>
    @endsection
