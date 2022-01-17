<div>
    <input wire:model="cari" type="text">
    {{ $cari }}

    <input wire:model="search" type="text" class="form-control form-control-sm" placeholder="search">  
    {{ $search }}
<div>
Filter Notulen:   
</div>
{{ $noteCreator }}

@foreach ($notes as $note)
{{ $note->title }}
<hr>
<div class="card mb-2 shadow-sm rounded-0 p-0">
    <div class="card-header bg-white small justify-content-between d-flex flex py-1 px-2">
        <small>
            <h5 class="card-title mb-1">
                {{ $note->id }}{{ $note->title }}
            </h5>
            <h5 class="card-title mb-1">
                {{ $note->user_id }}{{ $note->user->name }}
            </h5>
            @foreach ($note->noteDistributions->where('receiver_user_id', auth()->user()->id) as $noteDistribution)
            <i class="bi bi-share-fill"></i> {{ $noteDistribution->userSender->name}} <br>
            @endforeach
            @if ($note->user_id == auth()->user()->id)
                @foreach ($note->noteDistributions as $noteDistribution)
                    <i class="bi bi-person-check"></i> {{ $noteDistribution->userReceiver->name}} <br>
                @endforeach
            @endif
        </small>
        <div class="dropdown mx-1">
            <a class="btn btn-lg p-0 m-0" role="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="">
                <i class="bi bi-three-dots"></i>
            </a>
            <ul class="dropdown-menu dropdown-menu-dark bg-dark" aria-labelledby="dropdownMenuButton2">
                <li><a class="dropdown-item" href="#"><i class="bi bi-share-fill"></i> Share</a></li>
                <li><a class="dropdown-item" href="#"><i class="bi bi-send"></i> Kirim keluar SKPD</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="{{ route('user.photo.create', ['note' => $note]) }}"><i class="bi bi-camera"></i> Update Foto</a></li>
                <li><a class="dropdown-item" href="{{ route('user.attendance.create', ['note' => $note]) }}"><i class="bi bi-person-plus"></i> Update Kehadiran</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="{{ route('user.note.edit', ['note' => $note]) }}"><i class="bi bi-pencil-square"></i> Edit</a></li>
                <li>
                    <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#exampleModalDelete{{ $note->id }}">
                        <i class="bi bi-trash-fill"></i> Hapus
                    </button>
                </li>
            </ul>
        </div>
    </div>

        <div class="card-body small py-1 px-2">
            
            {{ $note->description??'' }} <br>
            <small>
                <button type="button" class="btn btn-dark btn-sm small text-small p-1" data-bs-toggle="modal" data-bs-target="#exampleModal{{ $note->id }}">
                    <i class="bi bi-eye"></i> 
                    Baca Notulen
                </button>
            </small>
          
        </div>
        
    </div>
        {{-- @livewire('user.note.list-photo', ['note' => $note]) --}}
</div>
    
@endforeach
</div>
