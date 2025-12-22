@extends('layouts.admin')
@section('page-content')
    <div class="custom-container">
        <h1>Teachers</h1>
        <div class="bread-crumb">
            <a href="{{ url('admin') }}">Home</a>
            <div>/</div>
            <div>Teachers</div>
        </div>

        <!-- search -->
        <!-- <div class="flex justify-between items-center flex-wrap gap-6 mt-12"> -->
        <div class="flex relative w-full md:w-1/3">
            <input type="text" id='searchby' placeholder="Search ..." class="custom-search w-full" oninput="search(event)">
            <i class="bx  bx-search absolute top-2 right-2"></i>
        </div>
        <div class="flex justify-center items-center gap-3 flex-wrap mt-5">
            {{-- <a href=""><i class="bi bi-person-add text-teal-600"></i></a>
            <a href="" class=""><i class="bi bi-file-earmark-plus text-teal-600"></i></a> --}}
            <a href="{{ route('admin.teacher-cards.index') }}" class=""><i
                    class="bi-person-badge text-indigo-600"></i></a>
            <a href="" class=""><i class="bi-recycle text-orange-600"></i></a>
            <a href="" class=""><i class="bi-printer text-teal-600"></i></a>
        </div>

        <!-- page message -->
        @if ($errors->any())
            <x-message :errors='$errors'></x-message>
        @else
            <x-message></x-message>
        @endif

        <div class="overflow-x-auto bg-white w-full mt-8">
            <table class="table-auto borderless w-full">
                <thead>
                    <tr>
                        <th class="w-10">#</th>
                        <th class="w-48 text-left">Name</th>
                        <th class="w-24"></th>
                        <th class="w-16">Photo</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($teachers->sortByDesc('bps') as $teacher)
                        <tr class="tr">
                            <td>{{ $loop->iteration }}</td>
                            <td class="text-left"><a href="{{ route('admin.teachers.show', $teacher) }}"
                                    class="link">{{ $teacher->name }}</a><br>
                                <span class="text-slate-500 text-xs">{{ $teacher->designation }}</span>
                            </td>
                            <td class="text-left px-3">
                                <div class="grid divide-x-0">
                                    @foreach ($teacher->user->roles as $role)
                                        {{ $role->name }} @if (!$loop->last)
                                            |
                                        @endif
                                    @endforeach
                                </div>
                            </td>
                            <td><img src="{{ asset('storage/' . $teacher->photo) }}" alt="photo"
                                    class="rounded mx-auto w-8 h-8"></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>
    <script>
        function search(event) {
            var searchtext = event.target.value.toLowerCase();
            var str = 0;
            $('.tr').each(function() {
                if (!(
                        $(this).children().eq(0).prop('outerText').toLowerCase().includes(searchtext) ||
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
