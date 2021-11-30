@extends('layouts.app-auth')

@section('content')
    <app-login token_csrf="{{ @csrf_token() }}" url-base-api="{{env('APP_URL')}}"></app-login>
@endsection
