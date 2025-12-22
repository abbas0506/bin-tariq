@extends('layouts.library')
@section('page-content')
    <div class="custom-container">
        <h2>Racks</h2>
        <div class="bread-crumb">
            <a href="{{ url('library') }}">Dashoboard</a>
            <div>/</div>
            <div>Racks</div>
            <div>/</div>
            <div>All</div>
        </div>

        <div class="mt-8">
            <a href="{{ route('library.racks.create') }}" class="btn-teal rounded-sm">Create New Rack <i
                    class="bi-plus ml-2"></i></a>
            @php $sr=1; @endphp
            <div class="container overflow-x-auto w-full mt-2 bg-white p-5 md:p-8">
                <table class="table-fixed borderless w-full">
                    <thead>
                        <tr class="">
                            <th class="w-8">Sr</th>
                            <th class="w-24">Name</th>
                            <th class="w-16">Books <span class="text-sm">({{ $books->count() }})</span></th>
                            <th class="w-16">Copies <span class="text-sm">({{ $books->sum('num_of_copies') }})</span></th>
                            <!-- <th class="w-16">QR</th> -->
                            <th class="w-24">Action</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($racks as $rack)
                            <tr class="tr">
                                <td>{{ $sr++ }}</td>
                                <td>
                                    <a href="{{ route('library.rack.books.index', $rack) }}"
                                        class="link">{{ $rack->label }}</a>
                                </td>
                                <td>{{ $rack->books->count() }}</td>
                                <td>{{ $rack->books->sum('num_of_copies') }}</td>
                                <td>
                                    <div class="flex items-center justify-center">
                                        <a href="{{ route('library.print.rack-books.list', $rack) }}" target="_blank"><i
                                                class="bi bi-printer text-slate-600"></i></a>
                                        <span class="text-slate-300 px-2">|</span>
                                        <a href="{{ route('library.racks.edit', $rack) }}"><i
                                                class="bx  bx-pencil text-green-600"></i></a>
                                        <span class="text-slate-300 px-2">|</span>
                                        <form action="{{ route('library.racks.destroy', $rack) }}" method="post"
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
