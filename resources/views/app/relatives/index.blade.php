@extends('layouts.app')

@section('content')

<relative-list
    url-page-view-patient="{{route('relative.view.page',[''])}}"
    id-current-user="{{auth()->user()->id}}"
    url-base-api="{{route('users.index')}}"
    url-base-api-patient="{{route('patients.index')}}"
    url-base-api-inventory-type="{{route('inventory-type.index')}}"
    url-base-api-pathology="{{route('pathology.index')}}"
    url-base-api-get-event-patient="{{route('api.getEventPatient',[''])}}"
    url-base-api-therapy="{{route('therapy.index')}}"
    url-base-api-genders="{{route('genders.index')}}"
    url-base-api-civil="{{route('civils.index')}}"
    url-base-api-country="{{route('countries.index')}}"
    url-base-api-education="{{route('educations.index')}}"
    url-base-api-occupation="{{route('occupations.index')}}"
></relative-list>
@endsection
