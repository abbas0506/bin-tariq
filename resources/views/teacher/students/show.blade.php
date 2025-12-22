@extends('layouts.teacher')
@section('page-content')
    <h1>{{ $student->name }} </h1>
    <!-- display info -->
    <div class="md:w-4/5 mx-auto bg-white md:p-8 p-4 rounded border mt-12 relative">
        <div class="absolute top-2 right-2">
            <div class="flex items-center justify-center space-x-2">
                <div class="w-6 h-6">
                    <a href="{{ route('teacher.students.edit', $student) }}"><i class="bx  bx-pencil text-green-600"></i></a>
                </div>
                <div class="w-6 h-6">
                    <a href="{{ route('teacher.students.index') }}"><i class="bx  bx-x"></i></a>
                </div>
            </div>
        </div>
        <div class="grid gap-3">
            <div class="">
                <div>
                    @if ($student->photo)
                        <img src="{{ asset('storage/' . $student->photo) }}" alt="Student Photo" width="100"
                            height="100">
                    @else
                        <img src="{{ asset('/images/default.png') }}" alt="Student Photo" width="100" height="100">
                    @endif
                </div>
            </div>
            <div>
                <label for="">Roll # </label>
                <div class="flex flex-wrap items-center gap-x-4">
                    <h2>{{ $student->rollno }}</h2>
                </div>
            </div>
            <div>
                <label for="">Name</label>
                <p>{{ $student->name }}</p>
                <p class="text-slate-500 text-xs">{{ $student->father_name }}</p>
            </div>
            <div>
                <label for=""><i class="bi-telephone"></i></label>
                <p>{{ $student->phone }}</p>
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
