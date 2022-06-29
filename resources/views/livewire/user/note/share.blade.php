<div>
    @if (session()->has('message'))
    <div class="alert alert-success alert-dismissible fade show rounded-0" role="alert">
        <i class="bi bi-check-circle-fill"></i> {{ session('message') }} 
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
    
    <input wire:model="cari" type="text" class="form-control mb-2" placeholder="Cari">  
    {{-- <table></table>
    @foreach ($noteDistributions as $noteDistribution)
        <i class="bi bi-person-check"></i> {{ $noteDistribution->positionReceiver->name ?? ''}} |
    @endforeach --}}
    <div wire:loading.inline wire:target="cari, shareTo, unShareTo" class="">
        <div class=" text-center">
            <div class="spinner-grow " style="width: 3rem; height: 3rem;" role="status">
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
    <div class="overflow-auto">
    @if (auth()->user()->is_admin || auth()->user()->position->can_share_note)
        <table class="table bg-white border-5 shadow-sm caption-top">
            <caption>Daftar diluar Instansi</caption>
            <thead class="thead-dark">
                <tr>
                    <th>Jabatan</th>
                    {{-- <th>Nama</th> --}}
                    <th></th>
                </tr>     
            </thead>
            <tbody wire:loading.remove wire:target="cari, shareTo, unShareTo">
                @forelse ($positionsOutsideOrganization as $position)   
                    <tr>
                        <td>
                            @if ($position->asReceiver->where('note_id', $note->id)->count() > 0)
                                <span class="badge bg-success">Terkirim</span>       
                            @endif
                            {{-- {{ $position->id }} |  --}}
                            <a class=" text-decoration-none text-dark font-weight-bolder" data-bs-toggle="collapse" href="#collapseExample{{ $position->id }}" role="button" aria-expanded="false" aria-controls="collapseExample">
                                {{ $position->name }} 
                            </a>
                            <div class="card m-1 p-1 bg-light collapse fst-italic" id="collapseExample{{ $position->id }}">
                            @forelse ($position->users as $user)
                                {{ $user->email }} <br> {{ $user->name }}
                            @empty
                                Kosong
                            @endforelse
                            </div>
                        </td>
                        {{-- <td>
                        </td> --}}
                        <td>
                            @if ($position->asReceiver->where('note_id', $note->id)->count() > 0)
                                @if ($position->asReceiver->where('sender_user_id', auth()->user()->id)->where('note_id', $note->id)->count() > 0)
                                    <button data-bs-target="#unShareModal{{ $position->id }}" data-bs-toggle="modal" class="btn btn-sm btn-danger d-block text-white"  {{ $position->asReceiver->where('sender_user_id', auth()->user()->id)->where('note_id', $note->id)->count() > 0 ? '' : 'disabled' }}>
                                        <i class="bi bi-arrow-clockwise"></i>  
                                    </button>
                                @else
                                    Sudah Dikirim oleh <br>
                                    {{ $note->noteDistributions->where('receiver_position_id', $position->id)->first()->positionSender->name}} <br>
                                    {{ $note->noteDistributions->where('receiver_position_id', $position->id)->first()->positionSender->users->first()->name}} <br>
                                    {{-- {{ $note->noteDistributions->positionSender->users[0]->name }} --}}
                                    {{-- {{ $note->noteDistributions[0]->positionSender->name }} <br>
                                    {{ $note->noteDistributions[0]->positionSender->users[0]->name }} --}}
                                @endif
                            @else
                                <button data-bs-target="#shareModal{{ $position->id }}" data-bs-toggle="modal" class="btn btn-sm btn-info d-block text-white">
                                    <i class="bi bi-send"> </i>
                                </button>
                            @endif
                                
                        </td>
                    </tr>               
                    <!-- Share Modal -->
                    <div class="modal fade" id="shareModal{{ $position->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">{{ $note->title }}</h5>
                                </div>
                                <div class="modal-body">Kirim ke {{ $position->name }}, {{ $position->users[0]->name ?? '-' }}</div>
                                <div class="modal-footer">
                                    <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Cancel</button>
                                    <button wire:click="shareTo({{ $note->id }}, {{ $position->id }})" class="btn btn-primary text-white" data-bs-dismiss="modal"><i class="bi bi-send"> </i> Kirim</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Delete Modal-->
                    <div class="modal fade" id="unShareModal{{ $position->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">{{ $note->title }}</h5>
                                </div>
                                <div class="modal-body">Batal Kirim</div>
                                <div class="modal-footer">
                                    <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Cancel</button>
                                    <button wire:click="unShareTo({{ $note->id }}, {{ $position->id }})" class="btn btn-danger text-white" data-bs-dismiss="modal">Hapus</button>
                                </div>
                            </div>
                        </div>
                    </div>
                
                @empty
                    <td class="" colspan="3">Tidak ada Data</td>
                @endforelse
            </tbody>
        </table>
    @endif

    <table class="table bg-white border-5 shadow-sm caption-top">
        <caption>Daftar di dalam Instansi</caption>
        <thead class="thead-dark">
            <tr>
                <th>Jabatan</th>
                {{-- <th>Nama</th> --}}
                <th></th>
            </tr>     
        </thead>
        <tbody wire:loading.remove wire:target="cari, shareTo, unShareTo">
            @forelse($positions as $position)   
                <tr>
                    <td>
                        @if ($position->asReceiver->where('note_id', $note->id)->count() > 0)
                            <span class="badge bg-success">Terkirim</span>       
                        @endif
                         {{-- {{ $position->id }} |  --}}
                         <a class=" text-decoration-none text-dark font-weight-bolder" data-bs-toggle="collapse" href="#collapseExample{{ $position->id }}" role="button" aria-expanded="false" aria-controls="collapseExample">
                            {{ $position->name }} 
                        </a>
                        <div class="collapse fst-italic" id="collapseExample{{ $position->id }}">
                        @forelse ($position->users as $user)
                            {{ $user->email }} - {{ $user->name }}
                        @empty
                            Kosong
                        @endforelse
                        </div>
                    </td>
                    {{-- <td>
                        @foreach ($position->users as $user)
                            {{ $user->name }}
                        @endforeach
                    </td> --}}
                    <td>
                        @if ($position->asReceiver->where('note_id', $note->id)->count() > 0)
                            @if ($position->asReceiver->where('sender_user_id', auth()->user()->id)->where('note_id', $note->id)->count() > 0)
                                <button data-bs-target="#unShareModal{{ $position->id }}" data-bs-toggle="modal" class="btn btn-sm btn-danger d-block text-white"  {{ $position->asReceiver->where('sender_user_id', auth()->user()->id)->where('note_id', $note->id)->count() > 0 ? '' : 'disabled' }}>
                                    <i class="bi bi-arrow-clockwise"></i>  
                                </button>
                            @else
                                <a class=" text-decoration-none text-dark font-weight-bolder" data-bs-toggle="collapse" href="#collapse{{ $position->id }}" role="button" aria-expanded="false" aria-controls="collapseExample">
                                    <span class="badge bg-success">
                                        Sudah Dikirim
                                    </span>
                                </a>
                                <div class="collapse fst-italic" id="collapse{{ $position->id }}">
                                {{ $note->noteDistributions->where('receiver_position_id', $position->id)->first()->positionSender->name}} <br>
                                {{ $note->noteDistributions->where('receiver_position_id', $position->id)->first()->positionSender->users->first()->name ?? ''}} <br>
                                {{-- {{ $note->noteDistributions->positionSender->users[0]->name }} --}}
                                {{-- {{ $note->noteDistributions[0]->positionSender->name }} <br>
                                {{ $note->noteDistributions[0]->positionSender->users[0]->name }} --}}
                                </div>
                            @endif
                        @else
                            <button data-bs-target="#shareModal{{ $position->id }}" data-bs-toggle="modal" class="btn btn-sm btn-info d-block text-white">
                                <i class="bi bi-send"> </i>
                            </button>
                        @endif
                            
                    </td>
                </tr> 
            
            
                                    
                <!-- Share Modal -->
                <div class="modal fade" id="shareModal{{ $position->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">{{ $note->title }}</h5>
                            </div>
                            <div class="modal-body">Kirim ke {{ $position->name }}, {{ $position->users[0]->name ?? '-' }}</div>
                            <div class="modal-footer">
                                <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Cancel</button>
                                <button wire:click="shareTo({{ $note->id }}, {{ $position->id }})" class="btn btn-primary text-white" data-bs-dismiss="modal"><i class="bi bi-send"> </i> Kirim</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Delete Modal-->
                <div class="modal fade" id="unShareModal{{ $position->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">{{ $note->title }}</h5>
                            </div>
                            <div class="modal-body">Batal Kirim</div>
                            <div class="modal-footer">
                                <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Cancel</button>
                                <button wire:click="unShareTo({{ $note->id }}, {{ $position->id }})" class="btn btn-danger text-white" data-bs-dismiss="modal">Hapus</button>
                            </div>
                        </div>
                    </div>
                </div>
            
            @empty
                <td class="" colspan="3">Tidak ada Data</td>
            @endforelse
        </tbody>
    </table>
    </div>
</div>
