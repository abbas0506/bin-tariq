@extends('layouts.app')
@section('page-content')
    <h2>View Student</h2>
    <div class="bread-crumb">
        <a href="{{ url('/') }}">Dashoboard</a>
        <div>/</div>
        <a href="{{ route('sections.index') }}">Sections</a>
        <div>/</div>
        <a href="{{ route('sections.show', $section) }}">{{ $section->name }}</a>
        <div>/</div>
        <div>View Student</div>
    </div>
    <!-- display info -->
    <div class="flex justify-center items-center">
        @if ($student->photo)
            <img src="{{ asset('storage/' . $student->photo) }}" alt="Student Photo" width="100" height="100">
        @else
            <img src="{{ asset('/images/default.png') }}" alt="Student Photo" width="100" height="100">
        @endif
    </div>
    <h2 class="my-3 text-center">{{ $student->name }}</h2>
    <div class="md:w-4/5 mx-auto grid gap-3 md:p-8 p-5 border rounded relative">
        <div class="absolute top-2 right-2">
            <div class="flex items-center justify-center space-x-2">
                @can('delete', $student)
                    <div class="flex w-8 h-8 rounded-full border justify-center items-center">
                        <form action="{{ route('section.students.destroy', [$section, $student]) }}" method="post"
                            onsubmit="return confirmDel(event)">
                            @csrf
                            @method('DELETE')
                            <button><i class="bx-trash text-red-600"></i></button>
                        </form>
                    </div>
                @endcan
                @can('update', $student)
                    <div class="flex w-8 h-8 rounded-full border justify-center items-center">
                        <a href="{{ route('section.students.edit', [$section, $student]) }}">
                            <i class="bx-pencil text-green-600"></i></a>
                    </div>
                @endcan

                <div class="">
                    <a href="{{ route('sections.show', $section) }}"><i class="bi-x"></i></a>
                </div>
            </div>
        </div>

        <h2>{{ $student->section->name }} ({{ $student->rollno }})</h2>
        <div>
            <label for="">Name</label>
            <p>{{ $student->name }}</p>
            <p class="text-slate-500 text-xs">{{ $student->father_name }}</p>
        </div>
        <div>
            <label for=""><i class="bi-telephone"></i></label>
            <p>{{ $student->phone }}</p>
            <p class="text-slate-500 text-xs">{{ $student->address }}</p>
        </div>
        <div>
            <label for="">Roll # </label>
            <div class="flex flex-wrap items-center gap-x-4">
                <h2>{{ $student->rollno }}</h2>
            </div>
        </div>
        <div>
            <label for="">Fee </label>
            <div class="flex flex-wrap items-center gap-x-4">
                <h2>{{ $student->fee }}</h2>
            </div>
        </div>

    </div>
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
    </script>
@endsection
