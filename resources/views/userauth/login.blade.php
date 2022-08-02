@extends('auth')
@section('content_auth')
    <div class="login-box">
        <div class="login-box-body">
            <div class="login-logo">
                <a href="#">
                    <img src="{{asset('img/sitampan.jpg')}}" alt="logo.png" width="100">
                </a>
            </div>
            @if (session('success'))
                <p class="alert alert-success">{{ session('success') }}</p>
            @endif
            @if ($errors->any())
                @foreach ($errors->all() as $err)
                    <p class="alert alert-danger">{{ $err }}</p>
                @endforeach
            @endif
            <form method="POST" action="{{ route('login.action') }}" class="form-login">
                @csrf
                <div class="form-group has-feedback @error('username') has-error @enderror">
                    <input type="text" name="username" class="form-control" placeholder="Username" required
                        value="{{ old('username') }}" autofocus>
                    <span class="glyphicon glyphicon-envelope form-control-feedback text-danger">*</span>
                    @error('username')
                        <span class="help-block">{{ $message }}</span>
                    @else
                        <span class="help-block with-errors"></span>
                    @enderror
                </div>
                <div class="form-group has-feedback @error('password') has-error @enderror">
                    <input type="password" name="password" class="form-control" placeholder="Password" required value="{{ old('password') }}">
                    <span class="glyphicon glyphicon-lock form-control-feedback text-danger">*</span>
                    @error('password')
                        <span class="help-block">{{ $message }}</span>
                    @else
                        <span class="help-block with-errors"></span>
                    @enderror
                </div>
                <div class="row">
                    <div class="col-xs-8">
                        <div class="checkbox icheck">
                            <label>
                                <input type="checkbox"> Remember Me
                            </label>
                        </div>
                    </div>
                    <!-- /.col -->
                    <div class="col-xs-4">
                        <button type="submit" class="btn btn-primary">Login</button>
                    </div>
                    <!-- /.col -->
                </div>
            </form>
        </div>
    </div>

@endsection
