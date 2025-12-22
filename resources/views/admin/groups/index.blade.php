@extends('layouts.admin')
@section('page-content')
    <div class="custom-container">
        <h1>Groups Management</h1>
        <div class="bread-crumb">
            <div>Groups</div>
            <div>/</div>
            <div>All</div>
        </div>

        <div class="flex items-center flex-wrap justify-between mt-8">
            <!-- search -->
            <div class="flex relative w-full md:w-1/3">
                <input type="text" id='searchby' placeholder="Search ..." class="custom-search w-full"
                    oninput="search(event)">
                <i class="bx  bx-search absolute top-2 right-2"></i>
            </div>

            <a href="{{ route('admin.groups.create') }}" class="btn-teal rounded">Create New</a>
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
                    <th>Full Name</th>
                    <th>Short</th>
                    <th>Fee</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>

                @foreach ($groups as $group)
                    <tr class="tr">
                        <td>{{ $group->name }}</td>
                        <td class="text-center">{{ $group->short }}</td>
                        <td class="text-center">{{ $group->fee }}</td>
                        <td>
                            <div class="flex justify-center items-center space-x-3">
                                <a href="{{ route('admin.groups.edit', $group) }}">
                                    <i class="bi bi-pencil-square text-green-600"></i>
                                </a>
                                <form action="{{ route('admin.groups.destroy', $group) }}" method="POST"
                                    id='del_form{{ $group->id }}'>
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-transparent p-0 border-0"
                                        onclick="delme('{{ $group->id }}')">
                                        <i class="bi bi-trash3 text-red-600"></i>
                                    </button>
                                </form>
                            </div>

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
