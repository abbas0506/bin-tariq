@extends('layouts.admin')
@section('page-content')
    <h2>New Task</h2>
    <div class="bread-crumb">
        <a href="/">Home</a>
        <div>/</div>
        <a href="{{ route('admin.tasks.index') }}">Tasks</a>
        <div>/</div>
        <div>New</div>
    </div>

    <div class="md:w-3/4 mx-auto mt-6 bg-white md:p-8 rounded">
        <!-- page message -->
        @if ($errors->any())
            <x-message :errors='$errors'></x-message>
        @else
            <x-message></x-message>
        @endif
        <form action="{{ route('admin.tasks.store') }}" method='post' class="w-full grid gap-6"
            onsubmit="return validate(event)">
            @csrf
            <div class="grid md:grid-cols-2 gap-3">
                <div class="md:col-span-2">
                    <label>Task Desc.</label>
                    <input type="text" name='description' class="custom-input"
                        placeholder="Attendance Register Completion" value="" required>
                </div>
                <div>
                    <label>Due Date</label>
                    <input type="date" name='due_date' class="custom-input text-center" placeholder="Due date" required>

                </div>
            </div>
            <div>
                <input type="checkbox" name="grouped" id="grouped">
                <label for="grouped">Grouped</label>
            </div>
            <div class="p-2 md:p-5 border rounded-lg hidden" id="grouped_task">
                <h2 class="text-sm mb-4">Users who will complete this task</h2>
                @foreach ($teachers as $teacher)
                    <div class="flex items-center odd:bg-slate-100 checkable-row px-4">
                        <!-- <div class="flex flex-1 items-center justify-between space-x-2 pr-3"> -->
                        <label for='teacher{{ $teacher->id }}'
                            class="flex-1 text-sm text-slate-800 hover:cursor-pointer py-2">{{ $teacher->name }}
                        </label>
                        <!-- </div> -->
                        <div class="text-base">
                            <input type="checkbox" id='teacher{{ $teacher->id }}' name='teacher_ids_array[]'
                                class="custom-input w-4 h-4 rounded hidden" value="{{ $teacher->id }}">
                            <i class="bx bx-check"></i>
                        </div>
                    </div>
                @endforeach
            </div>
            <button type="submmit" class="btn-teal rounded p-2 w-32 mt-3">Create Now</button>
        </form>

    </div>
    </div>
@endsection
@section('script')
    <script type="module">
        $('.checkable-row input').change(function() {
            if ($(this).prop('checked'))
                $(this).parents('.checkable-row').addClass('active')
            else
                $(this).parents('.checkable-row').removeClass('active')
        })

        $('#check_all').change(function() {
            if ($(this).prop('checked')) {
                $('.checkable-row input').each(function() {
                    $(this).prop('checked', true)
                    $(this).parents('.checkable-row').addClass('active')
                })
            } else {
                $('.checkable-row input').each(function() {
                    $(this).prop('checked', false)
                    $(this).parents('.checkable-row').removeClass('active')
                })
            }
        })
        $('#grouped').on('change', function() {
            $('#grouped_task').toggle(this.checked);
        });
    </script>
@endsection
