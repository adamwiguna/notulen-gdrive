@extends('user.layouts.app')

@section('content')

<div class="container">

  <div class="row mt-5">
    <div class="col-3 text-center fw-bold text-dark ">Notulen</div>
    <div class="col-3 text-center fw-bold text-dark">Foto</div>
    <div class="col-3 text-center fw-bold text-dark">Kehadiran</div>
    <div class="col-3 text-center fw-bold text-primary">Kirim</div>
</div>
<div class="progress mt-2 mb-5">
    <div class="progress-bar bg-dark progress-bar-striped progress-bar-animated" role="progressbar" style="width: 75%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
    <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 25%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">(4/4)</div>
</div>
    <h4 class=" text-center mt-3 mb-3 text-decoration-underline">Langkah 4 : Form Kirim</h4>
    
    @livewire('user.note.share', ['note' => $note])


    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
        <a href="{{ route('user.store-step-3.note', ['note' => $note]) }}" class="btn mt-3 btn-secondary"> <i class="bi bi-arrow-bar-left"></i> Kembali</a>
        <a class="btn mt-3 btn-primary"  data-bs-toggle="modal" data-bs-target="#staticBackdrop">Simpan (4/4) - Selesai  <i class="bi bi-arrow-bar-right"></i></i></a>
    </div>

    <!-- Button trigger modal -->

  
  <!-- Modal -->
  <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          
        </div>
        
        <div class="modal-body">
          <div class="row">
             <div class="col-3 text-center fw-bold text-dark ">Notulen</div>
             <div class="col-3 text-center fw-bold text-dark">Foto</div>
             <div class="col-3 text-center fw-bold text-dark">Kehadiran</div>
             <div class="col-3 text-center fw-bold text-dark">Kirim</div>
         </div>
         <div class="progress mt-2 mb-4">
             <div class="progress-bar bg-dark progress-bar-striped progress-bar-animated" role="progressbar" style="width: 100%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
         </div>

          <h5 class="modal-title text-center text-decoration-underline" id="staticBackdropLabel">Selamat</h5>
         

           Anda telah berhasil membuat Notulen dengan judul <br>
           <br>
           <strong>
               {{ $note->title }}
           </strong>
           <br>
           <br>
           {{-- telah dikirim ke: <br>
           @foreach ($note->noteDistributions as $sendTo)
               - {{ $sendTo->positionReceiver->name }} <br>
           @endforeach --}}
          
        <div class="modal-footer text-center justify-content-center">
            <a href="{{ route('user.create-complete.note', ['note' => $note]) }}" class="btn mt-3 btn-primary"> <i class="bi bi-house-door"></i> Kembali ke Beranda </a>
        </div>
      </div>
    </div>
  </div>

@endsection