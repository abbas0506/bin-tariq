@extends('layouts.app')
@section('page-content')
    <div class="custom-container">
        <h1>Attendance</h1>
        <div class="bread-crumb">
            <a href="{{ url('/') }}">Home</a>
            <div>/</div>
            <div>Attendance</div>
        </div>

        {{-- filter attendance --}}
        <div class="flex items-center justify-between md:w-4/5 mx-auto bg-white mt-8">
            <input type="date" id='filter_date' class="custom-input-borderless md:w-1/2">
        </div>

        {{-- filter form  --}}
        <form action="{{ route('attendance.filter') }}" method="post" id="form_filter">
            @csrf
            <input type="hidden" name="date" id="date">
        </form>

        <div class="md:w-4/5 mx-auto bg-white md:p-8 p-4 rounded border mt-5 relative">
            <!-- page message -->
            @if ($errors->any())
                <x-message :errors='$errors'></x-message>
            @else
                <x-message></x-message>
            @endif
            <h2 class="bg-green-600 text-white px-4 py-1"><i class="bi-clock mr-3"></i>
                {{ \Carbon\Carbon::parse($date)->format('d-m-Y') }}</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 mt-8 gap-3">
                @foreach ($sections as $section)
                    @php
                        $pct = $section->total ? round(($section->present / $section->total) * 100, 1) : 0;
                    @endphp
                    <div class="bg-white rounded-lg p-4 md:p-5 shadow-sm hover:cursor-pointer text-xs md:text-sm">
                        <div class="grid grid-cols-1 md:grid-cols-12 items-center gap-3">
                            <div class="md:col-span-9 flex items-center space-x-4">
                                <div
                                    class="icon w-12 h-12 rounded-full bg-slate-100 flex items-center justify-center text-slate-600">
                                    <i class="bi-people"></i>
                                </div>
                                <div class="flex-1">
                                    <h3 class="text-slate-700">{{ $section->name }}</h3>
                                    <div class="flex items-center space-x-3 mt-1">
                                        <span
                                            class="text-slate-400 font-normal">{{ $section->present ?? 0 }}/{{ $section->total ?? 0 }}</span>
                                        <span class="font-medium text-sm text-green-700">{{ $pct }}%</span>
                                    </div>
                                    <div class="w-full mt-2 bg-slate-100 rounded-full h-2 overflow-hidden">
                                        <div class="h-2 rounded-full bg-green-600" style="width: {{ $pct }}%">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="md:col-span-3 flex items-center justify-end">
                                @if ($section->total)
                                    <a href="{{ route('section.attendance.index', $section) }}"
                                        aria-label="View attendance for {{ $section->name }}"
                                        class="inline-flex items-center p-2 rounded-md border border-slate-200 bg-white text-slate-700 shadow-sm hover:bg-slate-50 hover:scale-105 transition-transform duration-150">
                                        <i class="bi-eye"></i>
                                    </a>
                                @else
                                    @if (\Carbon\Carbon::parse($date)->isToday())
                                        <a href="{{ route('section.attendance.create', $section) }}"
                                            aria-label="Mark attendance for {{ $section->name }}"
                                            class="inline-flex items-center p-2 rounded-md border border-slate-200 bg-white text-slate-700 shadow-sm hover:bg-slate-50 hover:scale-105 transition-transform duration-150">
                                            <i class="bx bx-pencil"></i>
                                        </a>
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            @if ($sections->count() > 1 && $overall_total)
                <div class="p-5 text-right bg-green-50 rounded-lg">
                    <h3>Overall <br>
                        <span class="text-slate-400 font-normal">{{ $overall_present }}/{{ $overall_total }} —
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
