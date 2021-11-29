@extends('layouts.app')

@section('content')
    <edit-employee
        url-base-api="{{route('employees.index')}}"
        url-base-api-genders="{{route('genders.index')}}"
        url-base-api-user-post="{{route('user-posts.index')}}"
        url-base-api-user-permission="{{route('user-permission.index')}}"
        url-page-index="{{route('user.list.page')}}"
        id-current-employee="{{$idCurrentEmployee}}"
    ></edit-employee>
    <form method="POST" action="{{ route('logout') }}">
        @csrf

        <a href="{{ route('logout') }}" class="dropdown-item" style="padding: .65rem 1.28rem!important;"
           onclick="event.preventDefault();
                                                this.closest('form').submit();">
            <i class="mr-50" data-feather="power"></i> {{ __('Log Out') }}
        </a>
    </form>
@endsection
