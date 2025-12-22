@extends('layouts.admin')
@section('page-content')
    <div class="custom-container">
        <h1>Import Voucher Payers</h1>
        <div class="bread-crumb">
            <a href="{{ url('admin') }}">Dashoboard</a>
            <div>/</div>
            <a href="{{ route('admin.vouchers.index') }}">Vouchers</a>
            <div>/</div>
            <a href="{{ route('admin.vouchers.show', $voucher) }}"> #{{ $voucher->id }}</a>
            <div>/</div>
            <div>C-{{ $section->fullName() }}</div>
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
        2qw
        <div class="overflow-x-auto bg-white w-full mt-8">
            <form action="{{ route('admin.voucher.section.payers.import.post', [$voucher, $section]) }}" method="post"
                onsubmit="return confirmSubmit(event)">
                @csrf
                <table class="table-auto borderless w-full">
                    <thead>
                        <tr>
                            <th class="w-8">#</th>
                            <th class="w-40 text-left">Name</th>
                            <th class="w-24">Group</th>
                            <th class="w-6"><input type="checkbox" id='chkAll' class="rounded" onclick="checkAll()">
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($students->sortBy('rollno') as $student)
                            <tr class="tr">
                                <td>{{ $student->rollno }}</td>
                                <td class="text-left"><a
                                        href="{{ route('admin.section.students.show', [$section, $student]) }}"
                                        class="link">{{ $student->name }}</a>
                                    <br>
                                    <span class="text-slate-400 text-sm">{{ $student->father_name }}</span>
                                </td>
                                <td>{{ $student->group?->name }}</td>
                                <td>
                                    <div class="flex items-center justify-center">
                                        <input type="checkbox" class="w-4 h-4 rounded" name="student_ids_array[]"
                                            value="{{ $student->id }}">
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <button type="submit" class="btn-blue float-right mt-5 rounded py-2">Import Now</button>
            </form>
        </div>

    </div>

    <script type="text/javascript">
        function confirmSubmit(event) {
            event.preventDefault(); // prevent form submit
            var form = event.target; // storing the form

            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, import now!'
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

        function checkAll() {

            $('.tr').each(function() {
                if (!$(this).hasClass('hidden'))
                    $(this).children().find('input[type=checkbox]').prop('checked', $('#chkAll').is(':checked'));
                // updateChkCount()
            });
        }
    </script>
@endsection
