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
      <a href="{{ route('admin.organization.create') }}" type="button" class="btn btn-sm btn-primary" ><i class="bi bi-bookmark-plus"></i> Buat SKPD</a>
    </div>
    <div class="col">
        <div class="row">
            Per Halaman : 
            <select wire:model="perPage" name="" id="" class="form-control-sm w-auto sm">
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
<div class="d-flex justify-content-center mt-3">
    {{ $organizations->links() }}
</div>
    Total data : <span class="badge bg-success">{{ $organizations->total() }}</span>
    <div class="table-responsive">
        <table class="table table-responsive table-striped table-sm">
            <thead>
                <tr>
                    <th scope="col" class="col-">Nama Organisasi</th>
                    <th scope="col">Alias</th>
                    <th scope="col" class="col-">Operator</th>
                    <th scope="col" class="col-"></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($organizations as $organization)
                    <tr wire:loading.remove wire:target="cari, previousPage, nextPage, gotoPage">
                        <td>
                            {{ $organization->name }} <br>
                            <a class="btn btn-sm btn-dark" href="{{ route('admin.organization.show', ['organization' => $organization]) }}"><i class="bi bi-gear"></i> Kelola</a>
                        </td>
                        <td>{{ $organization->alias }}</td>

                        {{-- Mulai Kolom Operator --}}
                        <td>
                            <table class="table-responsive table-striped table-sm">
                                @forelse ($organization->users->where('is_operator', true) as $operator)
                                    <tr class=" align-top "> 
                                      <td class="col-4">
                                        <a wire:click="getOperator({{ $operator }}, {{ $organization }})" class="btn btn-sm btn-outline-warning "  data-bs-toggle="modal" data-bs-target="#editOperatorModal">
                                            <i class="bi bi-pencil-square"></i> 
                                            <i class="bi bi-key"></i>
                                        </a>  
                                        <a wire:click="getOperator({{ $operator }}, {{ $organization }})" class="btn btn-sm btn-outline-danger "  data-bs-toggle="modal" data-bs-target="#deleteOperatorModal">
                                            <i class="bi bi-trash"></i>
                                        </a>
                                      </td>  
                                      <td>
                                        {{ $operator->email }} ({{ $operator->division ? $operator->division->name : 'se-SKPD' }})
                                      </td>
                                    </tr>

                                @empty
                                    <a wire:click="getOrganization({{ $organization }})" class="btn btn-sm btn-outline-primary mb-1 text-small small"  data-bs-toggle="modal" data-bs-target="#createOperatorModal">
                                        <i class="bi bi-plus-lg"></i> 
                                        Operator
                                    </a> 
                                    Belum ada Operator  
                                @endforelse
                            </table>
                        </td>
                        {{-- Akhir Kolom Operator --}}

                      
                        <td>
                            <a wire:click="getOrganization({{ $organization }})" class="btn btn-sm btn-secondary mb-1 text-small "  data-bs-toggle="modal" data-bs-target="#createOperatorModal">
                                <i class="bi bi-plus-lg"></i> 
                                Operator
                            </a>  
                            <a wire:click="getOrganization({{ $organization }})" class="btn btn-sm mb-1  btn-warning "  data-bs-toggle="modal" data-bs-target="#editOrganizationModal">
                                <i class="bi bi-pencil-square"></i>
                                Edit
                            </a>  
                            <a wire:click="getOrganization({{ $organization }})" class="btn mb-1 btn-sm btn-danger "  data-bs-toggle="modal" data-bs-target="#deleteOrganizationModal">
                                <i class="bi bi-trash"></i>
                                Hapus
                            </a>  
                        </td>
                    </tr>

                @empty
                    <tr>
                        <td colspan="5" class=" text-center">
                            Data Tidak Ditemukan
                       </td> 
                    </tr>
                @endforelse
              
            </tbody>
            <!-- Delete Operator Modal-->
            @include('livewire.admin.modal.operator.delete')
            <!-- Create Division Modal-->
            @include('livewire.admin.modal.division.create')
            <!-- Delete Division Modal-->
            @include('livewire.admin.modal.division.delete')
            <!-- Edit Division Modal-->
            @include('livewire.admin.modal.division.edit')
        </table>
        
        <div wire:loading.inline wire:target="cari, previousPage, nextPage, gotoPage">
            <div class=" text-center ">
                <div class="spinner-border" role="status">
                  <span class="visually-hidden">Loading...</span>
                </div>
            </div>
        </div>
        {{ $organizations->links() }}
        <!-- Delete Organization Modal-->
        @include('livewire.admin.modal.organization.delete')
        <!-- Edit Organization Modal-->
        @include('livewire.admin.modal.organization.edit')
        <!-- Create Operator Modal-->
        @include('livewire.admin.modal.operator.create')
        <!-- Edit Password Operator Modal-->
        @include('livewire.admin.modal.operator.edit')
      </div>
</div>
