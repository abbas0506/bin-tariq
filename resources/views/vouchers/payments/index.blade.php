@extends('layouts.app')
@section('page-content')
    <div class="custom-container">
        <h1>Voucher Payments</h1>
        <div class="bread-crumb">
            <a href="{{ url('/') }}">Dashoboard</a>
            <div>/</div>
            <a href="{{ route('vouchers.index') }}">Vouchers</a>
            <div>/</div>
            <a href="{{ route('vouchers.show', $voucher) }}"> #{{ $voucher->id }}</a>
            <div>/</div>
            <div>{{ $section->name }}</div>
        </div>

        @if ($voucher->fees()->whereHas('student', fn($q) => $q->where('section_id', $section->id))->count())
            <div class="grid md:grid-cols-3 md:w-4/5 mx-auto mt-6 bg-white md:p-8 p-4 gap-2 rounded border">
                <h2 class="col-span-full">{{ $voucher->name }} @ <span
                        class="text-slate-600 text-sm font-normal">{{ $section->name }}</span>
                </h2>
                <div class="md:col-span-2 text-slate-400 text-sm">
                    Clean action will destory all fee payments from this class against this voucher.
                    Remove only if you are sure!
                </div>
                <div class="flex gap-2 items-center justify-end">
                    <form action="{{ route('voucher.section.payments.clean', [$voucher, $section]) }}" method="POST"
                        onsubmit="confirmClean(event)">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-red rounded">
                            <i class="bi-trash3 text-white"></i>
                        </button>
                    </form>
                    <a href="{{ route('voucher.section.payments.import', [$voucher, $section]) }}"
                        class="btn-blue rounded"><i class="bi-person-add text-white"></i>
                    </a>
                </div>
            </div>
        @endif
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
                            <th class="w-8">#</th>
                            <th class="w-48 text-left">Name</th>
                            <th class="w-6"></th>
                            <th class="w-16"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($fees->sortBy('student.rollno') as $fee)
                            <tr class="tr">
                                <td>{{ $fee->student->rollno }}</td>
                                <td class="text-left"><a
                                        href="{{ route('voucher.section.payments.show', [$voucher, $section, $fee->student]) }}"
                                        class="link">
                                        {{ $fee->student->name }}</a>
                                    <br>
                                    <span class="text-slate-400 text-xs">{{ $fee->student->father_name }}</span>
                                </td>

                                <td>
                                    <div class="flex items-center justify-center space-x-2 rounded">

                                        @if (!$fee->status)
                                            <form
                                                action="{{ route('voucher.section.payments.destroy', [$voucher, $section, $fee]) }}"
                                                method="POST" onsubmit="return confirmDel(event)">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit">
                                                    <i class="bi-x text-red-600"></i>
                                                </button>
                                            </form>
                                        @else
                                            <i class="bi-x text-red-300"></i>
                                        @endif
                                        <a href="{{ route('voucher.section.payments.edit', [$voucher, $section, $fee]) }}"><i
                                                class="bx-pencil text-sm text-green-600"></i></a>
                                    </div>
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
        </div>
    </div>

    <script type="text/javascript">
        function confirmDel(event) {
            event.preventDefault(); // prevent form submit
            var form = event.target; // storing the form

            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, remove payer!'
            }).then((result) => {
                if (result.value) {
                    form.submit();
                }
            })
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

        function confirmClean(event) {
            event.preventDefault(); // prevent form submit
            var form = event.target; // storing the form

            Swal.fire({
                title: 'Are you sure?',
                text: "You are going to clean payers list!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, clean it!'
            }).then((result) => {
                if (result.value) {
                    // alert('clean')
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

        function checkAll() {

            $('.tr').each(function() {
                if (!$(this).hasClass('hidden'))
                    $(this).children().find('input[type=checkbox]').prop('checked', $('#chkAll').is(':checked'));
                // updateChkCount()
            });
        }
    </script>
@endsection
