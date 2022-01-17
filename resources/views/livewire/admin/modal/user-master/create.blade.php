<div wire:ignore.self  class="modal fade" id="createUserMasterModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div wire:loading wire:target="createUserMaster">
                <div class="d-flex justify-content-center">
                    <div class="spinner-border" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            </div>
            <div  wire:loading.remove wire:target="createUserMaster" class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Form Create User  </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div  wire:loading.remove wire:target="createUserMaster" class="modal-body">
                {{ $userSlug }}
                <div class="form-floating mb-3">
                    <input wire:model="userNIP" type="text" class="form-control  @error('userNIP') is-invalid @enderror" id="floatingName" placeholder="name">
                    <label for="floatingName">N I P / Username</label>
                    @error('userNIP')
                      <span class="invalid-feedback">
                          <strong>{{ $message }}</strong>
                      </span>
                    @enderror
                </div>
                <div class="form-floating mb-3">
                    <input wire:model="userPassword" type="text" class="form-control  @error('userPassword') is-invalid @enderror" id="floatingName" placeholder="name">
                    <label for="floatingName">Password</label>
                    @error('userPassword')
                      <span class="invalid-feedback">
                          <strong>{{ $message }}</strong>
                      </span>
                    @enderror
                </div>
                <div class="form-floating mb-3">
                    <input wire:model="userName" type="text" class="form-control  @error('userName') is-invalid @enderror" id="floatingName" placeholder="name">
                    <label for="floatingName">Nama</label>
                    @error('userName')
                      <span class="invalid-feedback">
                          <strong>{{ $message }}</strong>
                      </span>
                    @enderror
                </div>
                <div class="form-group mt-5">
                    <label for="">Setting Jabatan</label>
                    <hr class="mt-1 mb-3">
                </div>
                {{ $organizationId }}
                {{ $divisionId }}
                {{ $positionId }}

                <div class="form-floating mb-3">
                    <select wire:model="organizationId" wire:change="resetDivsionAndPosition"  class="form-select" id="floatingSelect" aria-label="Floating label select example">
                        <option  value="0" >Tanpa SKPD</option>
                        @foreach ($organizations as $organization)
                                <option value="{{ $organization->id }}">{{ $organization->name }}</option>
                        @endforeach
                    </select>
                    <label for="floatingSelect">Pilih SKPD</label>
                </div>

                <div wire:loading wire:target="organizationId">
                    <div class="spinner-grow spinner-grow-sm" role="status">
                        <span class="visually-hidden">Loading...</span>
                        <span class="visually-hidden">Loading...</span>
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>

                <div class="form-floating mb-3 ">
                    <select wire:model="divisionId"  {{ $organizationId ?'':'hidden' }} wire:loading.remove wire:target="organizationId" class="form-select"  id="floatingSelect" aria-label="Floating label select example">
                        <option  value="0" >Pimpinan SKPD </option>
                        @foreach ($divisions->where('organization_id', $organizationId) as $division)
                                <option value="{{ $division->id }}">{{ $division->name }}</option>
                        @endforeach
                    </select>
                    <label  {{ $organizationId ?'':'hidden' }} wire:loading.remove wire:target="organizationId" for="floatingSelect">Pilih Bidang / Bagian</label>
                </div>
          
                <div wire:loading wire:target="divisionId">
                    <div class="spinner-grow spinner-grow-sm" role="status">
                        <span class="visually-hidden">Loading...</span>
                        <span class="visually-hidden">Loading...</span>
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
          
                <div class="form-floating mb-3">
                    <select wire:model="positionId" {{ $organizationId ?'':'hidden' }}  wire:loading.remove wire:target="divisionId" class="form-select" id="floatingSelect" aria-label="Floating label select example">
                        <option  value="0" >Tanpa Jabatan</option>
                        @foreach ($positions->where('division_id', $divisionId == 0 ? null : $divisionId)->where('organization_id', $organizationId) as $position)
                            <option value="{{ $position->id }}" {{ ($position->users->count() > 0 && $position->is_staff == 0) ?'disabled':'' }}>
                                {{ $position->name }}
                                @foreach ($position->users as $user)
                                | dipegang oleh : {{ $user->name }},
                                @endforeach
                            </option>
                        @endforeach
                    </select>
                    <label {{ $organizationId ?'':'hidden' }} wire:loading.remove wire:target="divisionId" for="floatingSelect">Pilih Jabatan</label>
                </div>

                <div class="form-check form-switch">
                    <input wire:model="userIsPlt" {{ $positionId ?'':'hidden' }} class="form-check-input" type="checkbox" id="flexSwitchCheckDefault">
                    <label class="form-check-label"  {{ $positionId ?'':'hidden' }} for="flexSwitchCheckDefault">Status PLT</label>
                </div>
                <button wire:click="storeUserMaster" type="submit" class="btn btn-primary mt-3" data-bs-dismiss="modal" >
                    <i class="bi bi-save"></i>
                    Simpan
                </button>
            </div>
        </div>
    </div>
</div> 