@extends('layouts.app')

@section('content')

<div class="row">
    <div class="col-md-4 border-container-lg">
        <patient-info
            :relative="true"
            id-current-patient="{{$idCurrentPatient}}"
            url-base-api="{{route('patients.index')}}"
            url-base-api-genders="{{route('genders.index')}}"
            url-base-api-civil="{{route('civils.index')}}"
            url-base-api-country="{{route('countries.index')}}"
            url-base-api-education="{{route('educations.index')}}"
            url-base-api-occupation="{{route('occupations.index')}}"
            url-base-api-photo-patient="{{route('api.updatePhotoPatient',[''])}}"></patient-info>
    </div>
    <div class="col-md-8 mx-auto video text-center">
        <video class="w-100" controls autoplay playsinline></video>
    </div>
</div>

@endsection

@section('scripts')

<script src="{{url('js/record.js')}}"></script>
<script>
    var video = document.querySelector('video');

    function captureCamera(callback) {
        navigator.mediaDevices.getUserMedia({
            audio: true,
            video: true
        }).then(function(camera) {
            callback(camera);
        }).catch(function(error) {
            console.error(error);
        });
    }

    function stopRecordingCallback() {
        video.src = video.srcObject = null;
        video.muted = false;
        video.volume = 1;
        video.src = URL.createObjectURL(recorder.getBlob());
        recorder.camera.stop();
        recorder.destroy();
        recorder = null;
    }
    var recorder; // globally accessible
    captureCamera(function(camera) {
        video.muted = true;
        video.volume = 0;
        video.srcObject = camera;
        recorder = RecordRTC(camera, {
            type: 'video'
        });
        recorder.startRecording();
        // release camera on stopRecording
        recorder.camera = camera;
        document.getElementById('btn-stop-recording').disabled = false;
    });
    document.getElementById('btn-stop-recording').onclick = function() {
        this.disabled = true;
        recorder.stopRecording(stopRecordingCallback);
    };
</script>

<script src="https://www.webrtc-experiment.com/common.js"></script>
<script src="{{url('js/scripts/pages/app-user-view.js')}}"></script>
@endsection
