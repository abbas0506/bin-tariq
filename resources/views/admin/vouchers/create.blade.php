@extends('layouts.admin')
@section('page-content')
    <h2>New Test</h2>
    <div class="bread-crumb">
        <a href="/">Home</a>
        <div>/</div>
        <a href="{{ route('admin.vouchers.index') }}">Vouchers</a>
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
        <form action="{{ route('admin.vouchers.store') }}" method='post' class="w-full grid gap-6"
            onsubmit="return validate(event)">
            @csrf
            <div class="grid md:grid-cols-2 gap-3">
                <div class="md:col-span-2">
                    <label>Voucher Title</label>
                    <input type="text" name='name' class="custom-input" placeholder="For example: December Fee"
                        value="" required>
                </div>
                <div class="">
                    <label>Amount</label>
                    <input type="number" name='amount' class="custom-input text-center" placeholder="Amount"
                        value="20" required>

                </div>
                <div>
                    <label>Due Date</label>
                    <input type="date" name='due_date' class="custom-input text-center" placeholder="Due date" required>

                </div>
            </div>

            <div class="md:p-5 border rounded-lg">
                <h2 class="mb-4">To be generated for classes</h2>
                @foreach ($sections as $section)
                    <div class="flex items-center odd:bg-slate-100 checkable-row px-4">
                        <!-- <div class="flex flex-1 items-center justify-between space-x-2 pr-3"> -->
                        <label for='section{{ $section->id }}'
                            class="flex-1 text-sm text-slate-800 hover:cursor-pointer py-2">{{ $section->fullName() }}
                        </label>
                        <!-- </div> -->
                        <div class="text-base">
                            <input type="checkbox" id='section{{ $section->id }}' name='section_ids_array[]'
                                class="custom-input w-4 h-4 rounded hidden" value="{{ $section->id }}">
                            <i class="bx bx-check"></i>
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
        })
    </script>
@endsection
