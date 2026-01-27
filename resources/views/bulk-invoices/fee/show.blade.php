@extends('layouts.app')
@section('page-content')
    <h2>
        Invoice # {{ $fee->bulkInvoice->id }}</h2>
    <div class="bread-crumb">
        <a href="/">Home</a>
        <div>/</div>
        <a href="{{ route('bulk-invoices.index') }}">Invoices</a>
        <div>/</div>
        <div>Fee</div>
    </div>

    <!-- message -->
    <div class="md:w-3/4 mx-auto">
        @if ($errors->any())
            <x-message :errors='$errors'></x-message>
        @else
            <x-message></x-message>
        @endif
    </div>

    <div class="grid md:w-4/5 mx-auto mt-6 bg-white md:p-8 p-4 rounded border">
        <div class="grid md:grid-cols-2 gap-3 text-xs md:text-sm">
            <div>
                <h3>Student:</h3>
                <div>{{ $fee->student->name }} / <span class="text-slate-400">{{ $fee->student->father_name }}</span>
                </div>
            </div>
            <div>
                <h3>Month:</h3>
                <div>{{ $fee->bulkInvoice->billingMonth() }}</div>
            </div>
            <div>
                <h3>Due Date:</h3>
                <div>{{ $fee->bulkInvoice->due_date->format('d-m-y') }}</div>
            </div>
            <div>
                <h3>Net:</h3>
                <div>Rs. {{ $fee->amount }} @if ($fee->status)
                        <span class="text-slate-100 text-xs bg-green-600 rounded-full px-2 py-1">Paid</span>
                    @else
                        <span class="text-slate-100 text-xs bg-red-600 rounded-full px-2 py-1">Pending</span>
                    @endif
                </div>
            </div>
        </div>

        @if (!$fee->status)
            <div class="mt-8">
                <form action="{{ route('fees.update', $fee) }}" method="POST"
                    onsubmit="return confirmUpdate(event, {{ $fee->amount }})">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="btn-teal px-5 py-2 rounded mt-3">
                        Pay
                    </button>
                </form>
            </div>
        @endif
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
@endsection
@section('script')
    <script type="module">
        $('.checkable-row input').change(function() {
            if ($(this).prop('checked'))
                $(this).parents('.checkable-row').addClass('active')
            else
                $(this).parents('.checkable-row').removeClass('active')
        })

        $('#check_all').change(function() {
            if ($(this).prop('checked')) {
                $('.checkable-row input').each(function() {
                    $(this).prop('checked', true)
                    $(this).parents('.checkable-row').addClass('active')
                })
            } else {
                $('.checkable-row input').each(function() {
                    $(this).prop('checked', false)
                    $(this).parents('.checkable-row').removeClass('active')
                })
            }
        })
    </script>

    <script>
        function confirmDel(event) {
            event.preventDefault(); // prevent form submit
            var form = event.target; // storing the form

            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.value) {
                    //submit corresponding form
                    form.submit();
                }
            });
        }
    </script>
@endsection
