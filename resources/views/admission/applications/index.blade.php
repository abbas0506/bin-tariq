@extends('layouts.admission')
@section('page-content')
    <div class="custom-container">
        <!-- Title     -->
        <h1>Applications</h1>
        <div class="flex flex-wrap items-center gap-2">
            <div class="flex-1">
                <div class="bread-crumb">
                    <a href="{{ url('/') }}">Home</a>
                    <div>/</div>
                    <div>Applications ( {{ $applications->count() }} )</div>
                </div>
            </div>
            <!-- search -->
            <div class="flex relative w-full md:w-1/3">
                <input type="text" id='searchby' placeholder="Search ..." class="custom-search w-full"
                    oninput="search(event)">
                <i class="bx  bx-search absolute top-2 right-2"></i>
            </div>
        </div>
        <!-- page message -->
        @if ($errors->any())
            <x-message :errors='$errors'></x-message>
        @else
            <x-message></x-message>
        @endif

        @php $sr=1; @endphp
        <div class="overflow-x-auto w-full mt-8">

            <div class="flex space-x-2 mb-4">
                @foreach (['all', 'pending', 'accepted', 'rejected', 'admitted'] as $status)
                    <button onclick="filterTable('{{ $status }}')"
                        class="tab-btn border rounded-full px-5 capitalize @if ($status == 'all') active @endif"
                        id="tab-{{ $status }}">
                        {{ $status }}
                    </button>
                @endforeach
            </div>

            <table class="table-fixed borderless w-full">
                <thead>
                    <tr class="border-b">
                        <th class="w-16">App #</th>
                        <th class="w-40 text-left">Student Name</th>
                        <th class="w-24">Group</th>
                        <th class="w-16">Marks</th>
                        <th class="w-16">%</th>
                        <th class="w-16">Status</th>
                    </tr>
                </thead>
                <tbody id='application-table'>
                    @foreach ($applications->sortByDesc('updated_at') as $application)
                        <tr class="tr" data-status="{{ $application->status }}">
                            <td>
                                <a href="{{ route('admission.applications.show', $application) }}"
                                    class="link">{{ $application->rollno }}</a>
                            </td>
                            <td class="text-left">{{ $application->name }}</td>
                            <td>{{ $application->group->name }}</td>
                            <td>{{ $application->obtained_marks }}</td>
                            <td>{{ $application->obtained_percentage() }}</td>
                            <td>
                                @if ($application->status == 'pending')
                                    <i class="bi-circle-fill text-blue-600 text-xxs mr-1"> </i> {{ $application->status }}
                                @elseif($application->status == 'accepted')
                                    <i class="bi-circle-fill text-green-600 text-xxs mr-1"> </i> {{ $application->status }}
                                @elseif($application->status == 'rejected')
                                    <i class="bi-circle-fill text-red-600 text-xxs mr-1"> </i> {{ $application->status }}
                                @elseif($application->status == 'admitted')
                                    <i class="bi-check font-bold text-green-600"> </i>
                                @endif

                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
@section('script')
    <script type="text/javascript">
        function search(event) {
            // var searchtext = event.target.value.toLowerCase();
            var searchtext = $('#searchby').val().toLowerCase();
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
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.value) {
                    form.submit();
                }
            })
        }

        function filterTable(status) {
            const rows = document.querySelectorAll('#application-table .tr');
            const buttons = document.querySelectorAll('.tab-btn');

            // Reset all tabs
            buttons.forEach(btn => {
                btn.classList.remove('bg-blue-500', 'text-white', 'font-semibold', 'shadow');
                btn.classList.add('bg-gray-200', 'text-black');
            });

            // Highlight active tab
            const activeBtn = document.getElementById(`tab-${status}`);
            activeBtn.classList.remove('bg-gray-200', 'text-black');
            activeBtn.classList.add('bg-blue-500', 'text-white', 'font-semibold', 'shadow');

            // Filter table rows
            rows.forEach(row => {
                const rowStatus = row.getAttribute('data-status');
                if (status === 'all' || rowStatus === status) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }

        // Run on page load
        window.onload = () => filterTable('all');
    </script>
@endsection
