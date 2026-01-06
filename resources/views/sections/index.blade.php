@extends('layouts.app')
@section('page-content')
    <div class="custom-container">
        <h1>Classes</h1>
        <div class="bread-crumb">
            <a href="{{ url('/') }}">Dashoboard</a>
            <div>/</div>
            <div>Classes</div>
            <div>/</div>
            <div>All</div>
        </div>
        <div class="md:w-4/5 mx-auto overflow-auto bg-white md:p-8 p-4 mt-8">
            <div class="flex items-center flex-wrap justify-between">
                <!-- search -->
                <div class="flex relative w-full md:w-1/3">
                    <input type="text" id='searchby' placeholder="Search ..." class="custom-search w-full"
                        oninput="search(event)">
                    <i class="bx bx-search absolute top-2 right-2"></i>
                </div>
                <a href="{{ route('subjects.create') }}" class="btn-teal rounded">New</a>
            </div>

            <table class="table-fixed borderless w-full mt-5">
                <thead>
                    <tr class="tr">
                        <th class="w-6">#</th>
                        <th class="text-left w-48">Class</th>
                        <th class="w-6"><i class="bi-person"></i></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($sections->sortBy('grade') as $section)
                        <tr class="tr">
                            <td>{{ $loop->index + 1 }}</td>
                            <td class="text-left"><a href="{{ route('sections.show', $section) }}"
                                    class="link">{{ $section->name }}</a>
                                @if ($section->students()->createdToday()->count())
                                    <span class="text-green-600 text-xs ml-2"><i
                                            class="bi-arrow-up"></i>{{ $section->students()->createdToday()->count() }}</span>
                                @endif
                            </td>
                            <td>{{ $section->students->count() }}</td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>

    @can('create', Section::class)
        <a href="{{ route('sections.create') }}"
            class="fixed bottom-8 right-8 flex rounded-full w-12 h-12 btn-blue justify-center items-center text-2xl"><i
                class="bi bi-plus"></i></a>
    @endcan
@endsection
@section('script')
    <script type="text/javascript">
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
