@extends('layouts.app')

@section('content')
    <vaccine-groups
        base-url-api="{{ route('vaccines.index') }}"
        base-url-to-view="{{ route('vaccine.view', ['']) }}"
    >
    </vaccine-groups>
@endsection
