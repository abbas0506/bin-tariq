@extends('layouts.admin')
@section('page-content')
    <div class="custom-container">
        <h1>Voucher Payers</h1>
        <div class="bread-crumb">
            <a href="{{ url('admin') }}">Dashoboard</a>
            <div>/</div>
            <a href="{{ route('admin.vouchers.index') }}">Vouchers</a>
            <div>/</div>
            <a href="{{ route('admin.vouchers.show', $voucher) }}"> #{{ $voucher->id }}</a>
            <div>/</div>
            <div>C-{{ $section->fullName() }}</div>
        </div>

        @if ($voucher->fees()->whereHas('student', fn($q) => $q->where('section_id', $section->id))->count())
            <div class="grid md:grid-cols-3 md:w-4/5 mx-auto mt-6 bg-white md:p-8 p-4 rounded border">
                <div class="md:col-span-2 text-slate-400 text-sm">
                    Cleaning is a destructive process.
                    It will destory all fee payments from this class against this voucher.
                    Remove only if you are sure!
                </div>
                <div class="text-right">
                    <form action="{{ route('admin.voucher.section.payers.clean', [$voucher, $section]) }}" method="POST"
                        onsubmit="confirmClean(event)">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-red rounded px-5 py-2">
                            <i class="bi-trash3 text-white"></i> Clean All
                        </button>
                    </form>
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
                    <a href="{{ route('admin.voucher.section.payers.import', [$voucher, $section]) }}"
                        class="btn-blue px-5 py-2 rounded"><i class="bi-upload text-white mr-2"></i>
                        Import</a>
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
                            <th class="w-40 text-left">Name</th>
                            <th class="w-24">Group</th>
                            <th class="w-6"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($fees as $fee)
                            <tr class="tr">
                                <td>{{ $fee->student->rollno }}</td>
                                <td class="text-left"><a href="" class="link">{{ $fee->student->name }}</a>
                                    <br>
                                    <span class="text-slate-400 text-xs">{{ $fee->student->father_name }}</span>
                                </td>
                                <td>{{ $fee->student->group?->name }}</td>
                                <td>
                                    <div class="flex items-center justify-center">
                                        @if (!$fee->status)
                                            <form
                                                action="{{ route('admin.voucher.section.payers.destroy', [$voucher, $section, $fee]) }}"
                                                method="POST" onsubmit="return confirmDel(event)">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="bg-transparent p-0 border-0">
                                                    <i class="bi-x text-red-600"></i>
                                                </button>
                                            </form>
                                        @else
                                            <i class="bi-x text-red-300"></i>
                                        @endif
                                    </div>
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
