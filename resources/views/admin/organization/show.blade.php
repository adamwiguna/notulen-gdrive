@extends('admin.layouts.app')

@section('content')

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">{{ $organization->name }}</h1>  <br>
</div>



<div class="accordion" id="accordionExample">
    {{-- <div class="accordion-item">
      <h2 class="accordion-header" id="headingOne">
        <button class="accordion-button text-decoration-none" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
          <h5> Daftar Bidang / Bagian pada {{ $organization->name }} </h5>
        </button>
      </h2>
      <div id="collapseOne" class="accordion-collapse show " aria-labelledby="headingOne" >
        <div class="accordion-body">
            @livewire('admin.organization.list-division', ['organization' => $organization])
        </div>
      </div>
    </div> --}}
    <div class="accordion-item">
      <h2 class="accordion-header" id="headingTwo">
        <button class="accordion-button text-decoration-none" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
            <h5> Daftar Jabatan pada {{ $organization->name }} </h5>
        </button>
      </h2>
      <div id="collapseTwo" class="accordion-collapse show" aria-labelledby="headingTwo" >
        <div class="accordion-body">
            @livewire('admin.organization.list-position', ['organization' => $organization])
        </div>
      </div>
    </div>
    <div class="accordion-item">
      <h2 class="accordion-header" id="headingThree">
        <button class="accordion-button text-decoration-none" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
            <h5> User pada {{ $organization->name }} </h5>
        </button>
      </h2>
      <div id="collapseThree" class="accordion-collapse show" aria-labelledby="headingThree" >
        <div class="accordion-body">
            @livewire('admin.organization.list-user', ['organization' => $organization])
        </div>
      </div>
    </div>
  </div>
  

{{-- @livewire('admin.organization.list-division', ['organization' => $organization]) --}}
    
@endsection