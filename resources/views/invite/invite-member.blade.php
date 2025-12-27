@extends('layouts.app')

@section('title', 'Invite Member')

@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h2 class="text-center mb-4">Invite Member</h2>
                <form method="POST" action="{{ route('invite.member.send') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Member Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Member Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Role</label>
                        <select class="form-select" name="role_id" id="role" required>
                            @foreach ($roles as $role)
                                <option value="{{ $role->id }}">{{ $role->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Send Invite</button>
                </form>
            </div>
        </div>
    </div>
@endsection