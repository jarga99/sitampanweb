@extends('app')
@section('content')


@guest
    <a href="{{route('login')}}" class="btn btn-primary">Login</a>
    <a href="{{route('register')}}" class="btn btn-info">Register</a>
@endguest
@endsection
