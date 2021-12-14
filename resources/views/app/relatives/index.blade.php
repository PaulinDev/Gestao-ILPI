@extends('layouts.app')

@section('content')

<relative-list id-current-user="{{auth::user()->id}}" url-base-api="{{route('users.index')}}" url-base-api-patient="{{route('patients.index')}}"></relative-list>
@endsection
