@extends('layouts.app')
@section('page-content')
    <div class="custom-container">
        <h1>Payment History</h1>
        <div class="bread-crumb">
            <a href="{{ url('/') }}">Dashoboard</a>
            <div>/</div>
            <a href="{{ route('vouchers.index') }}">Vouchers</a>
            <div>/</div>
            <a href="{{ route('voucher.section.payments.index', [$voucher, $section]) }}"> # {{ $voucher->id }}</a>
            <div>/</div>
            <div>Payments</div>
        </div>



        <!-- search -->
        <div class="flex relative w-full md:w-1/3 mt-5">
            <input type="text" id='searchby' placeholder="Search ..." class="custom-search w-full" oninput="search(event)">
            <i class="bx  bx-search absolute top-2 right-2"></i>
        </div>

        <!-- page message -->
        @if ($errors->any())
            <x-message :errors='$errors'></x-message>
        @else
            <x-message></x-message>
        @endif

        <h2 class="mt-8">{{ $student->name }} <br><span
                class="text-slate-400 font-normal">{{ $student->father_name }}</span></h2>
        <div class="overflow-x-auto bg-white w-full mt-1">
            <table class="table-auto borderless w-full">
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
                    @foreach ($student->fees->sortBy('student.rollno') as $fee)
                        <tr class="tr">
                            <td>{{ $loop->index + 1 }}</td>
                            <td class="text-left">{{ $fee->voucher->name }} @ {{ $fee->amount }} <br>
                                <span class="text-slate-400 text-xs">Due date :
                                    {{ $fee->voucher->due_date->format('d-m-Y') }}</span>
                            </td>
                            <td>
                                @if (!$fee->status)
                                    <form action="{{ route('voucher.section.payments.update', [$voucher, 1, $fee]) }}"
                                        method="POST" onsubmit="return confirmUpdate(event, {{ $fee->amount }})">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn-blue rounded">
                                            Accept Fee
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
        <div class="text-center mt-8">
            <a href="{{ route('voucher.section.payments.index', [$voucher, $section]) }}" class="btn-teal rounded">
                Close </a>
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
