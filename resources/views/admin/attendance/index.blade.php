@extends('layouts.admin')
@section('page-content')
    <div class="custom-container">
        <h1>Attendance</h1>
        <div class="bread-crumb">
            <a href="{{ url('/') }}">Home</a>
            <div>/</div>
            <div>Attendance</div>
        </div>


        {{-- clear specific date attendance --}}
        <div class="md:w-4/5 mx-auto bg-white mt-8">
            <input type="date" id='filter_date' class="custom-input-borderless md:w-3/4">
            {{-- filter form  --}}
            <form action="{{ route('admin.attendance.filter') }}" method="POST" id="form_filter">
                @csrf
                <input type="hidden" name="date" id="date">
            </form>
        </div>

        <div class="md:w-4/5 mx-auto bg-white md:p-8 p-4 rounded border mt-3 relative">

            <form action="{{ route('admin.attendance.clear') }}" method="POST" id="form_clear"
                onsubmit="return confirmClear(event)" class="absolute right-4 top-4">
                @csrf
                <input type="hidden" name="clear_date" value="{{ $date }}">
                <button type="submit"><i class="bi-recycle text-red-600"></i></button>
            </form>
            <!-- page message -->
            @if ($errors->any())
                <x-message :errors='$errors'></x-message>
            @else
                <x-message></x-message>
            @endif
            <h2><i class="bi-clock mr-3"></i> {{ \Carbon\Carbon::parse($date)->format('d-m-Y') }}</h2>
            <table class="table-auto borderless w-full mt-8">
                <thead>
                    <tr class="tr">
                        <th class="text-left">Class</th>
                        <th class="w-24">Attendance</th>
                        <th class="w-24"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($sections as $section)
                        @if ($section->attendance_count)
                            <tr class="tr">
                                <td class="text-left">
                                    <a href="{{ route('admin.attendance.byDate', ['section' => $section, 'date' => $date]) }}"
                                        class="link">{{ $section->fullName() }}</a>
                                    @if ($section->students()->createdToday()->count())
                                        <span class="text-green-600 text-xs ml-2"><i
                                                class="bi-arrow-up"></i>{{ $section->students()->createdToday()->count() }}</span>
                                    @endif
                                </td>
                                <td>{{ $section->presence_count }} / {{ $section->attendance_count }}</td>
                                <td>{{ round(($section->presence_count / $section->attendance_count) * 100, 1) }} %</td>

                            </tr>
                        @endif
                    @endforeach
                    @if ($total_attendance)
                        <tr>
                            <td class="text-left font-semibold">Total</td>
                            <td class="font-semibold">{{ $total_presence }} / {{ $total_attendance }}</td>
                            <td class="font-semibold">
                                {{ round(($total_presence / $total_attendance) * 100, 2) }}%
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
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
