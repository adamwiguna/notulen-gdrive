<div>
    <div id="carouselExampleIndicators{{ $note->id }}" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-indicators">
            @foreach ($photos as $photo)
                <button type="button" data-bs-target="#carouselExampleIndicators{{ $note->id }}" data-bs-slide-to="{{ $loop->index }}" class="{{ $loop->first ? 'active' : '' }}" aria-current="{{ $loop->first ? 'true' : '' }}" aria-label="Slide {{ $loop->iteration }}"></button>            
            @endforeach
       </div>
        <div class="carousel-inner" >
            @foreach ($photos as $photo)
                {{-- <div class="carousel-item {{ $loop->first ? 'active' : '' }} bg-dark" style="aspect-ratio: 4/3; position: relative; width:100%;"> --}}
                {{-- <div class="carousel-item {{ $loop->first ? 'active' : '' }} " style="padding-top: 75%;  text-align: center; overflow: hidden; width:100%; background: black; position: relative;    "> <!-- full widht --> --}}
                <div class="carousel-item {{ $loop->first ? 'active' : '' }} bg-dark " style="aspect-ratio: 4/3; overflow:hidden;     ">
                    {{-- <a href="{{ $photo->url }}"> --}}
                    <a data-bs-toggle="modal" data-bs-target="#exampleModal{{ $photo->id }}">
                        {{-- <img src="{{ $photo->url }}" class="d-block w-100" alt="" style="height: 100%; object-fit:  contain; "> --}}
                        {{-- <img src="{{ $photo->url }}" class="d-block w-100" alt="" style=" position: absolute; top: 50%; transform: translateY(-50%);"><!-- full widht --> --}}
                        <img src="{{ $photo->url }}" class="d-block w-100" alt="" style=" object-fit:  cover;  height:100%; object-position: center;">
                    </a>
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
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators{{ $note->id }}" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators{{ $note->id }}" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
</div>
