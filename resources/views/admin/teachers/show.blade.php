@extends('layouts.admin')
@section('page-content')
    <h1>View Teacher</h1>
    <div class="flex items-center">
        <div class="flex-1">
            <div class="bread-crumb">
                <a href="{{ url('/') }}">Dashboard</a>
                <div>/</div>
                <a href="{{ route('admin.teachers.index') }}">Teachers</a>
                <div>/</div>
                <div>{{ $teacher->id }}</div>
            </div>
        </div>
    </div>

    <!-- page message -->
    @if ($errors->any())
        <x-message :errors='$errors'></x-message>
    @else
        <x-message></x-message>
    @endif

    <div class="mt-8">
        <img src="{{ asset('storage/' . $teacher->photo) }}" alt="Student Photo" width="100" height="100"
            class="mx-auto rounded-lg">
        <h2 class="text-center mt-3">{{ $teacher->name }} </h2>
        <div class="text-center text-slate-400 text-xs">{{ $teacher->designation }}</div>
        {{-- action buttons --}}
        <div class="flex items-center justify-center space-x-2 mt-4">
            <div class="flex w-8 h-8 rounded-full border justify-center items-center">
                <form action="{{ route('admin.teachers.destroy', $teacher) }}" method="post"
                    onsubmit="return confirmDel(event)">
                    @csrf
                    @method('DELETE')
                    <button><i class="bx  bx-trash text-red-600"></i></button>
                </form>
            </div>
            <div class="flex w-8 h-8 rounded-full border justify-center items-center">
                <a href="{{ route('admin.teachers.edit', $teacher) }}"><i class="bx  bx-pencil text-green-600"></i></a>
            </div>
            <div class="flex w-8 h-8 rounded-full border justify-center items-center">
                <a href="{{ route('admin.teachers.index') }}"><i class="bi-x-lg"></i></a>
            </div>
        </div>
    </div>
    <div class="grid grid-cols-2 md:grid-cols-6 md:w-4/5 mx-auto mt-6 bg-white md:p-8 p-4 gap-3 rounded border relative">
        <h2 class="col-span-full mb-3 text-decoration underline">Roles</h2>
        @foreach ($teacher->user->roles as $role)
            <div class="text-center">{{ ucfirst($role->name) }}</div>
        @endforeach
    </div>
    <div class="grid md:grid-cols-2 md:w-4/5 mx-auto mt-6 bg-white md:p-8 p-4 gap-3 rounded border relative">
        <!-- display info -->
        <h2 class="col-span-full mb-3 text-decoration underline">Basic Info</h2>
        <div>
            <label for="">Personal # </label>
            <h3>{{ $teacher->personal_no }}</h3>
        </div>
        <div>
            <label for="">Father Name</label>
            <h3>{{ $teacher->father_name }}</h3>
        </div>
        <div>
            <label for="">DOB</label>
            <h3>{{ $teacher->dob->format('d/m/Y') }}</h3>
        </div>
        <div>
            <label for="">CNIC</label>
            <h3>{{ $teacher->cnic }}</h3>
        </div>
        <div>
            <label for="">Phone</label>
            <h3>{{ $teacher->phone }}</h3>
        </div>
        <div>
            <label for="">Email</label>
            <h3>{{ $teacher->user?->email }}</h3>
        </div>
        <div>
            <label for="">Address</label>
            <h3>{{ $teacher->address }}</h3>
        </div>
        <div>
            <label for="">Qualification</label>
            <h3>{{ $teacher->qualification }}</h3>
        </div>
        <div>
            <label for="">Address</label>
            <h3>{{ $teacher->address }}</h3>
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
