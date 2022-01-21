<div>
    @if (session()->has('message'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>
            {{ session('message') }} 
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <div class="row mb-3">
        <div class="col">
            <a wire:click="createPosition" type="button" class="btn mb-1 btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#createPositionModal">
                <i class="bi bi-plus-lg"></i> 
                Jabatan
            </a>
        </div>
        <div class="col">
            <div class="row">
                Per Halaman : 
                <select wire:model="perPage" name="" id="" class="form-control-sm w-auto  mx-1">
                    <option value="5">5</option>
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                </select>
            </div>
        </div>
        <div class="col">
            <input wire:model="cari" type="text" class="form-control form-control-sm" placeholder="Cari">    
        </div>
    </div>
    <div class="row">
        <div class="col-3">
            <div class="form-check">
                <input wire:model="free" class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                <label class="form-check-label" for="flexCheckDefault">
                    Tanpa User
                </label>
              </div>
        </div>
        <div class="col-3">
            <div class="form-check">
                <input wire:model="canShare" class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                <label class="form-check-label" for="flexCheckDefault">
                    Mengirim Keluar
                </label>
              </div>
        </div>
        <div class="col-3">
            <div class="form-check">
                <input wire:model="canReceive" class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                <label class="form-check-label" for="flexCheckDefault">
                    Menerima Dari Luar
                </label>
              </div>
        </div>
    </div>
    
    {{ $positions->links() }}
    
    Total data : 
    <span class="badge bg-success small">
        <div wire:loading.remove wire:target="cari, previousPage, nextPage, gotoPage, canShare, canReceive, free">
            {{ $positions->total() }}
        </div>
        <div wire:loading wire:target="cari, previousPage, nextPage, gotoPage, canShare, canReceive, free">
            <div class=" text-center text-small small">
                <div class="spinner-border spinner-border-sm small" role="status">
                  <span class="visually-hidden small ">Loading...</span>
                </div>
            </div>
        </div>
    </span> 
    
    <div class="table-responsive">
        <table class="table table-responsive table-striped table-sm">
            <thead>
                <tr>
                    <th scope="col" >Jabatan</th>
                    <th scope="col" >Singkatan / Alias</th>
                    <th scope="col" >Notulen Diterima</th>
                    <th scope="col" >User</th>
                    <th scope="col" ></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($positions as $position)
                    <tr wire:loading.remove wire:target="cari, previousPage, nextPage, gotoPage, canShare, canReceive, free, perPage">
                        <td>
                            {{-- {{ $position->id }} | --}}
                            {{ $position->name }} {!! $position->is_staff ? '<i class="bi bi-people-fill"></i>' : '' !!}
                        </td> 
                        <td>{{ $position->alias }} {!! $position->is_staff ? '<i class="bi bi-people-fill"></i>' : '' !!}</td>
                        <td>
                            {{ $position->asReceiver->count() }}
                        </td>
                        <td>
                            <div class=" fst-italic"> 
                                @if ($position->users->count() == 0)
                                     -
                                @endif
                                @foreach ($position->users as $user)    
                                   {{ $user->is_plt ? '(PLT) ' : '' }} {{ $user->name }}   <br>                             
                                @endforeach
                            </div> 
                        </td>
                       
                        <td>
                            <a wire:click="getPosition({{ $position }})" class="btn btn-sm btn-warning"  data-bs-toggle="modal" data-bs-target="#editPositionModal">
                                <i class="bi bi-pencil-square"></i> 
                            </a>  
                            <a wire:click="getPosition({{ $position }})" class="btn btn-sm btn-danger"  data-bs-toggle="modal" data-bs-target="#deletePositionModal">
                                <i class="bi bi-trash"></i>
                            </a>
                        </td>
                    </tr>
                @empty
                <tr>
                    <td colspan="4" class=" text-center">
                        Data Tidak Ditemukan
                    </td> 
                </tr>
                @endforelse
            </tbody>
        </table>
        <div wire:loading.inline wire:target="cari, previousPage, nextPage, gotoPage, canShare, canReceive, free, perPage">
            <div class=" text-center ">
                <div class="spinner-border" role="status">
                  <span class="visually-hidden">Loading...</span>
                </div>
            </div>
        </div>
    </div>
    {{ $positions->links() }}

    
    <!-- Create Position Modal-->
    @include('livewire.admin.modal.position.create')
    <!-- Edit Position Modal-->
    @include('livewire.admin.modal.position.edit')
    <!-- Delete Position Modal-->
    @include('livewire.admin.modal.position.delete')

</div>
