@extends('layouts.library')
@section('page-content')
    <div class="custom-container">
        <h2>Issued Books</h2>
        <div class="bread-crumb">
            <a href="{{ url('library') }}">Dashoboard</a>
            <div>/</div>
            <div>Issued</div>
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
                        <th>Book</th>
                        <th>Reader</th>
                        <th>Issued On</th>
                        <th>Due On</th>
                    </tr>
                </thead>
                <tbody>

                    @foreach ($bookIssuances->sortByDesc('updated_at') as $bookIssuance)
                        <tr class="tr">
                            <td>{{ $sr++ }}</td>
                            <td class="text-left">{{ $bookIssuance->book->title }}
                                <br>
                                <span
                                    class="text-xs text-slate-600">{{ $bookIssuance->book->reference() }}-{{ $bookIssuance->copy_no }}
                                    @ {{ $bookIssuance->book->author }}</span>
                            </td>
                            <td class="text-left">
                                {{ $bookIssuance->reader->name }}
                                <br>
                                <label for="">
                                    @if ($bookIssuance->user_type == 'App\Models\Student')
                                        {{ $bookIssuance->reader->section->fullName() }}
                                        ({{ $bookIssuance->reader->rollno }})
                                    @else
                                        {{ $bookIssuance->reader->designation }}
                                    @endif
                                </label>
                            </td>
                            <td>{{ $bookIssuance->created_at->format('d/m/Y') }}</td>
                            <td>{{ $bookIssuance->due_date->format('d/m/Y') }}</td>
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
