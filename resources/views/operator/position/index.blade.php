@extends('operator.layouts.app')

@section('content')

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Kelola Jabatan di {{ auth()->user()->organization->name }}</h1>  
 </div>

{{-- @livewire('operator.position.index-position') --}}
@livewire('admin.organization.list-position', ['organization' => auth()->user()->organization])
    
@endsection