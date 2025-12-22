@extends('layouts.admin')
@section('page')

<div class="custom-container">
    <h1>Users</h1>
    <div class="bread-crumb">
        <a href="{{url('admin')}}">Dashoboard</a>
        <div>/</div>
        <div>Users</div>
        <div>/</div>
        <div>All</div>
    </div>
    <!-- search -->

    <div class="overflow-x-auto p-5 md:p-24 mt-8 bg-white rounded-sm">

        <table class="table-fixed borderless w-full text-sm">
            <thead>
                <tr>
                    <th class="w-32 ">User</th>
                    <th class="w-16"><i class="bi-key"></i></th>
                </tr>
            </thead>
            <tbody>

                @foreach($users as $user)
                @php $i=0; @endphp
                <tr class="">
                    <td class="text-left py-3">{{$user->email}}</td>
                    <td>
                        <a href="{{ route('admin.users.edit', $user) }}" class="link">
                            Reset Password
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection