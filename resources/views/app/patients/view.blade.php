@extends('layouts.app')

@section('content')
    <view-patient
        url-base-api="{{route('patients.index')}}"
        url-base-api-genders="{{route('genders.index')}}"
        url-base-api-civil="{{route('civils.index')}}"
        url-base-api-country="{{route('countries.index')}}"
        url-base-api-education="{{route('educations.index')}}"
        url-base-api-occupation="{{route('occupations.index')}}"
        url-page-index="{{route('user.list.page')}}"
    ></view-patient>
    <div class="row">
        <patient-info
            class="col-md-4"
            id-current-patient="{{$idCurrentPatient}}"
            url-base-api="{{route('patients.index')}}"
            url-base-api-genders="{{route('genders.index')}}"
            url-base-api-civil="{{route('civils.index')}}"
            url-base-api-country="{{route('countries.index')}}"
            url-base-api-education="{{route('educations.index')}}"
            url-base-api-occupation="{{route('occupations.index')}}"
            url-base-api-photo-patient="{{route('api.updatePhotoPatient',[''])}}"
        ></patient-info>
        <patient-additional-info
            class="col-md-8"
            id-current-patient="{{$idCurrentPatient}}"
            url-base-api="{{route('patients.index')}}"
            url-base-api-health="{{route('user-health.index')}}"
            url-base-api-cards="{{route('patient-cards.index')}}"
            url-base-api-address="{{route('patient-address.index')}}"
            url-base-api-inventory-type="{{route('inventory-type.index')}}"
            url-base-api-patient-inventory="{{route('patient-inventory.index')}}"
            url-base-api-inventory-by-patient="{{route('api.inventoryByPatient',[''])}}"
            url-base-api-pathology="{{route('pathology.index')}}"
            url-base-api-pathology-record="{{route('pathology-record.index')}}"
            url-base-api-therapy="{{route('therapy.index')}}"
            url-base-api-guardian="{{route('guardian.index')}}"
            url-base-api-guardian-type="{{route('guardian-type.index')}}"
            url-base-api-users="{{route('users.index')}}"
            url-base-api-genders="{{route('genders.index')}}"
        ></patient-additional-info>

    </div>
    <form method="POST" action="{{ route('logout') }}">
        @csrf

        <a href="{{ route('logout') }}" class="dropdown-item" style="padding: .65rem 1.28rem!important;"
           onclick="event.preventDefault();
                                                this.closest('form').submit();">
            <i class="mr-50" data-feather="power"></i> {{ __('Log Out') }}
        </a>
    </form>
@endsection
