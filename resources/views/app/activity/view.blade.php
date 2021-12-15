@extends('layouts.app')

@section('content')
<activity id-current-activity="{{$idCurrentActivity}}"
base-url-api="{{route('activity-patient.index')}}"
base-url-api-patient="{{route('patients.index')}}"></activity>
@endsection
