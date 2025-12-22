@extends('layouts.library')
@section('page-content')
    <div class="custom-container">
        <h2>Racks / {{ $rack->label }}</h2>
        <div class="bread-crumb">
            <a href="{{ url('library') }}">Dashoboard</a>
            <div>/</div>
            <a href="{{ route('library.racks.index') }}">Racks</a>
            <div>/</div>
            <div>{{ $rack->label }} / Books ({{ $rack->books->count() }})</div>
        </div>

        <div class="flex relative w-full md:w-1/3 mt-12">
            <input type="text" id='searchby' placeholder="Search ..." class="custom-search w-full" oninput="search(event)">
            <i class="bx  bx-search absolute top-2 right-2"></i>
        </div>

        <!-- page message -->
        @if ($errors->any())
            <x-message :errors='$errors'></x-message>
        @else
            <x-message></x-message>
        @endif

        <div class="flex items-center flex-wrap justify-between mt-8">
            <div class="flex items-center flex-wrap gap-4">
                <form action="{{ route('library.print.rack-books.qr', $rack) }}" method="get"
                    class="flex items-center flex-wrap gap-x-4">
                    @csrf
                    <input type="number" name='from' placeholder="From" value="{{ $rack->books->first()->serial() }}"
                        class="custom-input text-center w-16 lg:w-24 text-xs py-2">
                    <label>-</label>
                    <input type="number" name='to' placeholder="To" value="{{ $rack->books->last()->serial() }}"
                        class="custom-input text-center w-16 lg:w-24 text-xs py-2">
                    <button type="submit" class="btn-orange py-1"><i class="bi-qr-code"></i></button>
            </div>
            <div class="flex flex-wrap justify-center items-center space-x-2 w-32">
                <a href="{{ route('library.print.rack-books.list', $rack) }}" target="_blank"><i
                        class="bi bi-printer text-slate-600"></i></a>
                <label>({{ $rack->books->count() }})</label>
            </div>
        </div>
        @php
            $sr = 1;
            $runningSumOfCopies = 0;
        @endphp
        <div class="overflow-x-auto w-full mt-3">
            <table class="table-fixed w-full">
                <thead>
                    <tr class="border-b border-slate-200">
                        <th class="w-12">Sr</th>
                        <th class="w-40">Title/Author</th>
                        <th class="w-16">Ref.</th>
                        <th class="w-24">Copies</th>
                        <th class="w-24">Action</th>
                    </tr>
                </thead>
                <tbody>

                    @foreach ($rack->books as $book)
                        <tr class="tr">

                            <td>{{ $sr++ }}</td>
                            <td class="text-left">
                                <a href="{{ route('library.rack.books.show', [$rack, $book]) }}"
                                    class='link'>{{ $book->title }}</a>
                                <p class="text-xs text-slate-600">{{ $book->author }}</p>
                            </td>
                            <td>{{ $book->reference() }}</td>
                            @php
                                $runningSumOfCopies += $book->num_of_copies;
                            @endphp
                            <td>{{ $book->num_of_copies }} <i class="bi-dash-lg"></i>
                                <span>({{ $runningSumOfCopies }})</span>
                            </td>
                            <td>
                                <div class="flex items-center justify-center">
                                    <a href="{{ route('library.rack.books.edit', [$rack, $book]) }}"><i
                                            class="bx  bx-pencil text-green-600"></i></a>
                                    <span class="text-slate-300 px-2">|</span>
                                    <form action="{{ route('library.rack.books.destroy', [$rack, $book]) }}" method="post"
                                        onsubmit="return confirmDel(event)">
                                        @csrf
                                        @method('DELETE')
                                        <button><i class="bx  bx-trash text-red-600"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
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
