@extends('layouts.app')
@section('page-content')
    <h2>New Fee Invoice</h2>
    <div class="bread-crumb">
        <a href="/">Home</a>
        <div>/</div>
        <a href="{{ route('fee-invoices.index') }}">Fee Invoices</a>
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
        <form action="{{ route('fee-invoices.store') }}" method='post' class="w-full grid gap-3"
            onsubmit="return validate(event)">
            @csrf
            <h2>Select Fee Type(s)</h2>
            <div class="grid md:w-1/2">
                @foreach ($fee_types as $fee_type)
                    <div class="flex items-center space-x-2 checkable-row px-4">
                        <div class="text-base">
                            <input type="checkbox" id='fee{{ $fee_type->id }}' name='fee_type_ids_array[]'
                                class="custom-input w-4 h-4 rounded hidden" value="{{ $fee_type->id }}">
                            <i class="bi-check"></i>
                        </div>
                        <label for='fee{{ $fee_type->id }}'
                            class="flex-1 text-sm text-slate-800 hover:cursor-pointer py-2">{{ $fee_type->name }}
                        </label>

                    </div>
                @endforeach
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                <div class="">
                    <label>Month</label>
                    <select name="month" id="" class="custom-input">
                        @foreach (range(1, 12) as $month_no)
                            <option value="{{ $month_no }}">{{ $months[$month_no] }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="">
                    @php
                        $current_year = now()->format('Y');
                    @endphp
                    <label>Year</label>
                    <select name="year" id="" class="custom-input">
                        @foreach (range($current_year, $current_year - 1) as $year)
                            <option value="{{ $year }}">{{ $year }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="md:col-span-full">
                    <label>Due Date</label>
                    <input type="date" name='due_date' class="custom-input text-center" placeholder="Due date" required>

                </div>
            </div>

            <div class="p-5 border rounded-lg">
                <h2 class="mb-4">Select Class(es)</h2>
                @foreach ($sections as $section)
                    <div class="flex items-center odd:bg-slate-100 checkable-row">
                        <!-- <div class="flex flex-1 items-center justify-between space-x-2 pr-3"> -->
                        <label for='section{{ $section->id }}'
                            class="flex-1 text-sm text-slate-800 hover:cursor-pointer py-2">{{ $section->name }}
                        </label>
                        <!-- </div> -->
                        <div class="text-base">
                            <input type="checkbox" id='section{{ $section->id }}' name='section_ids_array[]'
                                class="custom-input w-4 h-4 rounded hidden" value="{{ $section->id }}">
                            <i class="bi-check"></i>
                        </div>
                    </div>
                @endforeach
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
