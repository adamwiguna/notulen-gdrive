@extends('user.layouts.app')

@section('content')
{{-- <div class="d-flex align-items-center p-3 my-3 text-white bg-dark shadow-sm">
    <div class="lh-1 justify-content-center col-12">
        <h1 class="h6 mb-0 text-white lh-1 mb-1">Halo, {{ auth()->user()->name }}</h1>
        <small>Ayo buat notulen dengan menekan tombol dibawah</small> <br>
        
        <a class="btn btn-primary d-block mt-3 py-3" href="{{ route('user.note.create') }}" >
            <i class="bi bi-clipboard-plus"></i>
            Notulen
        </a>
    </div>
</div>
@if (session()->has('message'))
<div class="alert alert-success alert-dismissible fade show rounded-0" role="alert">
    <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>
    {{ session('message') }} 
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif --}}


@livewire('user.note.index-note')

@endsection