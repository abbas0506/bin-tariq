@extends('layouts.library')
@section('page-content')
    <div class="custom-container">
        <h2>Domains / {{ $domain->name }}</h2>
        <div class="bread-crumb">
            <a href="{{ url('library') }}">Dashoboard</a>
            <div>/</div>
            <a href="{{ route('library.domains.index') }}">Domains </a>
            <div>/</div>
            <div>{{ $domain->name }}</div>
            <div>/</div>
            <div>Books ( {{ $domain->books->count() }} )</div>
        </div>

        <div class="mt-8">
            <div class="flex items-center flex-wrap justify-between mt-8 gap-4">
                <!-- search -->
                <div class="flex relative w-full md:w-1/3">
                    <input type="text" id='searchby' placeholder="Search ..." class="custom-search w-full"
                        oninput="search(event)">
                    <i class="bx  bx-search absolute top-2 right-2"></i>
                </div>
                <a href="{{ route('library.domain.books.create', $domain) }}" class="btn-teal rounded">New Book <i
                        class="bi-plus"></i></a>
            </div>
            <!-- page message -->
            @if ($errors->any())
                <x-message :errors='$errors'></x-message>
            @else
                <x-message></x-message>
            @endif

            <div class="flex items-center flex-wrap justify-between mt-8">
                <div id="filterSection" class="hidden border border-slate-200 p-4">
                    <div class="grid grid-col-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
                        <div id='all' class="filterOption active" onclick="filter('all')">
                            <span class="desc">All</span>
                            <span class="ml-1 text-sm text-slate-600">
                                ({{ $domain->books->count() }})
                            </span>
                        </div>

                    </div>
                </div>
            </div>
            @php $sr=1; @endphp
            <div class="overflow-x-auto w-full">
                <table class="table-fixed w-full mt-1">
                    <thead>
                        <tr class="border-b border-slate-200">
                            <th class="w-12">Sr</th>
                            <th class="w-40">Title/Author</th>
                            <th class="w-16">Ref.</th>
                            <th class="w-24">Published</th>
                            <th class="w-24">Copies</th>
                            <th class="w-24">Action</th>

                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($domain->books->sortByDesc('updated_at') as $book)
                            <tr class="tr">

                                <td>{{ $sr++ }}</td>
                                <td class="text-left">
                                    <a href="{{ route('library.domain.books.show', [$domain, $book]) }}"
                                        class='link'>{{ $book->title }}</a>
                                    <p class="text-xs text-slate-600">{{ $book->author }}</p>
                                </td>
                                <td>{{ $book->reference() }}</td>
                                <td>{{ $book->publish_year }}</td>
                                <td>{{ $book->num_of_copies }}</td>
                                <td>
                                    <div class="flex items-center justify-center">
                                        <a href="{{ route('library.domain.books.edit', [$domain, $book]) }}"><i
                                                class="bx  bx-pencil text-green-600"></i></a>
                                        <span class="text-slate-300 px-2">|</span>
                                        <form action="{{ route('library.domain.books.destroy', [$domain, $book]) }}"
                                            method="post" onsubmit="return confirmDel(event)">
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
