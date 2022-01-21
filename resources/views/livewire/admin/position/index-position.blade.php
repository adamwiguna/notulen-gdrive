<div>
    @if (session()->has('message'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>
            {{ session('message') }} 
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
     @endif
    <div class="row align-middle">
        <div class="col">
            <a wire:click="createPositionMaster" type="button" class="btn mb-1 btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#createPositionMasterModal">
                <i class="bi bi-bookmark-plus"></i>
                Buat Jabatan
            </a>
        </div>
        <div class="col">
            <div class="row ">
                Per Halaman : 
                <select wire:model="perPage" name="" id="" class="form-control-sm w-auto sm mx-1">
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
    <div>
        Filter Notulen:   
        </div>
        {{-- {{ $noteCreator }} --}}
        
        {{-- <input wire:model="noteCreator" class="form-check-input" type="checkbox" value="" id="flexCheckChecked"  > Sendiri --}}
        <input wire:model="free" class="btn-check" type="checkbox" id="flexCheckDefault" onclick="this.blur();"  value="" >
        <label class="btn btn-outline-success " for="flexCheckDefault" onclick="this.blur();">
            Tanpa User
        </label> 
        <input wire:model="canShare" class="btn-check" type="checkbox" id="flexCheckDefault" onclick="this.blur();"  value="" >
        <label class="btn btn-outline-success " for="flexCheckDefault" onclick="this.blur();">
            Mengirim Keluar
        </label> 
        <input wire:model="canReceive" class="btn-check" type="checkbox" id="flexCheckDefault3" onclick="this.blur();"  value="" >
        <label class="btn btn-outline-success" for="flexCheckDefault3" onclick="this.blur();">
            Menerima
        </label> 

    <div class="d-flex justify-content-center mt-3">
        {{ $positions->links() }}
    </div>
    Total data : <span class="badge bg-success">{{ $positions->total() }}</span>

    <div class="table-responsive">
        <table class="table table-responsive table-striped table-sm">
            <thead>
                <tr>
                    <th scope="col" class="col-">Jabatan</th>
                    <th scope="col" class="col-">Pemegang Jabatan Saat Ini</th>
                    <th scope="col">Alias</th>
                    <th scope="col" class="col-">SKPD</th>
                    {{-- <th scope="col" class="col-">Bidang/Bagian</th> --}}
                    <th scope="col" class="col-2"></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($positions as $position)
                    <tr wire:loading.remove wire:target="isOperator, isNotInOrganization, isNotHavePosition, cari, previousPage, nextPage, gotoPage">
                        <td>{{ $position->name }}</td>
                        <td>
                            @forelse ($position->users as $user)
                                {{ $user->name }} <br>
                            @empty
                                -
                            @endforelse
                        </td>
                        <td>{{ $position->alias }}</td>
                        <td>{{ $position->organization->name ?? '-' }}</td>
                        {{-- <td>{{ $position->division->name ?? '-' }}</td> --}}
                        <td>
                            <a wire:click="getPositionMaster({{ $position }})" class="btn btn-sm mb-1  btn-warning text-white"  data-bs-toggle="modal" data-bs-target="#editPositionMasterModal">
                                <i class="bi bi-pencil-square"></i>
                                Edit
                            </a>  
                            <a wire:click="getPositionMaster({{ $position }})" class="btn mb-1 btn-sm btn-danger"  data-bs-toggle="modal" data-bs-target="#deletePositionMasterModal">
                                <i class="bi bi-trash"></i>
                                Hapus
                            </a>
                        </td>
                    </tr>
                @empty
                    
                @endforelse
            </tbody>
        </table>
    </div>

    <div wire:loading.inline wire:target="isOperator, isNotInOrganization, isNotHavePosition, cari, previousPage, nextPage, gotoPage">
        <div class=" text-center ">
            <div class="spinner-border" role="status">
              <span class="visually-hidden">Loading...</span>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-center mt-3">
        {{ $positions->links() }}
    </div>

    <!-- Create position Master Modal-->
    @include('livewire.admin.modal.position-master.create')
    
    <!-- Edit position Master Modal-->
    @include('livewire.admin.modal.position-master.edit')
    
    <!-- Delete position Master Modal-->
    @include('livewire.admin.modal.position-master.delete')

</div>
