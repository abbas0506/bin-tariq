@extends('layouts.library')
@section('page-content')
    <div class="custom-container">
        <h2>Defaulters</h2>
        <div class="bread-crumb">
            <a href="{{ url('library') }}">Dashoboard</a>
            <div>/</div>
            <div>Defaulters</div>
            <div>/</div>
            <div>All</div>
        </div>

        <div class="mt-8">
            <div class="flex items-center no-wrap justify-between w-full mt-8">
                <!-- search -->
                <div class="flex relative md:w-1/3">
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
            <table class="table-auto w-full mt-4">
                <thead>
                    <tr class="border-b border-slate-200">
                        <th>Sr</th>
                        <th>Reader</th>
                        <th>Book</th>
                        <th>Reminder</th>
                    </tr>
                </thead>
                <tbody>

                    @foreach ($defaulters->sortByDesc('updated_at') as $user)
                        <tr class="tr">
                            <td>{{ $sr++ }}</td>

                            <td class="text-left">
                                <h3>{{ $user->userable->name }}</h3>
                                <label for="">
                                    @if ($user->userable_type == 'App\Models\Student')
                                        {{ $user->userable->clas->roman() }} ({{ $user->userable->rollno }})
                                    @else
                                        {{ $user->userable->designation }}
                                    @endif
                                </label>
                            </td>
                            <td class="text-left">

                                @foreach ($user->bookIssuances()->pending()->get() as $bookIssuance)
                                    <div class="mb-2">
                                        <p>{{ $bookIssuance->book->title }}</p>
                                        <label>{{ $bookIssuance->book->reference() }}-{{ $bookIssuance->copy_no }} @
                                            {{ $bookIssuance->book->author }}</label>
                                        <label> <i class="bi-clock ml-3"></i>{{ $bookIssuance->due_date->format('d/m/y') }}
                                            ({{ $bookIssuance->latency() }} days +)</label>

                                    </div>
                                @endforeach
                            </td>
                            <td><i class="bi-bell"></i></td>
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
