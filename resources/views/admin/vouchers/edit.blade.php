@extends('layouts.admin')
@section('page-content')
    <h2>
        Voucher # {{ $voucher->id }}</h2>
    <div class="bread-crumb">
        <a href="/">Home</a>
        <div>/</div>
        <a href="{{ route('admin.vouchers.index') }}">Vouchers</a>
        <div>/</div>
        <div>Edit</div>
    </div>

    <div class="text-right">
        <div class="flex w-8 h-8 rounded-full border justify-center items-center">
            <a href="{{ route('admin.vouchers.show', $voucher) }}"><i class="bi-x text-slate-600"></i></a>
        </div>

    </div>

    <!-- message -->
    <div class="md:w-3/4 mx-auto">
        @if ($errors->any())
            <x-message :errors='$errors'></x-message>
        @else
            <x-message></x-message>
        @endif
    </div>

    <div class="md:w-4/5 mx-auto bg-white md:p-8 p-4 rounded border mt-3">
        <h2> <i class="bi-receipt text-slate-500"></i> Voucher Info</h2>
        <form action="{{ route('admin.vouchers.update', $voucher) }}" method='post' class="w-full grid gap-6"
            onsubmit="return validate(event)">
            @csrf
            @method('PUT')
            <div class="grid md:grid-cols-2 gap-2">
                <div class="md:col-span-2">
                    <label>Voucher Title</label>
                    <input type="text" name='name' class="custom-input" placeholder="For example: December Fee"
                        value="{{ $voucher->name }}" required>
                </div>
                <div class="">
                    <label>Amount (Rs.)</label>
                    <input type="number" name='amount' class="custom-input text-center" placeholder="Amount"
                        value="{{ $voucher->amount }}" required>
                </div>
                <div>
                    <label>Due Date</label>
                    <input type="date" name='due_date' class="custom-input text-center" placeholder="Due date"
                        value="{{ optional($voucher->due_date)->format('Y-m-d') }}" required>
                </div>
            </div>
            <div class="text-right">

                <button type="submmit" class="btn-blue rounded py-2 px-5">Update</button>
            </div>
        </form>
    </div>
@endsection
