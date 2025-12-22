@extends('layouts.admission')
@section('page-content')
    <div class="custom-container">
        <!--Title  -->
        <div class="flex justify-between items-baseline">
            <div>
                <h1>Fee</h1>

                <div class="bread-crumb">
                    <a href="{{ url('/') }}">Dashboard</a>
                    <div>/</div>
                    <div>Fee Paid</div>
                </div>
            </div>
            <div>
                {{ $applications->whereNotNull('amount_paid')->count() }} / {{ $applications->count() }}
            </div>
        </div>

        <div class="flex mt-4">
            <!-- search -->
            <div class="flex relative w-full md:w-1/3">
                <input type="text" id='searchby' placeholder="Search ..." class="custom-search w-full"
                    oninput="search(event)">
                <i class="bx  bx-search absolute top-2 right-2"></i>
            </div>
            <div class="flex justify-end w-full">
                <div class="flex w-12 h-12 items-center justify-center rounded-full bg-orange-100 hover:bg-orange-200">
                    <a href="{{ route('admission.print.fee') }}" target="_blank"><i class="bi-printer"></i></a>
                </div>
            </div>

        </div>

        <!-- page message -->
        @if ($errors->any())
            <x-message :errors='$errors'></x-message>
        @else
            <x-message></x-message>
        @endif

        @php $sr=1; @endphp
        <div class="overflow-x-auto w-full mt-8">

            <table class="table-fixed borderless w-full">
                <thead>
                    <tr class="border-b">
                        <th class="w-16">App #</th>
                        <th class="w-40 text-left">Student Name</th>
                        <th class="w-24">Group</th>
                        <th class="w-16">Marks</th>
                        <th class="w-16">Fee</th>
                        <th class="w-20">Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($applications->sortByDesc('payment_date') as $application)
                        <tr class="tr text-sm border-b">
                            <td> <a href="{{ route('admission.applications.show', $application) }}"
                                    class="link">{{ $application->rollno }}</a></td>
                            <td class="text-left">{{ $application->name }}</td>
                            <td>{{ $application->group->name }}</td>
                            <td>{{ $application->obtained_marks }}</td>
                            <td>{{ $application->amount_paid }}</td>
                            <td>{{ $application->payment_date->format('d/m/y') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
@section('script')
    <script type="text/javascript">
        function search(event) {
            // var searchtext = event.target.value.toLowerCase();
            var searchtext = $('#searchby').val().toLowerCase();
            var str = 0;
            $('.tr').each(function() {
                if (!(
                        $(this).children().eq(0).prop('outerText').toLowerCase().includes(searchtext) ||
                        $(this).children().eq(2).prop('outerText').toLowerCase().includes(searchtext)
                    )) {
                    $(this).addClass('hidden');
                } else {
                    $(this).removeClass('hidden');
                }
            });
        }
    </script>
@endsection
