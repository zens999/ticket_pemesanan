@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Edit User') }}</div>

                <div class="card-body">
                    <form action="{{ route('user.update', $user->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="name">Nama User</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}" required>
                        </div>
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" class="form-control" id="username" name="username" value="{{ $user->username }}" required>
                        </div>
                        <div class="form-group">
                            <label for="level">Level User</label>
                            <select class="form-control" id="level" name="level" required>
                                <option value="Admin" {{ $user->level == 'Admin' ? 'selected' : '' }}>Admin</option>
                                <option value="Petugas" {{ $user->level == 'Petugas' ? 'selected' : '' }}>Petugas</option>
                                <option value="Penumpang" {{ $user->level == 'Penumpang' ? 'selected' : '' }}>Penumpang</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="password">Password Baru (opsional)</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Password Baru">
                        </div>
                        <div class="form-group">
                            <label for="password_confirmation">Konfirmasi Password Baru</label>
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Konfirmasi Password Baru">
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
