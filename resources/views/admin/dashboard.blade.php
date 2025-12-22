@extends('layouts.admin')
@section('page-content')
    <!--welcome  -->
    <div class="flex items-center">
        <div class="bread-crumb">
            <div>Admin</div>
            <div>/</div>
            <div><i class="bi-house"></i></div>
        </div>
    </div>

    <!-- pallets -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mt-8">
        <a href="{{ route('admin.sections.index') }}" class="pallet-box">
            <div class="flex-1">
                <div class="title">Classes</div>
                <div class="flex items-center">
                    <div class="h2">{{ $sections->count() }}</div>
                    <i class="bi-person text-sm ml-4"></i>
                    <p class="text-sm ml-1">{{ $students->count() }}</p>
                </div>
            </div>
            <div class="ico bg-green-100">
                <i class="bi bi-layers text-green-600"></i>
            </div>
        </a>
        <a href="{{ route('admin.attendance.index') }}" class="pallet-box">
            <div class="flex-1">
                <div class="title">Attendance
                    @if ($attendances->count())
                        <sup><i class="bi-circle-fill text-green-500 text-xxs"></i></sup>
                    @endif
                </div>
                <div class="h2">{{ $attendances->count() }} / {{ $students->count() }}</div>
            </div>
            <div class="ico bg-orange-100">
                <i class="bi bi-person-check text-orange-400"></i>
            </div>
        </a>
        <a href="{{ route('admin.tests.index') }}" class="pallet-box">
            <div class="flex-1">
                <div class="title">Assessment
                    @if ($tests->where('is_open', 1)->count())
                        <sup><i class="bi-circle-fill text-green-500 text-xxs"></i></sup>
                    @endif
                </div>
                <div class="h2">{{ $tests->count() }}</div>
            </div>
            <div class="ico bg-indigo-100">
                <i class="bi bi-clipboard-check text-indigo-400"></i>
            </div>
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 mt-8 md:gap-x-6 gap-y-4">
        <!-- middle panel  -->
        <div class="col-span-2 bg-slate-50">
            <h2 class="bg-blue-50 py-1 px-2 rounded-t-lg"><i class="bi-list-task mr-2"></i>My Tasks</h2>
            <div class="py-2 px-5">
                <table class="table-auto borderless w-full">
                    <thead>
                        <tr>
                            <th class="text-left"></th>
                            <th class="w-6"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($assignments as $assignment)
                            <tr class="tr">
                                <td class="text-left text-sm">{{ $assignment->task->description }}</td>
                                <td class="text-sm">

                                    <form
                                        action="{{ route('admin.task.assignments.update', [$assignment->task, $assignment]) }}"
                                        method='post'>
                                        @csrf
                                        @method('patch')
                                        <button type="submit">
                                            @if ($assignment->status)
                                                <i class="bi-check-lg text-green-600"></i>
                                            @else
                                                <i class="bi-check text-slate-300"></i>
                                            @endif
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        {{-- right panel --}}
        <div class="bg-teal-50 rounded-lg">
            <h3 class="bg-teal-100 rounded-t-lg px-2 py-1"><i class="bi-house-gear mr-2"></i> Home Config
            </h3>
            <div class="grid gap-2 text-sm p-2">
                <a href="{{ route('admin.teachers.index') }}" class="link">Users</a>
                <a href="{{ route('admin.alumni.index') }}" class="link">Alumni</a>
                <a href="{{ route('admin.events.index') }}" class="link">Events</a>
                <a href="{{ route('admin.subjects.index') }}" class="link">Subjects</a>
                <a href="{{ route('admin.sections.index') }}" class="link">Classes</a>
                <hr>
                <a href="{{ route('admin.attendance-register.index') }}" class="link">Attendance
                    Register</a>
            </div>

        </div>

    </div>
@endsection
