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
            <a wire:click="createUser" type="button" class="btn mb-1 btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#createUserInOrganizationModal">
                <i class="bi bi-plus-lg"></i> 
                User
            </a>
        </div>
        <div class="col">
            <div class="row">
                Per Halaman : 
                <select wire:model="perPage" name="" id="" class="form-control-sm w-auto mx-1">
                    <option value="5">5</option>
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                </select>
            </div>
        </div>
        <div class="col col-4">
            <input wire:model="cari" type="text" class="form-control form-control-sm" placeholder="Cari">    
        </div>
    </div>
    <div class="row">
        <div class="col">
            Filter:
        </div>
    </div>
    <div class="row">
        <div class="col-3">
            <div class="form-check">
                <input wire:model="isNotHavePosition" class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                <label class="form-check-label" for="flexCheckDefault">
                    Tidak memiliki Jabatan
                </label>
              </div>
        </div>
        <div class="col-3">
            <div class="form-check">
                <input wire:model="isMutasi" class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                <label class="form-check-label" for="flexCheckDefault">
                    Mutasi
                </label>
              </div>
        </div>
    </div>
    {{ $users->links() }}
    Total data : <span class="badge bg-success">{{ $users->total() }}</span>
    <div class="table-responsive">
        <table class="table table-responsive table-striped table-sm">
            <thead>
                <tr>
                    <th scope="col" >NIP / Nama</th>
                    <th scope="col" >Jabatan</th>
                    <th scope="col" >Dibagikan</th>
                    <th scope="col" >Diterima</th>
                    <th scope="col" class="col-2" ></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($users as $user)
                    <tr wire:loading.remove wire:target="cari">
                        <td>{{ $user->email }} | {{ $user->id }} | {{ $user->name }}</td>
                        <td>{{ $user->position_id }} {{ $user->is_plt ? '(PLT) ' : '' }}{{ $user->position ? $user->position->name : '-' }} </td>
                        <td>
                            @foreach ($user->asSender as $noteDistribution)
                                - {{ $noteDistribution->note->id }} | {{ $noteDistribution->note->title }} {{ $noteDistribution->note->user_id == $user->id ? '(Penulis)' : '' }} <br>
                            @endforeach
                        </td>
                        <td>
                            @if ($user->position)
                                @foreach ($noteDistributions->filter(function ($note) use ($user) {  return   $user->position->is_staff ?  $note->receiver_user_id == $user->id  : $note->receiver_user_id == $user->id || $note->receiver_position_id == $user->position_id ; })->unique('note_id') as $noteDistribution)
                                - {{ $noteDistribution->note->id }} <br>
                                @endforeach
                            @else
                                @foreach ($noteDistributions->filter(function ($note) use ($user) {  return    $note->receiver_user_id == $user->id; })->unique('note_id') as $noteDistribution)
                                - {{ $noteDistribution->note->id }} <br>
                                @endforeach
                            @endif
                        </td>
                        <td>
                            @if ($user->organization_id == $organizationId)
                                @if ($user->position_id == null)
                                    <a wire:click="getUser({{ $user }})" class="btn btn-sm btn-info text-white"  data-bs-toggle="modal" data-bs-target="#addPositionUserInOrganizationModal" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Setting Jabatan">
                                        <i class="bi bi-diagram-2"></i>
                                    </a>
                                @else  
                                    <a wire:click="getUser({{ $user }})" class="btn btn-sm btn-secondary"  data-bs-toggle="modal" data-bs-target="#removePositionUserInOrganizationModal" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Lepas Jabatan">
                                        <i class="bi bi-recycle"></i>
                                    </a>  
                                @endif
                                <a wire:click="getUser({{ $user }})" class="btn btn-sm btn-danger text-white"  data-bs-toggle="modal" data-bs-target="#removeStructureUserMasterModal" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Mutasi User">
                                    <i class="bi bi-door-open"></i>
                                </a> 
                                <a wire:click="getUser({{ $user }})" class="btn btn-sm btn-warning text-white"  data-bs-toggle="modal" data-bs-target="#editUserInOrganizationModal" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit User">
                                    <i class="bi bi-pencil-square"></i> 
                                </a>  
                                <a wire:click="getUser({{ $user }})" class="btn btn-sm btn-danger"  data-bs-toggle="modal" data-bs-target="#deleteUserInOrganizationModal" data-bs-toggle="tooltip" data-bs-placement="top" title="Hapus User">
                                    <i class="bi bi-trash"></i>
                                </a>
                            @else
                                @if ($user->position_id == null)
                                <a wire:click="getUser({{ $user }})" class="btn btn-sm btn-info text-white"  data-bs-toggle="modal" data-bs-target="#addPositionUserInOrganizationModal" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Setting Jabatan">
                                    <i class="bi bi-diagram-2"></i>
                                </a>
                                @else  
                                    <span class="badge bg-danger">
                                        Bukan User di {{ $organizationName }}
                                    </span>
                                @endif
                            @endif
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
        </table>
        <div wire:loading.inline wire:target="cari, previousPage, nextPage, gotoPage">
            <div class=" text-center ">
                <div class="spinner-border" role="status">
                  <span class="visually-hidden">Loading...</span>
                </div>
            </div>
        </div>
    </div>
    
    {{ $users->links() }}

     <!-- Create User In Organization Modal-->
     @include('livewire.admin.modal.user-in-organization.create')
     <!-- Delete User In Organization Modal-->
     @include('livewire.admin.modal.user-in-organization.delete')
     <!-- Edit User In Organization Modal-->
     @include('livewire.admin.modal.user-in-organization.edit')
     
     <!-- Remove User Position In Organization Modal-->
     @include('livewire.admin.modal.user-in-organization.remove-position')
     <!-- Add User Position In Organization Modal-->
     @include('livewire.admin.modal.user-in-organization.add-position')
     
    <!-- Mutasi Remove User Master Modal-->
    @include('livewire.admin.modal.user-master.remove-structure')
</div>
