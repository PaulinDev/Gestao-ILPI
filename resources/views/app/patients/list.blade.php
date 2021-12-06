@extends('layouts.app')

@section('content')
    <list-patient ref="listPatient"
        url-base-api="{{route('patients.index')}}"
        url-base-api-delete="{{route('patients.destroy', [''])}}"
        url-page-view="{{route('patient.view.page', [''])}}"
        url-base-api-genders="{{route('genders.index')}}"
        url-base-api-civil="{{route('civils.index')}}"
        url-base-api-country="{{route('countries.index')}}"
        url-base-api-education="{{route('educations.index')}}"
        url-base-api-occupation="{{route('occupations.index')}}"
    ></list-patient>
@endsection
