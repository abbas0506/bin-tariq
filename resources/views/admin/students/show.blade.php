@extends('layouts.admin')
@section('page-content')
    <h1>{{ $student->name }} </h1>
    <div class="content-section relative mt-12">

        <div class="absolute top-2 right-2">
            <div class="flex items-center justify-center space-x-2">
                <div class="flex w-8 h-8 rounded-full border justify-center items-center">
                    <form action="{{ route('admin.section.students.destroy', [$section, $student]) }}" method="post"
                        onsubmit="return confirmDel(event)">
                        @csrf
                        @method('DELETE')
                        <button><i class="bx  bx-trash text-red-600"></i></button>
                    </form>
                </div>
                <div class="flex w-8 h-8 rounded-full border justify-center items-center">
                    <a href="{{ route('admin.section.students.edit', [$section, $student]) }}"><i
                            class="bx  bx-pencil text-green-600"></i></a>
                </div>
                <div class="flex w-8 h-8 rounded-full border justify-center items-center">
                    <a href="{{ route('admin.sections.show', $section) }}"><i class="bi-x-lg"></i></a>
                </div>
            </div>
        </div>

        <h2 class="p-4 border border-dashed border-slate-200">{{ $student->section->fullName() }} ({{ $student->rollno }})
        </h2>

        <!-- display info -->
        <div class="grid md:grid-cols-3 mt-8 gap-4">
            <div class="grid md:col-span-2 gap-3 order-2 md:order-1">
                <div>
                    <label for="">Admission # </label>
                    <div class="flex flex-wrap items-center gap-x-4">
                        <h2>{{ $student->admission_no }}</h2>
                        <label>submitted on {{ $student->created_at->addHours(5) }}</label>
                    </div>
                </div>
                <div>
                    <label for="">Personal Info</label>
                    <p>{{ $student->name }}</p>
                    <p class="text-slate-600 text-sm"><i class="bi-balloon"></i>{{ $student->dob }} <i
                            class="bi-card-heading ml-2"></i> {{ $student->bform }} <i class="bi-telephone ml-2"></i>
                        {{ $student->phone }}</p>
                    <p class="text-slate-600 text-sm">{{ $student->id_mark }} </p>
                    <p class="text-slate-600 text-sm">{{ $student->address }} </p>
                </div>
                <div>
                    <label for="">Father / Guardian Info</label>
                    <p>{{ $student->father_name }} </p>
                    <p class="text-slate-600 text-sm">{{ $student->father_cnic }} </p>
                    <p class="text-slate-600 text-sm">{{ $student->caste }} / {{ $student->profession }} </p>
                    <p class="text-slate-600 text-sm"><i class="bi-currency"></i>{{ $student->income }} </p>
                </div>
                <div>
                    <label for="">Group</label>
                    <p>{{ $student->group?->name }}</p>
                </div>
                <div>
                    <label for="">Academic Info</label>

                </div>
            </div>
            <div class="order-1 md:order-2">
                <div>
                    <img src="{{ asset('storage/' . $student->photo) }}" alt="Student Photo" width="100" height="100">
                </div>
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
