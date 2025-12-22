@extends('layouts.admin')
@section('page-content')
    <div class="custom-container">
        <h1>Session Management</h1>
        <div class="bread-crumb">
            <div>Sessions</div>
            <div>/</div>
            <div>All</div>
        </div>

        <div class="flex items-center flex-wrap justify-between">
            <!-- search -->
            <div class="flex relative w-full md:w-1/3 mt-8">
                <input type="text" id='searchby' placeholder="Search ..." class="custom-search w-full"
                    oninput="search(event)">
                <i class="bx  bx-search absolute top-2 right-2"></i>
            </div>

            <form method='post' action="{{ route('admin.sessions.store') }}">
                @csrf
                <button type="submit" class="btn-indigo">Add New Session</button>
            </form>
        </div>

        <!-- page message -->
        @if ($errors->any())
            <x-message :errors='$errors'></x-message>
        @else
            <x-message></x-message>
        @endif

        <table class="table-auto w-full mt-8">
            <thead>
                <tr class="border-b border-slate-200">
                    <th>Session</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>

                @foreach ($sessions->sortByDesc('active') as $session)
                    <tr class="tr border-b text-center ">
                        <td class="py-2 text-slate-600">{{ $session->title() }}</td>
                        <td>
                            <a href="{{ route('admin.sessions.edit', $session) }}" class="flex justify-center">
                                @if ($session->active == 1)
                                    <i class="bi bi-toggle2-on text-teal-600 text-lg"></i>
                                @else
                                    <i class="bi bi-toggle2-off text-red-600 text-lg"></i>
                                @endif
                            </a>

                        </td>
                    </tr>
                @endforeach

            </tbody>
        </table>
    </div>

    <script type="text/javascript">
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
                    $('#del_form' + formid).submit();
                }
            });
        }

        function search(event) {
            var searchtext = event.target.value.toLowerCase();
            var str = 0;
            $('.tr').each(function() {
                if (!(
                        $(this).children().eq(0).prop('outerText').toLowerCase().includes(searchtext)
                    )) {
                    $(this).addClass('hidden');
                } else {
                    $(this).removeClass('hidden');
                }
            });
        }
    </script>
@endsection
