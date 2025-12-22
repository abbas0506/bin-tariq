@extends('layouts.admission')
@section('page-content')
<div class="custom-container">
    <!--welcome  -->
    <div class="flex items-center">
        <div class="flex-1">
            <div class="bread-crumb">
                <div>Admission Portal</div>
                <div>/</div>
                <div>Dashboard</div>
            </div>
        </div>
    </div>
    <!-- pallets -->
    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-4 mt-3">
        <a href="{{ route('admission.applications.index') }}" class="pallet-box">
            <div class="flex-1 ">
                <div class="title">Pending Applications</div>
                <div class="flex items-center">
                    <div class="h2 mr-8">{{ $stats['pending_total'] }}</div>
                    @if($stats['pending_today']>0)
                    <i class="bi-arrow-up text-yellow-700 text-sm"></i>
                    <p class="text-yellow-700 text-sm">{{ $stats['pending_today'] }}</p>
                    @endif
                </div>
            </div>
            <div class="ico bg-yellow-100">
                <i class="bi bi-file-earmark-text text-yellow-600"></i>
            </div>
        </a>
        <a href="{{ route('admission.applications.index') }}" class="pallet-box">
            <div class="flex-1 ">
                <div class="title">Accepted Applications</div>
                <div class="flex items-center">
                    <div class="h2 mr-8">{{ $stats['accepted_total'] }}</div>
                    @if($stats['accepted_today']>0)
                    <i class="bi-arrow-up text-green-700 text-sm"></i>
                    <p class="text-green-700 text-sm">{{ $stats['accepted_today'] }}</p>
                    @endif
                </div>
            </div>
            <div class="ico bg-green-100">
                <i class="bi bi-file-earmark-text text-green-600"></i>
            </div>
        </a>
        <a href="{{ route('admission.applications.index') }}" class="pallet-box">
            <div class="flex-1 ">
                <div class="title">Rejected Applications</div>
                <div class="flex items-center">
                    <div class="h2 mr-8">{{ $stats['rejected_total'] }}</div>
                    @if($stats['rejected_today']>0)
                    <i class="bi-arrow-up text-red-700 text-sm"></i>
                    <p class="text-red-700 text-sm">{{ $stats['rejected_today'] }}</p>
                    @endif
                </div>
            </div>
            <div class="ico bg-red-100">
                <i class="bi bi-file-earmark-text text-red-600"></i>
            </div>
        </a>
        <a href="{{ route('admission.applications.index') }}" class="pallet-box">
            <div class="flex-1 ">
                <div class="title">Admitted Students</div>
                <div class="flex items-center">
                    <div class="h2 mr-8">{{ $stats['admitted_total'] }}</div>
                    @if($stats['admitted_today']>0)
                    <i class="bi-arrow-up text-teal-700 text-sm"></i>
                    <p class="text-teal-700 text-sm">{{ $stats['admitted_today'] }}({{ $stats['amount_paid_today'] }})</p>
                    @endif
                </div>
            </div>
            <div class="ico bg-teal-100">
                <i class="bi bi-person text-teal-600"></i>
            </div>
        </a>
    </div>

    <!-- Data  -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-5 ">
        <!-- Recent Applications -->
        <div class="grid-cols-1 md:col-span-3 bg-white order-2 md:order-1">
            <h2 class="mt-8">Recent Applications ({{ $applications_today->count() }})</h2>
            <div class="overflow-x-auto w-full mt-2">
                <table class="table-fixed w-full">
                    <thead>
                        <tr class="border-b">
                            <th class="w-16">App #</th>
                            <th class="w-40 text-left">Student Name</th>
                            <th class="w-24">Group</th>
                            <th class="w-16">Marks</th>
                            <th class="w-16">Status</th>
                            <th class="w-20">Submitted</th>
                        </tr>
                    </thead>
                    <tbody id='application-table'>
                        @foreach($applications_today as $application)
                        <tr class="tr" data-status="{{ $application->status }}">
                            <td>
                                <a href="{{ route('admission.applications.show', $application) }}" class="link">{{ $application->rollno }}</a>
                            </td>
                            <td class="text-left">{{ $application->name }}</td>
                            <td>{{ $application->group->name }}</td>
                            <td>{{ $application->obtained_marks }}</td>
                            <td>@if($application->status == 'pending')
                                <i class="bi-circle-fill text-blue-600 text-xxs mr-1"> </i> {{ $application->status }}
                                @elseif($application->status == 'accepted')
                                <i class="bi-circle-fill text-green-600 text-xxs mr-1"> </i> {{ $application->status }}
                                @elseif($application->status == 'rejected')
                                <i class="bi-circle-fill text-red-600 text-xxs mr-1"> </i> {{ $application->status }}
                                @elseif($application->status == 'admitted')
                                <i class="bi-check font-bold text-green-600"> </i>
                                @endif

                            </td>
                            <td>{{$application->created_at->diffForHumans()}}</td>

                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- generarl stat -->
        <div class="order-1 md:order-2">
            <h2 class="mt-8">General Stat</h2>
            <div class="grid mt-2 gap-2 text-xs border rounded-lg p-3 bg-blue-100">
                <div class="grid grid-cols-4">
                    <div class="col-span-2">Applications</div>
                    <div>
                        @if($applications_today->count())
                        <i class="bi-arrow-up ml-3"></i>{{ $applications_today->count() }}
                        @endif
                    </div>
                    <div class="">{{$stats['applications_admitted']}}/{{ $stats['applications_total'] }}</div>
                </div>
                <div class="grid grid-cols-4">
                    <div class="col-span-2">Pre Engg.</div>
                    <div>
                        @if($stats['pre_engg_today']>0)
                        <i class="bi-arrow-up ml-3"></i>{{$stats['pre_engg_today']}}
                        @endif
                    </div>
                    <div class="">{{$stats['pre_engg_admitted']}}/{{$stats['pre_engg_total']}}</div>
                </div>
                <div class="grid grid-cols-4">
                    <div class="col-span-2">ICS</div>
                    <div>
                        @if($stats['ics_today']>0)
                        <i class="bi-arrow-up ml-3"></i>{{$stats['ics_today']}}
                        @endif
                    </div>
                    <div class="">{{$stats['ics_admitted']}}/{{$stats['ics_total']}}</div>
                </div>
                <div class="grid grid-cols-4">
                    <div class="col-span-2">Arts</div>
                    <div>
                        @if($stats['arts_today']>0)
                        <i class="bi-arrow-up ml-3"></i>{{$stats['arts_today']}}
                        @endif
                    </div>
                    <div class="">{{$stats['arts_admitted']}}/{{$stats['arts_total']}}</div>
                </div>
                <div class="grid grid-cols-4">
                    <div class="col-span-2">1000+</div>
                    <div>
                        @if($stats['1000+_today']>0)
                        <i class="bi-arrow-up ml-3"></i>{{$stats['1000+_today']}}
                        @endif
                    </div>
                    <div class="">{{$stats['1000+_admitted']}}/{{$stats['1000+_total']}}</div>
                </div>
                <div class="grid grid-cols-4">
                    <div class="col-span-2">Other Board</div>
                    <div>
                        @if($stats['other_board_today']>0)
                        <i class="bi-arrow-up ml-3"></i>{{$stats['other_board_today']}}
                        @endif
                    </div>
                    <div class="">{{$stats['other_board_admitted']}}/{{$stats['other_board_total']}}</div>
                </div>
                <div class="grid grid-cols-4">
                    <div class="col-span-2">Fee</div>
                    <div>
                        @if($stats['amount_paid_today']>0)
                        <i class="bi-arrow-up ml-3"></i>{{$stats['amount_paid_today']}}
                        @endif
                    </div>
                    <div class="">{{ $stats['amount_paid_total'] }}</div>
                </div>
            </div>
        </div>
    </div>


