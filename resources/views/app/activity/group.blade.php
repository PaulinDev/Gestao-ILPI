@extends('layouts.app')

@section('content')
    <activity-group
        url-base-api="{{route('activity-group.index')}}"
        url-base-api-activity="{{route('activities.index')}}"
        route-view-activity="{{route('activity.view.page',[''])}}"
    >

    </activity-group>
@endsection
