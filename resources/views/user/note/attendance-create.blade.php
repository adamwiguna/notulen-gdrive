@extends('user.layouts.app')

@section('content')

<div class="container">

    <div class="row mt-5">
        <div class="col-3 text-center fw-bold text-dark ">Notulen</div>
        <div class="col-3 text-center fw-bold text-dark">Foto</div>
        <div class="col-3 text-center fw-bold text-primary">Kehadiran</div>
        <div class="col-3 text-center">Kirim</div>
    </div>
    <div class="progress mt-2 mb-5">
        <div class="progress-bar bg-dark progress-bar-striped progress-bar-animated" role="progressbar" style="width: 50%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 25%" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100">(3/4)</div>
    </div>
<div>
    <h4 class=" text-center mt-3 mb-3 text-decoration-underline">Langkah 3 : Form Kehadiran</h4>

    
    @livewire('user.note.list-attendance', ['note' => $note])
  

    
    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
        <a href="{{ route('user.store-step-2.note', ['note' => $note]) }}" class="btn mt-3 btn-secondary"> <i class="bi bi-arrow-bar-left"></i> Kembali</a>
        <a href="{{ route('user.create-step-4.note', ['note' => $note]) }}" class="btn mt-3 btn-primary">Simpan (3/4) - Langkah Selanjutnya <i class="bi bi-arrow-bar-right"></i></a>
    </div>
</div>
</div>
@endsection