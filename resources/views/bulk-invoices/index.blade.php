@extends('layouts.app')
<style>
    .search-tab {
        background: #ffffff;
        padding: 4px 8px;
        border: 1px solid #ddd;
        /* light border */
        border-radius: 5px;
        /* rounded corners */
        cursor: pointer;
    }

    .search-tab.active {
        background: rgb(206, 206, 206);
    }
</style>
@section('page-content')
    <div class="custom-container">
        <h1>Fee Invoices</h1>
        <div class="bread-crumb">
            <a href="{{ url('/') }}">Home</a>
            <div>/</div>
            <div>Fee Invoices</div>
        </div>


        {{-- create new invoice --}}
        <a href="{{ route('bulk-invoices.create') }}"
            class="flex w-12 h-12 justify-center items-center btn-teal rounded-full fixed right-5 bottom-5"><i
                class="bi-plus"></i></a>

        <div class="md:w-4/5 overflow-x-auto mx-auto bg-white md:p-8 p-4 rounded border mt-3">
            @if ($bulkInvoices->count())
                <div class="flex relative w-full md:w-1/3">
                    <input type="text" id='searchby' placeholder="Search ..." class="custom-search w-full"
                        oninput="search(event)">
                    <i class="bx bx-search absolute top-2 right-2"></i>
                </div>

                <!-- page message -->
                @if ($errors->any())
                    <x-message :errors='$errors'></x-message>
                @else
                    <x-message></x-message>
                @endif

                <div class="overflow-x-auto bg-white w-full mt-8">
                    <table class="table-fixed xs md:sm borderless w-full">
                        <thead>
                            <tr>
                                {{-- <th class="w-16">Invoice #</th> --}}
                                <th class="w-40 text-left">Title</th>
                                <th class="w-16">Month</th>
                                <th class="w-16">Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($bulkInvoices->sortBy('student.rollno') as $bulkInvoice)
                                <tr class="tr">
                                    <td class="text-left"><a href="{{ route('bulk-invoices.show', $bulkInvoice) }}"
                                            class="link">{{ $bulkInvoice->title }}</a>
                                        <br>
                                        <span class="text-slate-400 text-xs">Till
                                            {{ $bulkInvoice->due_date->format('d-m-Y') }}</span>
                                    </td>

                                    <td>{{ $bulkInvoice->billingMonth() }}</td>
                                    <td>{{ $bulkInvoice->sumOfPaidAmount() }} /
                                        {{ $bulkInvoice->sumOfPayableAmount() }} </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                <div class="px-4 py-3 border-t mt-4">
                    {{ $bulkInvoices->withQueryString()->links() }}
                </div>
            @else
                <div class="p-12 mt-12 text-center bg-slate-100 rounded border text-slate-600">No Data Found</div>
            @endif
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

        function searchBy(searchKey, src) {
            $('.advanced-search').hide();
            $('.search-tab').removeClass('active');
            src.classList.add('active');

            if (searchKey == 'invoice') {
                $('#searchByInvoice').show();
            } else if (searchKey == 'name') {
                $('#searchByName').show();
            } else if (searchKey == 'class') {
                $('#searchByClass').show();
            }
        }
    </script>
@endsection
