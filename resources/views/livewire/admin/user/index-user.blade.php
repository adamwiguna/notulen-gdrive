<div>
    @if (session()->has('message'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>
            {{ session('message') }} 
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
     @endif
    <div class="row">
        <div class="col">
            <a wire:click="createUserMaster" type="button" class="btn mb-1 btn-sm btn-primary text-white" data-bs-toggle="modal" data-bs-target="#createUserMasterModal">
                <i class="bi bi-bookmark-plus"></i>
                Buat User
            </a>
        </div>
        <div class="col">
            <div class="row">
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
    <div class="row mt-3">
        <div class="col">
            Filter:
        </div>
    </div>
    <div class="row">
        <div class="col-2">
            <div class="form-check">
                <input wire:model="isOperator" class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                <label class="form-check-label" for="flexCheckDefault">
                    Operator
                </label>
              </div>
        </div>
        <div class="col-3">
            <div class="form-check">
                <input wire:model="isNotInOrganization" class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                <label class="form-check-label" for="flexCheckDefault">
                    Tidak memiliki Instansi
                </label>
              </div>
        </div>
        <div class="col-3">
            <div class="form-check">
                <input wire:model="isNotHavePosition" class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                <label class="form-check-label" for="flexCheckDefault">
                    Tidak memiliki Jabatan
                </label>
              </div>
        </div>
        <div class="col-4">
            <div class="form-check">
                <input wire:model="isNotHavePositionButHaveOrganization" class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                <label class="form-check-label" for="flexCheckDefault">
                    Tidak memiliki Jabatan tapi Memiliki Instansi
                </label>
              </div>
        </div>
    </div>
    
    <div class="d-flex justify-content-center mt-3">
        {{ $users->links() }}
    </div>
    Total data : <span class="badge bg-success">{{ $users->total() }}</span>

    <div class="table-responsive">
        <table class="table table-responsive table-striped table-sm">
            <thead>
                <tr>
                    <th scope="col" class="col-">NIP / Username</th>
                    <th scope="col">Name</th>
                    <th scope="col" class="col-">SKPD</th>
                    <th scope="col" class="col-">Bidang/Bagian</th>
                    <th scope="col" class="col-">Jabatan</th>
                    <th scope="col" class="col-4 jus"></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($users as $user)
                <tr wire:loading.remove wire:target="isOperator, isNotInOrganization, isNotHavePosition, cari, previousPage, nextPage, gotoPage">
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->organization->name ?? '-' }}</td>
                        <td>{{ $user->division->name ?? '-' }}</td>
                        <td>{{ $user->position->name ?? '-' }}</td>
                        <td>
                            @if ($user->position_id)
                            <a wire:click="getUserMaster({{ $user }})" class="btn btn-sm mb-1  btn-secondary text-white"  data-bs-toggle="modal" data-bs-target="#removeStructureUserMasterModal">
                                <i class="bi bi-arrow-repeat"></i>
                                Lepas Struktur
                            </a>  
                            @else
                            <a wire:click="getUserMaster({{ $user }})" class="btn btn-sm mb-1  btn-success text-white"  data-bs-toggle="modal" data-bs-target="#addStructureUserMasterModal">
                                <i class="bi bi-arrow-repeat"></i>
                                Pasang Struktur
                            </a>  
                            @endif
                            <a wire:click="getUserMaster({{ $user }})" class="btn btn-sm mb-1  btn-warning text-white"  data-bs-toggle="modal" data-bs-target="#editUserMasterModal">
                                <i class="bi bi-pencil-square"></i>
                                Edit
                            </a>  
                            <a wire:click="getUserMaster({{ $user }})" class="btn mb-1 btn-sm btn-danger"  data-bs-toggle="modal" data-bs-target="#deleteUserMasterModal">
                                <i class="bi bi-trash"></i>
                                Hapus
                            </a>  
                        </td>
                    </tr>
                @empty
                    Data Tidak Ditemukan
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
        {{ $users->links() }}
    </div>

    
    <!-- Create User Master Modal-->
    @include('livewire.admin.modal.user-master.create')
    
    <!-- Edit User Master Modal-->
    @include('livewire.admin.modal.user-master.edit')
    
    <!-- Delete User Master Modal-->
    @include('livewire.admin.modal.user-master.delete')
    
    <!-- Mutasi Add User Master Modal-->
    @include('livewire.admin.modal.user-master.add-structure')
    
    <!-- Mutasi Remove User Master Modal-->
    @include('livewire.admin.modal.user-master.remove-structure')

</div>
