@extends('operator.layouts.app')

@section('content')


<form action="{{ route('user.password') }}" method="POST" class="container">
    @if (session()->has('message'))
    <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
        <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>
        {{ session('message') }} 
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
    <h4 class=" text-center mt-3 mb-3 text-decoration-underline"> Form Ganti Password</h4>
    @csrf
    <div class="form-floating mb-3">
        <input name="password"  type="text" class="form-control  @error('password') is-invalid @enderror" id="floatingtitle" placeholder="Password Baru">
        <label for="floatingtitle" class=" text-small small">Password Baru</label>
        @error('password')
        <span class="invalid-feedback">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
    <div class="form-floating">
        <button type="submit" class="btn mt-3 btn-primary"><i class="bi bi-box-arrow-down"></i> Simpan Data</button>
    </div>
</form>

@endsection