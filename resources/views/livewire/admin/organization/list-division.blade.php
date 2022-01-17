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
            <a wire:click="createDivision" type="button" class="btn mb-1 btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#createDivisionModal">
                <i class="bi bi-plus-lg"></i> 
                Bidang
            </a>
        </div>
        <div class="col">
            <input wire:model="cari" type="text" class="form-control form-control-sm" placeholder="Cari">    
        </div>
    </div>
    Total data : <span class="badge bg-success">{{ $divisions->total() }}</span>
    <div class="table-responsive">
        <table class="table table-responsive table-striped table-sm">
            <thead>
                <tr>
                    <th scope="col" >Nama Bidang/Bagian</th>
                    <th scope="col" >Alias</th>
                    <th scope="col" ></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($divisions as $division)
                    <tr wire:loading.remove wire:target="cari">
                        <td>{{ $division->name }}</td>
                        <td>{{ $division->alias }}</td>
                        <td>
                            <a wire:click="getDivision({{ $division }})" class="btn btn-sm btn-warning"  data-bs-toggle="modal" data-bs-target="#editDivisionModal">
                                <i class="bi bi-pencil-square"></i> 
                            </a>  
                            <a wire:click="getDivision({{ $division }})" class="btn btn-sm btn-danger"  data-bs-toggle="modal" data-bs-target="#deleteDivisionModal">
                                <i class="bi bi-trash"></i>
                            </a>
                        </td>
                    </tr>
                @empty
                <tr>
                    <td colspan="3" class=" text-center">
                        Data Tidak Ditemukan
                    </td> 
                </tr>
                @endforelse
            </tbody>
        </table>
        <div wire:loading.inline wire:target="cari, previousPage, nextPage, gotoPage">
            <div class=" text-center ">
                <div class="spinner-border" role="status">
                  <span class="visually-hidden">Loading...</span>
                </div>
            </div>
        </div>
    </div>



    
    <!-- Create Division Modal-->
    @include('livewire.admin.modal.division.create')
    <!-- Delete Division Modal-->
    @include('livewire.admin.modal.division.delete')
    <!-- Edit Division Modal-->
    @include('livewire.admin.modal.division.edit')
</div>
