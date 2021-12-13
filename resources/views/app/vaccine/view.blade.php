@extends('layouts.app')

@section('content')
<vaccine-view
    id-current-vaccine="{{$idVaccine}}"
    base-url-api="{{ route('vaccines.index') }}"
    base-url-api-brand="{{ route('vaccine-brand.index') }}"
    base-url-api-vaccine-record="{{ route('vaccine-record.index') }}"
    base-url-api-vaccine-brand="{{route('api.vaccineBrand', [''])}}"
    base-url-to-details="{{route('vaccine.details', [''])}}"
    base-url-api-vaccine-patient="{{route('api.vaccinePatient')}}">
</vaccine-view>
@endsection
