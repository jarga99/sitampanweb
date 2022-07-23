@extends('app')
@section('content')
@auth
<p>Welcome <b>{{Auth::user()->nama}}</b> </p>
    <a href="{{route('password')}}" class="btn btn-primary">Ganti Password</a>
    <a href="{{route('logout')}}" class="btn btn-danger">Logout</a>
@endauth

@guest
    <a href="{{route('login')}}" class="btn btn-primary">Login</a>
    <a href="{{route('register')}}" class="btn btn-info">Register</a>
@endguest
@endsection