</div>

@endsection
@section('script')
<script lang="javascript">
    function delme(formid) {
        event.preventDefault();
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
                //submit corresponding form
                $('#deleteform' + formid).submit();
            }
        });
    }


    function payfee(formid, fee) {
        event.preventDefault();

        Swal.fire({
            title: 'Fee payment',
            text: "Have you recieved fee? Rs." + fee,
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, recieved!'
        }).then((result) => {
            if (result.value) {
                //submit corresponding form
                $('#postfee' + formid).submit();
            }
        });
    }

    function search(event) {
        var searchtext = event.target.value.toLowerCase();
        var str = 0;
        $('.tr').each(function() {
            if (!(
                    $(this).children().eq(0).prop('outerText').toLowerCase().includes(searchtext) ||
                    $(this).children().eq(1).prop('outerText').toLowerCase().includes(searchtext) ||
                    $(this).children().eq(3).prop('outerText').toLowerCase().includes(searchtext)
                )) {
                $(this).addClass('hide');
            } else {
                $(this).removeClass('hide');
            }


        });

        function filterStatus(status) {
            const rows = document.querySelectorAll('#application-table .tr');
            rows.forEach(row => {
                const rowStatus = row.getAttribute('data-status');
                if (status === 'all' || rowStatus === status) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }
    }
</script>
@endsection