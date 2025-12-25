@extends('layouts.app')
@section('page-content')
    <h1>View user</h1>
    <div class="flex items-center">
        <div class="flex-1">
            <div class="bread-crumb">
                <a href="{{ url('/') }}">Dashboard</a>
                <div>/</div>
                <a href="{{ route('users.index') }}">users</a>
                <div>/</div>
                <div>{{ $user->id }}</div>
            </div>
        </div>
    </div>


    <div class="mt-8">
        <img src="{{ asset('storage/' . $user->profile->photo) }}" alt="Student Photo" width="100" height="100"
            class="mx-auto rounded-lg">
        <h2 class="text-center mt-3">{{ $user->profile->name }} </h2>
        <div class="text-center text-slate-400 text-xs">{{ $user->designation }}</div>

    </div>

    <div class="md:w-4/5 mx-auto mt-6 bg-white md:p-8 p-4 gap-3 rounded border relative">
        <!-- page message -->
        @if ($errors->any())
            <x-message :errors='$errors'></x-message>
        @else
            <x-message></x-message>
        @endif


        {{-- action buttons --}}
        <div class="flex items-center justify-center space-x-2 absolute top-3 md:top-5 right-5">
            <div class="flex w-8 h-8 rounded-full border justify-center items-center">
                <form action="{{ route('users.destroy', $user) }}" method="post" onsubmit="return confirmDel(event)">
                    @csrf
                    @method('DELETE')
                    <button><i class="bx  bx-trash text-red-600"></i></button>
                </form>
            </div>
            <div class="flex w-8 h-8 rounded-full border justify-center items-center">
                <a href="{{ route('users.edit', $user) }}"><i class="bx  bx-pencil text-green-600"></i></a>
            </div>
            <div class="flex w-8 h-8 rounded-full border justify-center items-center">
                <a href="{{ route('users.index') }}"><i class="bi-x-lg"></i></a>
            </div>
        </div>
        <div class="grid md:grid-cols-2 gap-3 mt-8">
            <!-- display info -->
            <div>
                <label for="">Father Name</label>
                <h3>{{ $user->profile->father_name }}</h3>
            </div>
            <div>
                <label for="">CNIC</label>
                <h3>{{ $user->profile->cnic }}</h3>
            </div>
            <div>
                <label for="">Phone</label>
                <h3>{{ $user->profile->phone }}</h3>
            </div>
            <div>
                <label for="">Email</label>
                <h3>{{ $user->email }}</h3>
            </div>
            <div>
                <label for="">Address</label>
                <h3>{{ $user->profile->address }}</h3>
            </div>
            <div>
                <label for="">Qualification</label>
                <h3>{{ $user->profile->qualification }}</h3>
            </div>
            <div>
                <label for="">Address</label>
                <h3>{{ $user->profile->address }}</h3>
            </div>
            <div class="md:col-span-full">
                <div class="flex items-center">
                    <label>Roles</label><a href="{{ route('user.roles.edit', [$user, 1]) }}"><i
                            class="bx-pencil text-green-600 ml-2 pt-2"></i></a>
                </div>

                @foreach ($user->roles as $role)
                    <div class="">{{ ucfirst($role->name) }}</div>
                @endforeach
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
