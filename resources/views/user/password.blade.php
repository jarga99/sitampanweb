@extends('app')
@section('content')

    <div class="row">
        <div class="col-md-6">
            @if (session('success'))
                <p class="alert alert-success">{{ session('success') }}</p>
            @endif
            @if ($errors->any())
                @foreach ($errors->all() as $err)
                    <p class="alert alert-danger">{{ $err }}</p>
                @endforeach
            @endif
            <form method="POST" action="{{ route('password.action') }}">
                @csrf
                <div class="mb-3">
                    <label>Password Lama<span class="text-danger">*</span></label>
                    <input type="password" class="form-control" name="password_lama">
                </div>
                <div class="mb-3">
                    <label>Password Baru <span class="text-danger">*</span></label>
                    <input type="password" class="form-control" name="password_baru">
                </div>
                <div class="mb-3">
                    <label>Konfirmasi Password Baru <span class="text-danger">*</span></label>
                    <input type="password" class="form-control" name="konfirmasi_password_baru">
                </div>
                <div class="mb-3">
                    <button class="btn btn-warning">Ganti</button>
                    <a href="{{ route('home') }}" class="btn btn-danger">Kembali</a>
                </div>
            </form>
        </div>
    </div>
@endsection
