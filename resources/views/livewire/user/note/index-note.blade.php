<div>

    <div class="d-flex align-items-center p-3 my-3 text-dark bg-white shadow-lg">
        <div class="lh-1 justify-content-center col-12">
            <h1 class="h6 mb-0  lh-1 mb-1">Halo, {{ auth()->user()->name }}</h1>
            <small>Ayo buat notulen dengan menekan tombol dibawah</small> <br>
            
            <a class="btn btn-primary d- mt-3 py-2" href="{{ route('user.note.create') }}" >
                <i class="bi bi-clipboard-plus"></i>
                Notulen
            </a>
            <br>
    
            <div class=" d-flex justify-content-start small">
                <input wire:model="settings" class="btn-check mt-3" type="checkbox" id="flexCheckDefault0" onclick="this.blur();"  value="" >
                <label class="btn small btn-sm btn-secondary {{ $settings == true ? '' : 'bg-transparent text-dark' }} mt-3" for="flexCheckDefault0" onclick="this.blur();">
                    <small>
                        @if ($settings == true)
                            <i class="bi bi-chevron-down"></i> 
                        @else    
                            <i class="bi bi-chevron-up"></i> 
                        @endif 
                        Setting Pencarian  <i class="bi bi-gear-fill"></i> 
                    </small>
                </label> 
            </div>

            <div class="mt-3 lh-base collapse {{ $settings == true ? 'show' : '' }}" id="collapseExample">
             
                    Per Halaman : 
                    <select wire:model="perPage" name="" id="" class="form-control-sm w-auto sm">
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                    </select>
                <input wire:model="cari" type="text" class="form-control mb-2 mt-2" placeholder="Cari notulen">  
                {{-- {{ $cari }} --}}
                <div>
                Filter Notulen:   
                </div>
                {{-- {{ $noteCreator }} --}}
                
                {{-- <input wire:model="noteCreator" class="form-check-input" type="checkbox" value="" id="flexCheckChecked"  > Sendiri --}}
                <input wire:model="noteCreator" class="btn-check" type="checkbox" id="flexCheckDefault" onclick="this.blur();"  value="" >
                <label class="btn btn-outline-success " for="flexCheckDefault" onclick="this.blur();">
                    Saya
                </label> 
                <input wire:model="noteNew" class="btn-check" type="checkbox" id="flexCheckDefault3" onclick="this.blur();"  value="" >
                <label class="btn btn-outline-success" for="flexCheckDefault3" onclick="this.blur();">
                    Baru
                </label> 
                <input wire:model="noteReceived" class="btn-check" type="checkbox" id="flexCheckDefault1" onclick="this.blur();" >
                <label class="btn btn-outline-success" for="flexCheckDefault1" onclick="this.blur();">
                    Diterima
                </label>
                <input wire:model="noteSent" class="btn-check" type="checkbox" id="flexCheckDefault2" onclick="this.blur();" >
                <label class="btn btn-outline-success" for="flexCheckDefault2" onclick="this.blur();">
                    Dikirim
                </label>
            </div>
          
        </div>
    </div>
    @if (session()->has('message'))
    <div class="alert alert-success alert-dismissible fade show rounded-0" role="alert">
        <i class="bi bi-check-circle-fill"></i> {{ session('message') }} 
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
    
    <div class="fixed-bottom p0">
        
        <div class="d-flex justify-content-center pt-2 small d-sm-flex bg-dark text-white ">
            <small>
                <div class="d-flex justify-content-center">
                    Total data : <span class="badge bg-success mb-1">{{ $notes->total() }}</span>
                </div>
                <div class="small">
                    {{ $notes->onEachSide(1)->links() }}
                </div>
            </small>
        </div>
        {{-- <div class="mt-3 mb-2" wire:loading.remove wire:target="noteNew, noteReceived, noteSent, noteCreator, perPage, cari, previousPage, nextPage, gotoPage" >
            Total data : <span class="badge bg-success">{{ $notes->total() }}</span>
        </div> --}}
    </div>
        

    <div wire:loading.inline wire:target="noteNew, noteReceived, noteSent, noteCreator, perPage, cari, previousPage, nextPage, gotoPage" class="mt-5">
        <div class=" text-center mt-5 ">
            <div class="spinner-grow  mt-5" style="width: 3rem; height: 3rem;" role="status">
                <span class="visually-hidden">Loading...</span>
              </div>
            <div class="spinner-grow" style="width: 3rem; height: 3rem;" role="status">
                <span class="visually-hidden">Loading...</span>
              </div>
            <div class="spinner-grow" style="width: 3rem; height: 3rem;" role="status">
                <span class="visually-hidden">Loading...</span>
              </div>
        </div>
    </div>
