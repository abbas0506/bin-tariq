@extends('layouts.teacher')
@section('page-content')
    <h1>Tasks</h1>
    <div class="bread-crumb">
        <a href="{{ url('/') }}">Home</a>
        <div>/</div>
        <div>Tasks</div>
    </div>


    <div class="content-section">
        <div class="flex items-center flex-wrap justify-between">
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


        <div class="md:w-4/5 mx-auto bg-white md:p-8 p-4 rounded border mt-12">
            <h2 class="text-red-500"> <i class="bi-clock"></i> Pending Tasks</h2>
            <table class="table-auto borderless w-full mt-8">
                <thead>
                    <tr class="">
                        <th class="w-12">Sr</th>
                        <th class="text-left">Task Desc</th>
                    </tr>
                </thead>
                <tbody>

                    @foreach ($tasks as $task)
                        <tr class="tr">
                            <td>{{ $loop->index + 1 }}</td>
                            <td class="text-left">
                                <div>{{ $task->description }}</div>
                                <span class="text-xs text-slate-400">Due date:
                                    {{ $task->due_date->format('d-m-Y') }}</span>
                            </td>
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
