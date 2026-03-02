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

        <div class="grid md:w-4/5 mx-auto mt-6 bg-white md:p-8 p-4 rounded border">
            <!-- search -->
            <div id="advanced_search">
                <div class="flex items-center flex-wrap gap-1 text-xs">
                    <h3 class="text-red-600">Advanced Search by</h3>
                    <div onclick="searchBy('invoice',this)" class="search-tab">Invoice #</div>
                    <div onclick="searchBy('name', this)" class="search-tab">Student Name</div>
                    <div onclick="searchBy('class',this)"class="search-tab">Class</div>
                </div>
                <form action="{{ route('fee-invoices.search.id') }}" class="advanced-search hidden mt-5"
                    id="searchByInvoice" method="post">
                    @csrf
                    <div>
                        <label for="">Search by Invoice #</label>
                        <input type="text" class="custom-input" name="invoice_no" placeholder="Invoice #">
                    </div>
                    <button type="submit" class="btn-blue rounded text-sm float-right py-2 px-5 mt-4">Search</button>
                </form>
                <form action="{{ route('fee-invoices.search.name') }}" class="advanced-search hidden mt-5" id="searchByName"
                    method="post">
                    @csrf
                    <div>
                        <label for="">Search by Name</label>
                        <input type="text" class="custom-input" name="name" placeholder="Student name">
                    </div>
                    <button type="submit" class="btn-blue rounded text-sm float-right py-2 px-5 mt-4">Search</button>
                </form>
                <form action="{{ route('fee-invoices.search.class') }}" class="advanced-search hidden mt-5"
                    id="searchByClass" method="post">
                    @csrf
                    <div>
                        <label for="">Search by Class</label>
                        <select name="section_id" id="" class="custom-input">
                            @foreach ($sections as $section)
                                <option value="{{ $section->id }}">{{ $section->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn-blue rounded text-sm float-right py-2 px-5 mt-4">Search</button>
                </form>

            </div>

            {{-- create new invoice --}}
            <a href="{{ route('fee-invoices.create') }}"
                class="flex w-12 h-12 justify-center items-center btn-teal rounded-full fixed right-5 bottom-5"><i
                    class="bi-plus"></i></a>

            @if ($feeInvoices->count())
                <form action="{{ route('fee-invoices.print') }}" method="post">
                    @csrf

                    <div class="flex flex-col md:flex-row justify-between mt-8">
                        <div class="flex relative w-full md:w-1/3">
                            <input type="text" id='searchby' placeholder="Search ..." class="custom-search w-full"
                                oninput="search(event)">
                            <i class="bx bx-search absolute top-2 right-2"></i>
                        </div>
                        <div>
                            <button type="submit" class="btn-blue rounded text-sm">Print <i
                                    class="bi-printer"></i></button>
                        </div>
                    </div>

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
                                    <th class="w-12">Class</th>
                                    <th class="w-12">Month</th>
                                    <th class="w-12">Amount</th>
                                    <th class="w-8"></th>
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
                                            <span
                                                class="text-slate-400 text-xs">{{ $feeInvoice->student->father_name }}</span>
                                        </td>

                                        <td>{{ $feeInvoice->student->section->name }}</td>
                                        <td>{{ $feeInvoice->billingMonth() }}</td>
                                        <td>{{ $feeInvoice->amount }}</td>
                                        <td>
                                            <input type="checkbox" name="invoice_ids[]" class="rounded"
                                                value="{{ $feeInvoice->id }}">
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </form>
                {{-- Pagination --}}
                <div class="px-4 py-3 border-t mt-4">
                    {{ $feeInvoices->withQueryString()->links() }}
                </div>
            @else
                <div class="p-12 mt-12 text-center bg-slate-100 rounded border text-slate-600">No Data Found</div>
            @endif
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
