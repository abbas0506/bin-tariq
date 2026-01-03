@extends('layouts.app')
@section('page-content')
    <div class="custom-container">
        <h1>Fee Invoice</h1>
        <div class="bread-crumb">
            <a href="{{ url('/') }}">Home</a>
            <div>/</div>
            <a href="{{ route('fee-invoices.index') }}">Fee Invoices</a>
            <div>/</div>
            <div>View</div>
        </div>

        <div class="md:w-4/5 mx-auto overflow-x-auto  bg-white w-full mt-1">
            <!-- page message -->
            @if ($errors->any())
                <x-message :errors='$errors'></x-message>
            @else
                <x-message></x-message>
            @endif
            <div class="flex flex-wrap md:justify-between items-center text-sm gap-2 border-b py-5">
                <div class="grid grid-cols-2 gap-2">
                    <h2>Invoice #:</h2>
                    <div>{{ $feeInvoice->invoice_no }} </div>
                    <h2>Student:</h2>
                    <div>{{ $feeInvoice->student->name }} / <span
                            class="text-slate-400">{{ $feeInvoice->student->father_name }}</span>
                    </div>
                    <h2>Month:</h2>
                    <div>{{ $feeInvoice->billingMonth() }}</div>
                    <h2>Due Date:</h2>
                    <div>{{ $feeInvoice->due_date->format('d-m-y') }}</div>
                </div>
                <h2>Rs. {{ $feeInvoice->amount }}</h2>
            </div>
            <h3 class="mt-3">Invoice Detail</h3>
            <table class="table-auto borderless w-full mt-3">
                <thead>
                    <tr>
                        <th class="w-8">#</th>
                        <th class="w-48 text-left">Name</th>
                        <th class="w-16">
                        </th>
                    </tr>
                </thead>
                <tbody>
                <tbody>
                    @foreach ($feeInvoice->feeInvoiceItems as $invoiceItem)
                        <tr class="tr">
                            <td>{{ $loop->index + 1 }}</td>
                            <td class="text-left">{{ $invoiceItem->feeType->name }}</td>
                            <td class="text-right">{{ $invoiceItem->amount }} </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
        <div class="text-center mt-8">
            @if (!$feeInvoice->status)
                <form action="{{ route('fee-invoices.update', $feeInvoice) }}" method="POST"
                    onsubmit="return confirmUpdate(event, {{ $feeInvoice->amount }})">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="btn-teal px-5 py-2 rounded">
                        Pay
                    </button>
                </form>
            @else
                Paid <i class="bi-check text-green-800"></i>
            @endif
        </div>
    </div>

    <script type="text/javascript">
        function confirmUpdate(event, amount) {
            event.preventDefault(); // prevent form submit
            var form = event.target; // storing the form

            Swal.fire({
                title: 'Are you sure?',
                text: "Fee (" + amount + ") will be paid !",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, accept fee!'
            }).then((result) => {
                if (result.value) {
                    form.submit();
                }
            })
        }

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
