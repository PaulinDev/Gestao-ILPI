@extends('layouts.app')

@section('content')
    <new-patient
        url-base-api="{{route('employees.index')}}"
        url-base-api-genders="{{route('genders.index')}}"
        url-base-api-user-post="{{route('user-posts.index')}}"
        url-base-api-civil="{{route('civils.index')}}"
        url-base-api-country="{{route('countries.index')}}"
        url-base-api-education="{{route('educations.index')}}"
        url-base-api-user-permission="{{route('user-permission.index')}}"
        url-base-api-occupation="{{route('occupations.index')}}"
        url-page-index="{{route('user.list.page')}}"
    ></new-patient>
    <form method="POST" action="{{ route('logout') }}">
        @csrf

        <a href="{{ route('logout') }}" class="dropdown-item" style="padding: .65rem 1.28rem!important;"
           onclick="event.preventDefault();
                                                this.closest('form').submit();">
            <i class="mr-50" data-feather="power"></i> {{ __('Log Out') }}
        </a>
    </form>
@endsection
