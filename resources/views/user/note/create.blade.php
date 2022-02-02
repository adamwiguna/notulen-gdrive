@extends('user.layouts.app')

@section('content')

<div class="container">
<div class="row mt-5">
    <div class="col-3 text-center fw-bold text-primary ">Notulen</div>
    <div class="col-3 text-center">Foto</div>
    <div class="col-3 text-center">Kehadiran</div>
    <div class="col-3 text-center">Kirim</div>
</div>
<div class="progress mt-2 mb-5">
    <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 25%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">(1/4)</div>
</div>

<h4 class=" text-center mt-3 mb-3 text-decoration-underline">Langkah 1 : Form Notulen</h4>

<form action="{{ route('user.store-step-1.note', ['note' => $note]) }}" method="POST" >
    @csrf
    <input name="slug" type="hidden" value="{{ Str::random(50) }}">
    <div class="form-floating mb-3">
        <input name="title" value="{{ old('title', $note->title) }}" type="text" class="form-control  @error('title') is-invalid @enderror" id="floatingtitle" placeholder="title">
        <label for="floatingtitle" class=" text-small small">Nama Kegiatan</label>
        @error('title')
        <span class="invalid-feedback">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
    <div class="form-floating mb-3">
        <input name="organizer" value="{{ old('organizer', $note->organizer) }}" type="text" class="form-control @error('organizer') is-invalid @enderror" id="floatingAlias" placeholder="Alias">
        <label for="floatingAlias" class=" text-small small">Penyelenggara</label>
        @error('organizer')
        <span class="invalid-feedback">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
    <div class="form-floating mb-3">
        <input name="location" value="{{ old('location', $note->location) }}" type="text" class="form-control @error('location') is-invalid @enderror" id="floatinglocation" placeholder="location">
        <label for="floatinglocation" class=" text-small small">Lokasi</label>
        @error('location')
        <span class="invalid-feedback">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
    <div class="form-floating mb-3 col-lg-3 col-6 col-md-3">
        <input size="5" name="date" value="{{ old('date', $note->date) }}" type="date" class="form-control @error('date') is-invalid @enderror" id="floatinglocation" >
        <label for="floatinglocation" class=" text-small small">Tanggal</label>
        @error('date')
        <span class="invalid-feedback">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
    <div class="form-floating mb-3">
        <textarea style="height: 80px" name="description" value="{{ old('description',  $note->description) }}" type="text" class="form-control @error('description') is-invalid @enderror" id="floatinglocation" placeholder="description">{{ old('description',  $note->description) }}</textarea>
        <label for="floatinglocation" class=" text-small small">Ringkasan / Caption (Bisa Kosong) </label>
        @error('description')
        <span class="invalid-feedback">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
    <div class="form-group mb-3">
        <label for="isi" class="mb-2 text-center text-decoration-underline text-bold">Materi yang dibahas</label>
        <input id="content" class="bg-white @error('content') is-invalid @enderror" type="hidden" name="content" value="{{ old('content', $note->content) }}"  placeholder="Materi yang dibahas">
        <trix-editor input="content" class=" bg-white @error('content') is-invalid @enderror" placeholder="Materi yang dibahas"></trix-editor>  
        @error('content')
        <div class="invalid-feedback">
            <strong>{{ $message }}</strong>
        </div>
        @enderror
      </div>
      <div class="d-grid gap-2 d-md-flex justify-content-md-end">
       
        <a href="{{ route('user.dashboard') }}" class="btn mt-3 btn-danger">Batal <i class="bi bi-trash"></i></a>
      
        <button type="submit" class="btn mt-3 btn-primary">Simpan (1/4) - Langkah Selanjutnya <i class="bi bi-arrow-bar-right"></i></button>
       
    </div>
</form>
</div>
@endsection