@extends('layouts.app')

@section('content')
<appointments-list
    url-base-api-patients="{{route('patients.index')}}"
    url-base-api-appointments="{{route('appointments.index')}}"
>

</appointments-list>
@endsection
