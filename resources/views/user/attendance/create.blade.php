@extends('user.layouts.app')

@section('content')

<div class="container">
    <h4 class=" text-center mt-3 mb-0 text-decoration-underline"> Form Kehadiran </h4>
    <h5 class=" text-center  mb-3 "> Notulen {{ $note->title }} </h5>
    @can('manage-this-note', $note)
    <div class="row justify-content-between">
        <div class="col-4">
            <a href="{{ route('user.dashboard') }}" class="btn btn-dark d-block mb-3 btn-sm small"><i class="bi bi-house-door"></i> Beranda</a>
        </div>
        <div class="col-4 align-self-end">
            <a href="{{ route('user.share.note', ['note' => $note]) }}" class="btn btn-outline-success d-block mb-3 btn-sm small"><i class="bi bi-send"></i> Kirim</a>
        </div>
        <div class="col-4 align-self-end">
            <a href="{{ route('user.photo.create', ['note' => $note]) }}" class="btn btn-outline-primary d-block mb-3 btn-sm small"><i class="bi bi-camera-fill"></i> Foto</a>
        </div>
    </div>
    @endcan
    @livewire('user.note.list-attendance', ['note' => $note])

</div>

@endsection