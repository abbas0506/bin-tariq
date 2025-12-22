@extends('layouts.teacher')
@section('page-content')
    <div class="custom-container">
        <h1>Fee/Dues</h1>
        <div class="bread-crumb">
            <a href="{{ url('/') }}">Home</a>
            <div>/</div>
            <div>{{ $section->fullName() }}</div>
            <div>/</div>
            <a href="{{ route('teacher.section.fee.index', $section) }}">Fee</a>
        </div>

        <!-- search -->
        <div class="flex relative w-full md:w-1/3">
            <input type="text" id='searchby' placeholder="Search ..." class="custom-search w-full" oninput="search(event)">
            <i class="bx  bx-search absolute top-2 right-2"></i>
        </div>

        <div class="mt-8">
            {{ $voucher->name }}<br>
            <span class="text-slate-600 text-sm">@Rs. {{ $voucher->amount }}</span>
            <span class="text-slate-400 text-xs">till
                {{ $voucher->due_date->format('d-m-Y') }}</span>
        </div>

        <!-- page message -->
        @if ($errors->any())
            <x-message :errors='$errors'></x-message>
        @else
            <x-message></x-message>
        @endif

        <div class="overflow-x-auto bg-white w-full mt-4">
            <form action="{{ route('teacher.section.fee.update', [$section, $voucher]) }}" method="post" class="mt-3">
                @csrf
                @method('PATCH')
                <table class="table-auto borderless w-full">
                    <thead>
                        <tr>
                            <th class="w-6">#</th>
                            <th class="w-48 text-left">Name</th>
                            <th class="w-6"><input type="checkbox" id='chkAll' class="rounded" onclick="checkAll()">

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($fees->sortBy('status') as $fee)
                            <tr class="tr">
                                <td>{{ $fee->student->rollno }}</td>
                                <td class="text-left text-xs md:text-sm">{{ $fee->student->name }} <br> <span
                                        class="text-slate-400">{{ $fee->student->father_name }}</span></td>
                                <td>
                                    <div class="flex items-center justify-center">
                                        <input type="checkbox" class="w-4 h-4 rounded" name="fee_ids_checked[]"
                                            value="{{ $fee->id }}" @checked($fee->status)>
                                    </div>
                                </td>
                                <td class="hidden"><input type="text" name="fee_ids[]" value="{{ $fee->id }}"></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="text-center mt-8">
                    <a href="{{ route('teacher.section.fee.index', $section) }}"
                        class="btn-gray rounded py-2 mr-3">Cancel</a>
                    <button type="submit" class="btn-blue rounded py-2">Update Now</button>
                </div>
            </form>
        </div>

    </div>
    <script>
        function search(event) {
            var searchtext = event.target.value.toLowerCase();
            var str = 0;
            $('.tr').each(function() {
                if (!(
                        $(this).children().eq(0).prop('outerText').toLowerCase().includes(searchtext) ||
                        $(this).children().eq(1).prop('outerText').toLowerCase().includes(searchtext)
                    )) {
                    $(this).addClass('hidden');
                } else {
                    $(this).removeClass('hidden');
                }
            });
        }

        function checkAll() {

            $('.tr').each(function() {
                if (!$(this).hasClass('hidden'))
                    $(this).children().find('input[type=checkbox]').prop('checked', $('#chkAll').is(':checked'));
                // updateChkCount()
            });
        }
    </script>
@endsection
