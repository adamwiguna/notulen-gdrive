@extends('user.layouts.app')

@section('content')


<div class="container">
    <h4 class=" text-center mt-3 mb-0 text-decoration-underline"> Form Foto </h4>
    <h5 class=" text-center  mb-3 "> Notulen {{ $note->title }} </h5>

    <div class="row justify-content-between">
        <div class="col-4">
            <a href="{{ route('user.dashboard') }}" class="btn btn-dark d-block mb-3 btn-sm small">
                <i class="bi bi-house-door"></i> Beranda
            </a>
        </div>
        <div class="col-4 align-self-end">
            <a href="{{ route('user.share.note', ['note' => $note]) }}" class="btn btn-outline-success d-block mb-3 btn-sm small"><i class="bi bi-send"></i> Kirim</a>
        </div>
        <div class="col-4 align-self-end">
            <a href="{{ route('user.attendance.create', ['note' => $note]) }}" class="btn btn-outline-primary d-block mb-3 btn-sm small">
               <i class="bi bi-person-plus"></i>Kehadiran 
            </a>
        </div>
    </div>

    <form action="{{ route('user.photo.store', ['note' => $note]) }}" method="POST"  enctype="multipart/form-data">
        @csrf
        <small class=" text-warning">Maksimal 2mb</small> <br>
        <small class=" text-warning">Gunakan Foto Mendatar / Landscape</small>
        <label for="formFileSm" class="form-label">Pilih Foto</label>
        <div class="input-group mb-3">
            <input name="photo" type="file" accept="image/*"  class="form-control form-control-sm @error('photo') is-invalid @enderror" >
            <button type="submit" class="btn btn-success btn-sm"><i class="bi bi-box-arrow-down"></i> Simpan Foto</button>
            @error('photo')
            <span class="invalid-feedback">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
        <div class="form-floating">
        </div>
    </form>

   


    @if (session()->has('message'))
    <div class="alert alert-success alert-dismissible fade show rounded-0" role="alert">
        {{ session('message') }} 
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif


    <div class="row row-cols-1 row-cols-sm-1 row-cols-md-2 g-3">
    @foreach ($note->photos as $photo)
        <div class="col carousel slide">
            <div class="shadow-sm carousel-inner">
                <div class="carousel-item active " style="aspect-ratio: 4/3; overflow:hidden;  background: rgb(41, 41, 41); ">
                    <img src="{{ $photo->url }}" class="d-block w-100" alt="" style="height:100%; object-fit: contain ; object-position: center;;">
                    {{-- <img src="{{ $photo->url }}" class="d-block w-100" alt="" style="max-height: 70vmin; width: 100%; object-fit: cover; object-position: center;"> --}}
                </div>
                <div class="card-body p-0">
                    <div class="d-flex  align-items-end justify-content-end p-0">
                        <div class="input-group  justify-content-end p-0">
                            <button data-bs-toggle="modal" data-bs-target="#exampleModal{{ $photo->id }}" type="button" class="btn btn-sm btn-info text-white rounded-0"><i class="bi bi-eye"></i></button>
                            <form action="{{ route('user.photo.destroy', ['note' => $note, 'photo' => $photo]) }}" method="POST">
                                @method('DELETE')
                                @csrf
                                <button type="submit" class="btn btn-sm btn-danger rounded-0"><i class="bi bi-trash"></i></button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
           <!-- Modal -->
           <div class="modal fade" id="exampleModal{{ $photo->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-fullscreen" >
            <div class="modal-content bg-info bg-dark" data-bs-dismiss="modal" >
                <div class="modal-body" >
                    <button type="button" class="btn btn-danger justify-content-end align-items-end" data-bs-dismiss="modal" aria-label="Close"><i class="bi bi-x-lg"></i> Tutup</button>
                    <img src="{{ $photo->url }}" class="d-block w-100" alt="" style="margin: auto;  height:100%; width: 100%; object-fit: contain ; object-position: center;">
                </div>
            </div>
            </div>
        </div>
    @endforeach   
    </div>
    
</div>

@endsection