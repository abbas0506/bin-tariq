@extends('layouts.admin')
@section('page-content')
    <h1>Collective Tests</h1>
    <div class="bread-crumb">
        <a href="{{ url('/') }}">Home</a>
        <div>/</div>
        <div>Vouchers</div>
    </div>


    <div class="content-section">
        <div class="flex items-center flex-wrap justify-between">
            <!-- search -->
            <div class="flex relative w-full md:w-1/3">
                <input type="text" id='searchby' placeholder="Search ..." class="custom-search w-full"
                    oninput="search(event)">
                <i class="bx  bx-search absolute top-2 right-2"></i>
            </div>
            <a href="{{ route('admin.vouchers.create') }}"
                class="fixed bottom-4 right-4 flex justify-center items-center bg-teal-400 hover:bg-teal-600 hover:cursor-pointer rounded-full w-12 h-12"><i
                    class="bi-plus-lg"></i></a>
        </div>

        <!-- page message -->
        @if ($errors->any())
            <x-message :errors='$errors'></x-message>
        @else
            <x-message></x-message>
        @endif

        <table class="table-auto borderless w-full mt-8">
            <thead>
                <tr class="">
                    <th class="w-16">Sr</th>
                    <th class="text-left">Voucher Title</th>
                    <th>Rs.</th>
                </tr>
            </thead>
            <tbody>

                @foreach ($vouchers as $voucher)
                    <tr class="tr">
                        <td>{{ $loop->index + 1 }}</td>
                        <td class="text-left">
                            @if ($voucher->isOpen())
                                <a href="{{ route('admin.vouchers.show', $voucher) }}"
                                    class="link">{{ $voucher->name }}</a>
                                <br>
                                <span>@Rs. {{ $voucher->amount }} <span class="text-slate-400 text-xs">till
                                        {{ $voucher->due_date->format('d-m-Y') }}</span>
                                @else
                                    <a href="{{ route('admin.vouchers.show', $voucher) }}">{{ $voucher->name }}</a><br>
                                    <span>@Rs. {{ $voucher->amount }} <span class="text-slate-400 text-xs">till
                                            {{ $voucher->due_date->format('d-m-Y') }}</span>
                            @endif
                        </td>
                        <td>{{ $voucher->sumOfPaidAmount() }} / {{ $voucher->students->count() * $voucher->amount }} </td>
                    </tr>
                @endforeach

            </tbody>
        </table>
    </div>
    </div>
    <script type="text/javascript">
        function search(event) {
            var searchtext = event.target.value.toLowerCase();
            var str = 0;
            $('.tr').each(function() {
                if (!(
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
