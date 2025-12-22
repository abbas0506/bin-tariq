@extends('layouts.admission')
@section('page-content')
    <div class="custom-container">
        <!-- Title     -->
        <h1>Objections</h1>

        <div class="bread-crumb">
            <a href="{{ url('/') }}">Dashboard</a>
            <div>/</div>
            <a href="{{ route('admission.applications.index') }}">Applications</a>
            <div>/</div>
            <div>Rejected ( {{ $applications->count() }} )</div>
        </div>


        <div class="flex mt-4">
            <!-- search -->
            <div class="flex relative w-full md:w-1/3">
                <input type="text" id='searchby' placeholder="Search ..." class="custom-search w-full"
                    oninput="search(event)">
                <i class="bx  bx-search absolute top-2 right-2"></i>
            </div>
            <div class="flex justify-end w-full">
                <div class="flex w-12 h-12 items-center justify-center rounded-full bg-orange-100 hover:bg-orange-200">
                    <a href="{{ route('admission.print.objections') }}" target="_blank"><i class="bi-printer"></i></a>
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
                        <th class="w-12">App #</th>
                        <th class="w-40 text-left">Student Name</th>
                        <th class="w-24">Group</th>
                        <th class="w-12">Marks</th>
                        <th class="w-24">Rejection Note</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($applications->sortByDesc('updated_at') as $application)
                        <tr class="tr text-sm border-b">
                            <td><a href="{{ route('admission.applications.show', $application) }}"
                                    class="link"></a>{{ $application->rollno }}</td>
                            <td class="text-left">{{ $application->name }}</td>
                            <td>{{ $application->group->name }}</td>
                            <td>{{ $application->obtained_marks }}</td>
                            <td>{{ $application->rejection_note }}</td>
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
    </script>
@endsection
