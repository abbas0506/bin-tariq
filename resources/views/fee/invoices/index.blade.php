@extends('layouts.app')
@section('page-content')
    <div class="custom-container">
        <h1>Fee Invoices</h1>
        <div class="bread-crumb">
            <a href="{{ url('/') }}">Home</a>
            <div>/</div>
            <div>Fee Invoices</div>
        </div>
        <!-- search -->
        <div class="grid md:w-4/5 mx-auto mt-6 bg-white md:p-8 p-4 rounded border">
            <div class="flex flex-col md:flex-row justify-between">
                <div class="flex relative w-full md:w-1/3">
                    <input type="text" id='searchby' placeholder="Search ..." class="custom-search w-full"
                        oninput="search(event)">
                    <i class="bx  bx-search absolute top-2 right-2"></i>
                </div>
                <div>

                </div>
            </div>

            {{-- create new invoice --}}
            <a href="{{ route('fee-invoices.create') }}"
                class="flex w-12 h-12 justify-center items-center btn-teal rounded-full fixed right-5 bottom-5"><i
                    class="bi-plus"></i></a>

            <!-- page message -->
            @if ($errors->any())
                <x-message :errors='$errors'></x-message>
            @else
                <x-message></x-message>
            @endif

            <div class="overflow-x-auto bg-white w-full mt-8">

                <table class="table-auto borderless w-full">
                    <thead>
                        <tr>
                            <th class="w-8">Invoice #</th>
                            <th class="w-48 text-left">Name</th>
                            <th class="w-12">Month</th>
                            <th class="w-12">Amount</th>
                            <th class="w-16"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($feeInvoices->sortBy('student.rollno') as $feeInvoice)
                            <tr class="tr">
                                <td><a href="{{ route('fee-invoices.show', $feeInvoice) }}"
                                        class="link">{{ $feeInvoice->invoice_no }}</a>
                                </td>
                                <td class="text-left">{{ $feeInvoice->student->name }}
                                    <br>
                                    <span class="text-slate-400 text-xs">{{ $feeInvoice->student->father_name }}</span>
                                </td>

                                <td>
                                    {{ $feeInvoice->billingMonth() }}
                                    @if ($feeInvoice->status)
                                        <i class="bi-check text-green-600"></i>
                                    @endif
                                </td>
                                <td>{{ $feeInvoice->amount }}</td>
                                <td>
                                    @if (!$feeInvoice->status)
                                        <form action="{{ route('fee-invoices.update', $feeInvoice) }}" method="POST"
                                            onsubmit="return confirmUpdate(event, {{ $feeInvoice->amount }})">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn-blue rounded">
                                                Pay
                                            </button>
                                        </form>
                                    @else
                                        <i class="bi-check text-green-800"></i>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
            {{-- Pagination --}}
            <div class="px-4 py-3 border-t mt-4">
                {{ $feeInvoices->withQueryString()->links() }}
            </div>
        </div>

    </div>
@endsection
@section('script')
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
    </script>
@endsection