@forelse ($notes as $note)
    <div wire:loading.remove wire:target="noteNew, noteReceived, noteSent, noteCreator, perPage, cari, previousPage, nextPage, gotoPage" class="card mb-2 shadow-sm rounded-0 p-0 {{ $note->noteDistributions->where('is_read', 0)->where('receiver_position_id', auth()->user()->position_id)->count() > 0 ? 'border-danger border-1' : '' }}">
        <div class="card-header bg-white small justify-content-between d-flex flex py-1 px-2 ">
            <small>
                <h5 class="card-title mb-1">
                    {{ $note->id }}{{ $note->title }}
                    @if ( $note->noteDistributions->where('is_read', 0)->where('receiver_position_id', auth()->user()->position_id)->count() > 0)
                        <span class="badge bg-danger">Baru</span>   
                    @endif
                </h5>
                <h5 class="card-title mb-1">
                    {{ $note->user_id }}{{ $note->user->name }}
                </h5>
                <div>
                    {{-- @foreach ($note->noteDistributions->where('receiver_position_id', auth()->user()->position->id) as $noteDistribution)
                        <i class="bi bi-share-fill"></i> {{ $noteDistribution->positionSender->users[0]->name}} 
                    @endforeach --}}
                </div>
                <div>
                    @foreach ($note->noteDistributions as $noteDistribution)
                        <i class="bi bi-person-check"></i> {{ $noteDistribution->positionReceiver->users[0]->name ?? ''}} |
                    @endforeach
                </div>
            </small>
            <div class="dropdown mx-1">
              
                @can('manage-this-note', $note)
                <button class="btn btn-lg p-0 m-0"  id="dropdownMenuButton{{ $note->id }}" data-bs-toggle="dropdown" data-bs-target="#dropdown{{ $note->id }}" >
                    <i class="bi bi-three-dots"> </i> 
                </button>
                <ul class="dropdown-menu dropdown-menu-dark bg-dark" id="dropdown{{ $note->id }}" aria-labelledby="dropdownMenuButton2">
                    <li><a class="dropdown-item" href="{{ route('user.share.note', ['note' => $note]) }}"><i class="bi bi-send"></i> Kirim</a></li>
                    {{-- <li><a class="dropdown-item" href="#"><i class="bi bi-send"></i>{{ $note->id }} Kirim keluar SKPD</a></li> --}}
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="{{ route('user.photo.create', ['note' => $note]) }}"><i class="bi bi-camera"></i> Update Foto</a></li>
                    <li><a class="dropdown-item" href="{{ route('user.attendance.create', ['note' => $note]) }}"><i class="bi bi-person-plus"></i> Update Kehadiran</a></li>
                    <li><a class="dropdown-item" href="{{ route('user.note.edit', ['note' => $note]) }}"><i class="bi bi-pencil-square"></i> Edit</a></li>
                    <li>
                        <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#exampleModalDelete{{ $note->id }}">
                            <i class="bi bi-trash-fill"></i> Hapus
                        </button>
                    </li>
                </ul>
                @else
                <a class="btn btn-lg p-0 m-0" href="{{ route('user.share.note', ['note' => $note]) }}" >
                    <i class="bi bi-send"> </i> 
                </a>
                @endcan
            </div>
        </div>
        

        {{-- Carousel Photos --}}
        @if ($note->photos->count() > 0)
            <div id="carouselExampleIndicators{{ $note->id }}" class="carousel slide" data-bs-ride="carousel"  >
                <div class="carousel-indicators">
                    @foreach ($note->photos as $photo)
                        <button type="button" data-bs-target="#carouselExampleIndicators{{ $note->id }}" data-bs-slide-to="{{ $loop->index }}" class="{{ $loop->first ? 'active' : '' }}" aria-current="{{ $loop->first ? 'true' : '' }}" aria-label="Slide {{ $loop->iteration }}"></button>            
                    @endforeach
            </div>
                <div class="carousel-inner" >
                    @foreach ($note->photos as $photo)
                        <div class="carousel-item {{ $loop->first ? 'active' : '' }} bg-secondary" style="aspect-ratio: 16/9; overflow:hidden;     ">
                            {{-- <a href="{{ $photo->url }}"> --}}
                            <a data-bs-toggle="modal" data-bs-target="#exampleModal{{ $photo->id }}">
                                <img src="{{ $photo->url }}" class="d-block w-100 shadow" alt="" style=" object-fit:  contain;  height:100%; object-position: center;">
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
                @else
                    <div class="carousel-item {{ $loop->first ? 'active' : '' }} bg-dark " style="aspect-ratio: 16/9; overflow:hidden;     ">
                        <img src="https://via.placeholder.com/1600x900?text=Foto+Tidak+Ditemukan" class="d-block w-100" alt="" style=" object-fit:  contain;  height:100%; object-position: center;">
                    </div>
                @endif
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

    <!-- Modal Read Note-->
    <div class="modal fade " id="exampleModal{{ $note->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ $note->title }}</h5>
                </div>
                <div class="modal-body">
                    <table>
                        <tr>
                            <td> <i class="bi bi-megaphone-fill"></i></td>
                            <td>{{ $note->organizer }}</td>
                        </tr>
                        <tr>
                            <td><i class="bi bi-calendar-event-fill"></td>
                            <td>{{ $note->date }}</td>
                        </tr>
                        <tr>
                            <td> <i class="bi bi-geo-fill"></i> </td>
                            <td>{{ $note->location??'' }}</td>
                        </tr>
                        <tr>
                            <td><i class="bi bi-pen-fill"></i></td>
                            <td> {{ $note->user->name}}</td>
                        </tr>
                        <tr>
                            <td> <i class="bi bi-people-fill"></td>
                            <td>
                                <a class="btn btn-dark btn-sm py-0" data-bs-target="#exampleModalToggle{{ $note->id }}" data-bs-toggle="modal" data-bs-dismiss="modal">
                                    Lihat Kehadiran <i class="bi bi-search"></i>
                                </a>
                            </td>
                        </tr>
                    </table>
                    <br>
                    <p>
                        {!! $note->content !!}

                    </p>
                </div>
                <div class="modal-footer ">
                    <a href="{{ route('user.export.note', ['note' => $note]) }}" class="btn btn-success d-block"  ><i class="bi bi-download"></i> Export ke Word</a>
                    <button wire:click="read_note({{ $note }}, {{ auth()->user() }})" type="button" class="btn btn-primary d-block"  data-bs-dismiss="modal"><i class="bi bi-check-circle-fill"></i> Selesai Membaca</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Attendance Note --}}
    <div class="modal fade" id="exampleModalToggle{{ $note->id }}" aria-hidden="true" aria-labelledby="exampleModalToggleLabel2" tabindex="-1">
        <div class="modal-dialog modal-fullscreen modal-dialog-scrollable">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalToggleLabel2">Kehadiran</h5>
            </div>
            <div class="modal-body">
                {{-- @livewire('user.note.list-attendance', ['note' => $note]) --}}
                @can('manage-this-note', $note)
                <div wire:ignore.self class="input-group input-group-sm small mb-3">
                    <input wire:model.defer="attendanceName" type="text" aria-label="First name" class="form-control form-control-sm" placeholder="Nama">
                    <input wire:model.defer="attendancePosition" type="text" aria-label="Last name" class="form-control form-control-sm" placeholder="Jabatan">
                    <input wire:model.defer="attendanceOrganization" type="text" aria-label="Last name" class="form-control form-control-sm" placeholder="Instansi">
                    <button wire:click.defer="storeAttendance({{ $note->id }})" class="btn btn-sm btn-success" >
                        <i class="bi bi-plus-square"></i>
                    </button>
                </div>
                @endcan
                @if (session()->has('message-attendance'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('message-attendance') }} 
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                <table class="table mx-1 small table-sm">
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Nama</th>
                            <th scope="col">Jabatan</th>
                            <th scope="col">Instansi</th>
                            @can('manage-this-note', $note)
                            <th scope="col"></th>
                            @endcan
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($note->attendances as $attendance)
                            <tr>
                                <th scope="row">{{ $loop->iteration }}</th>
                                <td>{{ $attendance->name }}</td>
                                <td>{{ $attendance->position }}</td>
                                <td>{{ $attendance->organization }}</td>
                                @can('manage-this-note', $note)
                                <td>
                                    <button class="btn btn-danger btn-sm small py-0 px-1" data-bs-toggle="modal" data-bs-target="#exampleModalDelete{{ $attendance->id }}">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </td>
                                @endcan
                            </tr>
                            <!-- Modal Delete Note -->
                            <div class="modal fade " id="exampleModalDelete{{ $attendance->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Anda Yakin?</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            Hapus Kehadiran "{{ $attendance->name }}"
                                        </div>
                                        <div class="modal-footer ">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                            <button wire:click="deleteAttendance({{ $attendance->id }})" class="btn btn-danger d-block" data-bs-dismiss="modal"><i class="bi bi-trash-fill"></i> Hapus</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <tr>
                                <td colspan="5">Tidak Ada Data</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
              <button class="btn btn-primary" data-bs-target="#exampleModal{{ $note->id }}" data-bs-toggle="modal" data-bs-dismiss="modal"><i class="bi bi-arrow-bar-left"></i> Kembali</button>
            </div>
          </div>
        </div>
      </div>

    <!-- Modal Delete Note -->
    <div class="modal fade " id="exampleModalDelete{{ $note->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Anda Yakin?</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Hapus Notulen "{{ $note->title }}"
                </div>
                <div class="modal-footer ">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <form action="{{ route('user.note.destroy', ['note' => $note]) }}" method="POST">
                        @method('delete')
                        @csrf
                        <button class="btn btn-danger d-block" type="submit"><i class="bi bi-trash-fill"></i> Hapus</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
  
@empty
{{-- <div wire:loading.remove wire:target="noteNew, noteReceived, noteSent, noteCreator, perPage, cari, previousPage, nextPage, gotoPage" class="card shadow-sm rounded-0 p-0 mt-5">
    <div class="card-text bg-white small justify-content-center d-flex flex py-1 px-2 my-5 "> --}}
       <h5 class="justify-content-center d-flex">
           Tidak Ada Notulen
        </h5> 
    {{-- </div>
</div> --}}
@endforelse

<div class="m-5 py-1">

</div>

</div>
