@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">User List</h2>

    @if(session('success'))
        <div class="alert alert-success" id="success-alert">{{ session('success') }}</div>
    @endif

    @if(auth()->user()->role == 'admin')
        <a href="{{ route('users.create') }}" class="btn btn-primary mb-3">Create User</a>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Name</th><th>Email</th><th>Role</th>
                @if(auth()->user()->role == 'admin')
                <th>Actions</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->role }}</td>
                @if(auth()->user()->role == 'admin')
                <td>
                    <a href="{{ route('users.edit', $user) }}" class="btn btn-sm btn-warning">Edit</a>
                    <form action="{{ route('users.destroy', $user) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                    </form>
                </td>
                @endif
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
