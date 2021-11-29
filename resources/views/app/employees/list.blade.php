@extends('layouts.app')

@section('content')
    <list-employee
        url-base-api="{{route('employees.index')}}"
        url-base-api-delete="{{route('employees.destroy', [''])}}"
        url-page-new="{{route('user.create.page')}}"
        url-page-edit="{{route('user.edit.page', [''])}}"
    ></list-employee>
@endsection
