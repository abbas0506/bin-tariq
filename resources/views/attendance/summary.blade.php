@extends('layouts.app')
@section('page-content')
    <div class="custom-container">
        <h1>Attendance</h1>
        <div class="bread-crumb">
            <a href="{{ url('/') }}">Home</a>
            <div>/</div>
            <div>Attendance</div>
        </div>

        {{-- clear specific date attendance --}}
        <div class="flex items-center justify-between md:w-4/5 mx-auto bg-white mt-8">
            <input type="date" id='filter_date' class="custom-input-borderless md:w-1/2">
        </div>

        {{-- filter form  --}}
        <form action="{{ route('attendance.filter') }}" method="post" id="form_filter">
            @csrf
            <input type="hidden" name="date" id="date">
        </form>

        <div class="md:w-4/5 mx-auto bg-white md:p-8 p-4 rounded border mt-3 relative">
            <!-- page message -->
            @if ($errors->any())
                <x-message :errors='$errors'></x-message>
            @else
                <x-message></x-message>
            @endif
            <h2><i class="bi-clock mr-3"></i> {{ \Carbon\Carbon::parse($date)->format('d-m-Y') }}</h2>
            <div class="grid mt-8 ">
                @foreach ($sections as $section)
                    <div class="flex justify-between rounded p-5 odd:bg-slate-100">

                        @if ($section->total)
                            <h3>{{ $section->name }} <br>
                                <span class="text-slate-400 font-normal">{{ $section->present }}/{{ $section->total }} --
                                    {{ round(($section->present / $section->total) * 100, 1) }}%</span>
                            </h3>
                            <a href="{{ route('section.attendance.index', $section) }}"
                                class="flex justify-center items-center btn-blue rounded"><i class="bi-eye"></i></a>
                        @else
                            <h3>{{ $section->name }} <br>
                                <span class="text-slate-400 font-normal">0 -- 0%</span>
                            </h3>
                            @if (\Carbon\Carbon::parse($date)->isToday())
                                <a href="{{ route('section.attendance.create', $section) }}"
                                    class="flex justify-center items-center btn-green rounded"><i class="bi-plus"></i></a>
                            @endif
                        @endif
                    </div>
                @endforeach
                @if ($sections->count() > 1 && $overall_total)
                    <div class="p-5">
                        <h3>Overall <br>
                            <span class="text-slate-400 font-normal">{{ $overall_present }}/{{ $overall_total }} --
                                {{ round(($overall_present / $overall_total) * 100, 1) }} %</span>
                        </h3>
                    </div>
                @endif
            </div>
        </div>
    @endsection
    @section('script')
        <script type="module">
            $(document).ready(function() {
                // $('#filter_date').val("{{ $date }}")
                $('#filter_date').on('change', function() {
                    let selected = $(this).val();
                    $('#date').val(selected);
                    $('#form_filter').submit();
                });
            });
        </script>
        <script type="text/javascript">
            function confirmClear(event) {
                event.preventDefault(); // prevent form submit
                var form = event.target; // storing the form

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
                        form.submit();
                    }
                })
            }
        </script>
    @endsection
