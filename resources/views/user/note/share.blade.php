@extends('user.layouts.app')

@section('content')

<h4 class=" text-center mt-3 mb-3 text-decoration-underline"> Kirim Notulen</h4>
<h5 class=" text-center mt-3 mb-3 "> {{ $note->title }}</h5>

@livewire('user.note.share', ['note' => $note])

@endsection