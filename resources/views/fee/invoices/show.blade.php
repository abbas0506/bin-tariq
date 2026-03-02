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

        <div class="md:w-4/5 mx-auto overflow-x-auto  bg-white w-full mt-5">
            <!-- page message -->
            @if ($errors->any())
                <x-message :errors='$errors'></x-message>
            @else
                <x-message></x-message>
            @endif
            <div class="flex mt-3">
                <div class="grid grid-cols-2 gap-1 text-xs md:text-sm">
                    <h2 class="col-span-full font-bold">Invoice # {{ $feeInvoice->invoice_no }} </h2>
                    <h3>Student:</h3>
                    <div>{{ $feeInvoice->student->name }} / <span
                            class="text-slate-400">{{ $feeInvoice->student->father_name }}</span>
                    </div>
                    <h3>Month:</h3>
                    <div>{{ $feeInvoice->billingMonth() }}</div>
                    <h3>Due Date:</h3>
                    <div>{{ $feeInvoice->due_date->format('d-m-y') }}</div>
                    <h3>Net:</h3>
                    <div>Rs. {{ $feeInvoice->amount }} @if ($feeInvoice->status)
                            <span class="text-green-600 font-semibold ml-2">Paid</span>
                        @else
                            <span class="text-red-600 font-semibold ml-2">Not Paid</span>
                        @endif
                    </div>
                </div>
            </div>
            <div class="py-3 border-y mt-5">
                <h2 class="text-teal-500">Invoice Detail</h2>
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
            @if (!$feeInvoice->status)
                <div class="mt-8">
                    <h2>Select Payment Method</h2>
                    <form action="{{ route('fee-invoices.update', $feeInvoice) }}" method="POST"
                        onsubmit="return confirmUpdate(event, {{ $feeInvoice->amount }})">
                        @csrf
                        @method('PATCH')
                        <select name="payment_account_id" class="custom-input md:w-1/2" required>
                            <option value="">-- Select Payment Method --</option>
                            @foreach ($paymentMethods as $method)
                                <option value="{{ $method->id }}">
                                    {{ $method->name }}
                                </option>
                            @endforeach
                        </select>
                        <div class="mt-3">
                            <label for="">Reference</label>
                            <input type="text" name="reference" class="custom-input"
                                value="{{ $feeInvoice->transaction->description }}" placeholder="Reference">
                        </div>
                        <button type="submit" class="btn-teal px-5 py-2 rounded mt-5">
                            Pay
                        </button>
                    </form>
                </div>
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
