@extends('layouts.app')

@section('content')
    <user-profile
        url-base-api="{{route('users.index')}}"
        url-base-api-genders="{{route('genders.index')}}"
        url-base-api-employee="{{route('employees.index')}}"
        url-base-api-user-post="{{route('user-posts.index')}}"
        url-base-api-user-permission="{{route('user-permission.index')}}"
        url-page-index="{{route('user.list.page')}}"
        id-current-user="{{$idCurrentUser}}"
    ></user-profile>
@endsection
