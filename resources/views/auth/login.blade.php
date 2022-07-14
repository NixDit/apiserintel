@extends('auth.index')
@section('content')
    <login-form route_register="{{ route('register') }}" action_login="{{ route('login') }}" session_errors="{{ (count($errors) > 0) ? json_encode($errors->all()) : null }}"></login-form>
@endsection