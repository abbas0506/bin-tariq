@extends('layouts.app')
@section('page-content')
    <div class="custom-container">
        <h1>Salary</h1>
        <div class="bread-crumb">
            <a href="{{ url('/') }}">Home</a>
            <div>/</div>
            <a href="{{ route('salaries.index') }}">Salaries</a>
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
            <div class="flex mt-4">
                <div class="grid grid-cols-2 gap-1 text-xs md:text-sm">
                    <h3>Name:</h3>
                    <div>{{ $salary->user->profile->name }} / <span
                            class="text-slate-400">{{ $salary->user->profile->father_name }}</span>
                    </div>
                    <h3>Month:</h3>
                    <div>{{ $salary->billingMonth() }}</div>
                    <h3>Salary:</h3>
                    <div>Rs. {{ $salary->amount }} @if ($salary->status)
                            <span class="text-green-600 font-semibold ml-2">Paid</span>
                        @else
                            <span class="text-red-600 font-semibold ml-2">Not Paid</span>
                        @endif
                    </div>
                </div>
            </div>
            @if (!$salary->status)
                <div class="mt-8">
                    <h2>Select Payment Method</h2>
                    <form action="{{ route('salaries.update', $salary) }}" method="POST"
                        onsubmit="return confirmUpdate(event, {{ $salary->amount }})">
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
                                value="{{ $salary->transaction->description }}" placeholder="Reference">
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
