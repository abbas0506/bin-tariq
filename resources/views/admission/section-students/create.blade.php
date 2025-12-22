@extends('layouts.admission')
@section('page-content')
    <div class="custom-container">
        <!-- Title     -->
        <h1>Applications</h1>
        <div class="flex flex-wrap items-center gap-2">
            <div class="flex-1">
                <div class="bread-crumb">
                    <a href="{{ url('/') }}">Dashboard</a>
                    <div>/</div>
                    <div>Applications ( {{ $applications->count() }} )</div>
                </div>
            </div>
        </div>

        <form action="{{ route('admission.section.students.store', $section) }}" method="post">
            @csrf
            <div class="flex mt-4">
                <!-- search -->
                <div class="flex relative w-full md:w-1/3">
                    <input type="text" id='searchby' placeholder="Search ..." class="custom-search w-full"
                        oninput="search(event)">
                    <i class="bx  bx-search absolute top-2 right-2"></i>
                </div>
                <div class="flex justify-end w-full items-center">
                    <div id="chkCount"
                        class="w-6 h-6 flex justify-center items-center text-xs  text-slate-600 rounded-full"></div>
                    <div class="flex w-12 h-12 items-center justify-center rounded-full bg-orange-100 hover:bg-orange-200">
                        <button type="submit"><i class="bi-upload"></i></button>
                    </div>
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

                <table class="table-fixed borderless w-full">
                    <thead>
                        <tr class="border-b">
                            <th class="w-8">Sr</th>
                            <th class="w-16">App #</th>
                            <th class="w-40 text-left">Student Name</th>
                            <th class="w-24">Group</th>
                            <th class="w-16">Marks</th>
                            <th class="w-16">%</th>
                            <th class="w-16">Fee</th>
                            <th class="w-16"> <input type="checkbox" id='chkAll' class="rounded" onclick="checkAll()">
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($applications->sortByDesc('updated_at') as $application)
                            <tr class="tr text-sm border-b">
                                <td>{{ $sr++ }}</td>
                                <td>
                                    <a href="{{ route('admission.applications.show', $application) }}"
                                        class="link">{{ $application->rollno }}</a>
                                </td>
                                <td class="text-left">{{ $application->name }}</td>
                                <td>{{ $application->group->name }}</td>
                                <td>{{ $application->obtained_marks }}</td>
                                <td>{{ $application->obtained_percentage() }}</td>
                                <td>{{ $application->amount_paid }}</td>
                                <td>
                                    <input type="checkbox" class="rounded" name="application_ids_array[]"
                                        value="{{ $application->id }}" onclick="updateChkCount()">
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </form>
    </div>
@endsection
@section('script')
    <script type="text/javascript">
        function updateChkCount() {
            var chkArray = [];
            var chks = document.getElementsByName('application_ids_array[]');
            chks.forEach((chk) => {
                if (chk.checked) chkArray.push(chk.value);
            })

            document.getElementById("chkCount").innerHTML = chkArray.length;
        }

        function checkAll() {

            $('.tr').each(function() {
                if (!$(this).hasClass('hidden'))
                    $(this).children().find('input[type=checkbox]').prop('checked', $('#chkAll').is(':checked'));
                updateChkCount()
            });
        }



        function search(event) {
            // var searchtext = event.target.value.toLowerCase();
            var searchtext = $('#searchby').val().toLowerCase();
            var str = 0;
            $('.tr').each(function() {
                if (!(
                        // search by form no or group name
                        $(this).children().eq(1).prop('outerText').toLowerCase().includes(searchtext) ||
                        $(this).children().eq(3).prop('outerText').toLowerCase().includes(searchtext)
                    )) {
                    $(this).addClass('hidden');
                } else {
                    $(this).removeClass('hidden');
                }
            });
        }
    </script>
@endsection
