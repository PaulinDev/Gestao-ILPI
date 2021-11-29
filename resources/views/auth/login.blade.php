@extends('layouts.app-auth')

@section('content')
    <app-login token_csrf="{{ @csrf_token() }}"></app-login>
@endsection
