@extends('layouts.teacher')
@section('page-content')
    <div class="custom-container">
        <h1>Fee / Dues</h1>
        <div class="bread-crumb">
            <a href="{{ url('/') }}">Home</a>
            <div>/</div>
            <div>{{ $section->fullName() }}</div>
        </div>


        <div class="overflow-x-auto bg-white w-full py-4">
            <!-- search -->
            <div class="flex relative w-full md:w-1/3">
                <input type="text" id='searchby' placeholder="Search ..." class="custom-search w-full"
                    oninput="search(event)">
                <i class="bx  bx-search absolute top-2 right-2"></i>
            </div>

            <!-- page message -->
            @if ($errors->any())
                <x-message :errors='$errors'></x-message>
            @else
                <x-message></x-message>
            @endif

            <h2 class="mt-8"><i class="bi-clock mr-3"></i>{{ now()->format('d-m-Y') }}</h2>
            <table class="table-auto borderless w-full mt-4">
                <thead>
                    <tr>
                        <th class="w-6">Sr</th>
                        <th class="w-48 text-left">Name</th>
                        <th class="w-6">#</th>
                        <th class="w-6">Rs</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($vouchers->sortBy('student_id') as $voucher)
                        <tr class="tr">
                            <td>{{ $loop->index + 1 }}</td>
                            <td class="text-left text-xs md:text-sm">
                                <a href="{{ route('teacher.section.fee.show', [$section, $voucher]) }}"
                                    class="link">{{ $voucher->name }}</a><br>
                                @Rs. {{ $voucher->amount }} <span class="text-slate-400 text-xs">till
                                    {{ $voucher->due_date->format('d-m-Y') }}</span>
                            </td>
                            <td>{{ $voucher->studentsWhoHavePaid($section->id)->count() }}/{{ $voucher->studentsFromSection($section->id)->count() }}
                                <i class="bi-arrow-up text-xs text-green-600"></i>
                                <span
                                    class="text-xs">{{ $voucher->studentsWhoHavePaidToday($section->id)->count() }}</span>
                            <td>{{ $voucher->sumOfPaidAmountForSection($section->id) }}</td>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
