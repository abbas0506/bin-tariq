@extends('layouts.teacher')
@section('page-content')
    <div class="custom-container">
        <h1>Fee / Dues</h1>
        <div class="bread-crumb">
            <a href="{{ url('/') }}">Home</a>
            <div>/</div>
            <div>{{ $section->fullName() }}</div>
            <div>/</div>
            <a href="{{ route('teacher.section.fee.index', $section) }}">Fee</a>

        </div>

        <!-- search -->
        <!-- <div class="flex justify-between items-center flex-wrap gap-6 mt-12"> -->
        <div class="flex relative w-full md:w-1/3">
            <input type="text" id='searchby' placeholder="Search ..." class="custom-search w-full" oninput="search(event)">
            <i class="bx  bx-search absolute top-2 right-2"></i>
        </div>

        <!-- page message -->
        @if ($errors->any())
            <x-message :errors='$errors'></x-message>
        @else
            <x-message></x-message>
        @endif

        <div class="mt-8">
            {{ $voucher->name }}<br>
            <span class="text-slate-600 text-sm">@Rs. {{ $voucher->amount }}</span>
            <span class="text-slate-400 text-xs">till
                {{ $voucher->due_date->format('d-m-Y') }}</span>
        </div>

        <div class="flex justify-between items-center mt-4">

            <div class="flex flex-wrap text-xs md:text-sm">
                <span class="text-slate-500">Paid
                    {{ $voucher->studentsWhoHavePaid($section->id)->count() }}/{{ $voucher->studentsFromSection($section->id)->count() }}
                </span>
                <i class="bi-check text-green-600 mr-4"></i>
                <span class="text-slate-500">Rs:
                    {{ $voucher->sumOfPaidAmountForSection($section->id) }}</span>
                <i class="bi-check-all text-green-600"></i>

                <span class="text-xs ml-2">
                    <i class="bi-arrow-up text-green-600"></i>
                    <i class="bi-person"></i>{{ $voucher->studentsWhoHavePaidToday($section->id)->count() }}
                    Rs.{{ $voucher->studentsWhoHavePaidToday($section->id)->count() * $voucher->amount }}
                </span>
            </div>

            <a href="{{ route('teacher.section.fee.edit', [$section, $voucher->id]) }}" class="btn-blue rounded"><i
                    class="bx  bx-pencil"></i></a>
        </div>

        <div class="overflow-x-auto bg-white w-full mt-3">
            <table class="table-auto borderless w-full">
                <thead>
                    <tr>
                        <th class="w-6">#</th>
                        <th class="w-48 text-left">Name</th>
                        <th class="w-6"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($section->fees as $fee)
                        <tr class="tr">
                            <td>{{ $fee->student->rollno }}</td>
                            <td class="text-left text-xs md:text-sm">{{ $fee->student->name }} <br> <span
                                    class="text-slate-400 text-xs">{{ $fee->student->father_name }}</span>
                                @if (!$fee->status)
                                    <br>
                                    <span class="text-slate-400 text-xs"><i
                                            class="bi-telephone"></i>{{ $fee->student->phone }}</span>
                                @endif
                            </td>

                            <td>
                                @if ($fee->status)
                                    <i class="bi-check text-teal-600"></i>
                                @else
                                    <i class="bi-x text-red-600"></i>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="text-center mt-8">
            <a href="{{ route('teacher.section.fee.index', $section) }}" class="btn-blue rounded py-2 px-5">Close</a>
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
    </script>
@endsection
