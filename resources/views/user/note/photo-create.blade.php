@extends('user.layouts.app')

@section('content')

<div class="container">
<div class="row mt-5">
    <div class="col-3 text-center fw-bold text-dark ">Notulen</div>
    <div class="col-3 text-center fw-bold text-primary">Foto</div>
    <div class="col-3 text-center">Kehadiran</div>
    <div class="col-3 text-center">Kirim</div>
</div>
<div class="progress mt-2 mb-5">
    <div class="progress-bar bg-dark progress-bar-striped progress-bar-animated" role="progressbar" style="width: 25%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
    <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 25%" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100">(2/4)</div>
</div>

    <h4 class=" text-center mt-3 mb-3 text-decoration-underline">Langkah 2 : Form Foto</h4>
   
    <form action="{{ route('user.store-step-2.note', ['note' => $note]) }}" method="POST"  enctype="multipart/form-data">
    {{-- <form action="{{ route('user.photo.store', ['note' => $note]) }}" method="POST"  enctype="multipart/form-data"> --}}
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


    <div class="row row-cols-1 row-cols-sm-1 row-cols-md-2 g-3 overflow-auto" style="aspect-ratio: 4/3;">
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
                            <form action="{{ route('user.destroy-step-2.note', ['note' => $note, 'photo' => $photo]) }}" method="POST">
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
    <div class="d-grid gap-2 d-md-flex justify-content-md-end mb-5">
        <a href="{{ route('user.store-step-1.note', ['note' => $note]) }}" class="btn mt-3 btn-secondary"> <i class="bi bi-arrow-bar-left"></i> Kembali</a>
        <a href="{{ route('user.create-step-3.note', ['note' => $note]) }}" class="btn mt-3 btn-primary">Simpan (2/4) - Langkah Selanjutnya <i class="bi bi-arrow-bar-right"></i></a>
    </div>
    
</div>

@endsection