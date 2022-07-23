@extends('app')
@section('content')
    <div class="row">
        <div class="col-md-6">
            @if ($errors->any())
                @foreach ($errors->all() as $err)
                    <p class="alert alert-danger">{{ $err }}</p>
                @endforeach
            @endif
            <form method="POST" action="{{ route('register.action') }}">
                @csrf
                <div class="mb-3">
                    <label>Nama <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="nama" value="{{ old('nama') }}">
                </div>
                <div class="mb-3">
                    <label>Username <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="username" value="{{ old('username') }}">
                </div>
                <div class="mb-3">
                    <label>Password <span class="text-danger">*</span></label>
                    <input type="password" class="form-control" name="password" value="{{ old('password') }}">
                </div>
                <div class="mb-3">
                    <label>Konfirmasi Password <span class="text-danger">*</span></label>
                    <input type="password" class="form-control" name="konfirmasi_password"
                        value="{{ old('konfirmasi_password') }}">
                </div>
                <div class="mb-3">
                    <button class="btn btn-primary">Register</button>
                    <a href="{{ route('home') }}" class="btn btn-danger">Kembali</a>
                </div>
            </form>
        </div>
    </div>
@endsection
