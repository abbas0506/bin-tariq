@extends('layouts.app')
@section('page-content')
    <div class="custom-container">
        <h1>Voucher Payments</h1>
        <div class="bread-crumb">
            <a href="{{ url('/') }}">Dashoboard</a>
            <div>/</div>
            <a href="{{ route('vouchers.index') }}">Vouchers</a>
            <div>/</div>
            <a href="{{ route('vouchers.show', $voucher) }}"> #{{ $voucher->id }}</a>
            <div>/</div>
            <div>{{ $section->name }}</div>
        </div>
        <div class="text-right">


        </div>

        <!-- message -->
        <div class="md:w-3/4 mx-auto">
            @if ($errors->any())
                <x-message :errors='$errors'></x-message>
            @else
                <x-message></x-message>
            @endif
        </div>

        <div class="md:w-4/5 mx-auto bg-white md:p-8 p-4 rounded border mt-8 relative">
            {{-- close button --}}
            <div class="absolute top-2 right-2">
                <a href="{{ route('voucher.section.payments.index', [$voucher, $section]) }}"><i
                        class="bi-x text-slate-600"></i></a>
            </div>

            <h2 class="mt-2"> {{ $student->name }}</h2>
            <div class="text-slate-500">{{ $voucher->name }}</div>
            <div class="mt-5 bg-teal-600 h-1 w-24 rounded"></div>
            <form action="{{ route('voucher.section.payments.update', [$voucher, $section, $fee]) }}" method='post'
                class="w-full grid gap-6 mt-5" onsubmit="return validate(event)">
                @csrf
                @method('PUT')
                <div class="grid md:grid-cols-2 gap-2">
                    <div class="md:col-span-2">
                        <label>Amount</label>
                        <input type="number" name='amount' class="custom-input" placeholder="Amount"
                            value="{{ $fee->amount }}">
                    </div>
                    <div>
                        <label>Status</label>
                        <select name="status" id="" class="custom-input">
                            <option value="1" @selected($fee->status == 1)>Paid</option>
                            <option value="0" @selected($fee->status == 0)>Not Paid</option>
                        </select>
                    </div>
                </div>
                <div class="text-right">

                    <button type="submmit" class="btn-blue rounded py-2 px-5">Update</button>
                </div>
            </form>
        </div>
    @endsection
