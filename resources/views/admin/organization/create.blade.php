@extends('admin.layouts.app')

@section('content')

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Form SKPD</h1>  
</div>


<form action="{{ route('admin.organization.store') }}" method="POST">
    @csrf
    <input name="slug" type="hidden" value="{{ Str::random(50) }}">
    <div class="form-floating mb-3">
        <input name="name" value="{{ old('name') }}" type="text" class="form-control  @error('name') is-invalid @enderror" id="floatingName" placeholder="name">
        <label for="floatingName">Nama SKPD</label>
        @error('name')
        <span class="invalid-feedback">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
    <div class="form-floating mb-3">
        <input name="alias" value="{{ old('alias') }}" type="text" class="form-control @error('alias') is-invalid @enderror" id="floatingAlias" placeholder="Alias">
        <label for="floatingAlias">Singkatan Nama SKPD/ Alias </label>
        @error('alias')
        <span class="invalid-feedback">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
    <div class="form-floating mb-3">
        <input name="username" value="{{ old('username') }}" type="text" class="form-control @error('username') is-invalid @enderror" id="floatingUsername" placeholder="Username">
        <label for="floatingUsername">Username Operator SKPD</label>
        @error('username')
        <span class="invalid-feedback">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
    <div class="form-floating">
        <input name="password" type="password" class="form-control @error('password') is-invalid @enderror" id="floatingPassword " placeholder="Password">
        <label for="floatingPassword">Password</label>
        @error('password')
        <span class="invalid-feedback">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
    <div class="form-floating">
        <input name="password_confirmation" type="password" class="form-control mt-3 @error('password') is-invalid @enderror" id="floatingConfirmPassword " placeholder="Password">
        <label for="floatingConfirmPassword">Konfimasi Password</label>
        @error('password')
        <span class="invalid-feedback">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
    <div class="form-floating">
        <button type="submit" class="btn mt-5 btn-primary"><i class="bi bi-box-arrow-down"></i> Simpan Data</button>
    </div>
</form>
    
@endsection