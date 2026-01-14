@extends('layouts.app')
@section('page-content')
    <h2>New Expense</h2>
    <div class="bread-crumb">
        <a href="/">Home</a>
        <div>/</div>
        <a href="{{ route('expenses.index') }}">Expenses</a>
        <div>/</div>
        <div>New</div>
    </div>

    <div class="md:w-3/4 mx-auto mt-6 bg-white md:p-8 rounded">
        <!-- page message -->
        @if ($errors->any())
            <x-message :errors='$errors'></x-message>
        @else
            <x-message></x-message>
        @endif
        <form action="{{ route('expenses.store') }}" method='post' class="w-full grid gap-3" onsubmit="return validate(event)">
            @csrf
            <h2>Select Expense Type(s)</h2>
            <div class="grid gap-3">
                <div class="md:w-1/2">
                    <label for="">Amount (Rs.)</label>
                    <input type="number" name="amount" class="custom-input">
                </div>
                <div>
                    <label for="">Expense Type</label>
                    <select name="expense_account_id" id="" class="custom-input">
                        <option value="">-- Select Expense Type --</option>
                        @foreach ($expenseAccounts as $expenseAccount)
                            <option value="{{ $expenseAccount->id }}">{{ $expenseAccount->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="">Payment Method</label>
                    <select name="payment_account_id" class="custom-input" required>
                        <option value="">-- Select Payment Method --</option>
                        @foreach ($paymentMethods as $method)
                            <option value="{{ $method->id }}">
                                {{ $method->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

            </div>
            <button type="submmit" class="btn-teal rounded p-2 w-32 mt-3">Create Now</button>
        </form>

    </div>
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
        });
        $('#is_tutionfee').on('change', function() {
            if ($(this).is(':checked')) {
                $('#amount_wrapper').addClass('hidden'); // show

            } else {
                $('#amount_wrapper').removeClass('hidden'); // hide
                $('#amount').val(0);
            }
        });
    </script>
@endsection
