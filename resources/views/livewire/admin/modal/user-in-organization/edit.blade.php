<div wire:ignore.self  class="modal fade" id="editUserInOrganizationModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div wire:loading wire:target="createUser, getUser">
                <div class="d-flex justify-content-center">
                    <div class="spinner-border" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            </div>
            <div  wire:loading.remove wire:target="createUser, getUser" class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Form Create User pada "{{ $organizationName }}" </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div  wire:loading.remove wire:target="createUser, getUser" class="modal-body">
                {{ $userSlug }}
                <div class="form-floating mb-3">
                    <input disabled wire:model="userNIP" type="text" class="form-control" id="floatingName" placeholder="name">
                    <label for="floatingName">N I P / Username</label>
                    {{-- @error('userNIP')
                      <span class="invalid-feedback">
                          <strong>{{ $message }}</strong>
                      </span>
                    @enderror --}}
                </div>
                <div class="form-floating mb-3">
                    <input wire:model="userPassword" type="text" class="form-control" id="floatingName" placeholder="name">
                    <label for="floatingName">Password (Kosongkan jika tidak ada perubahan)</label>
                    {{-- @error('userPassword')
                      <span class="invalid-feedback">
                          <strong>{{ $message }}</strong>
                      </span>
                    @enderror --}}
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
                {{-- <div class="form-floating mb-3">
                    <select wire:model="divisionId" wire:change="resetPositionId" class="form-select" id="floatingSelect" aria-label="Floating label select example">
                      <option  value="0" >Pimpinan SKPD </option>
                      @foreach ($organization->divisions as $division)
                            <option value="{{ $division->id }}">{{ $division->name }}</option>
                      @endforeach
                    </select>
                    <label for="floatingSelect">Pilih Bidang / Bagian</label>
                </div>
                <div wire:loading wire:target="divisionId">
                    <div class="spinner-grow spinner-grow-sm" role="status">
                        <span class="visually-hidden">Loading...</span>
                        <span class="visually-hidden">Loading...</span>
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div> --}}
                {{-- <div class="form-floating mb-3">
                    <select wire:model="positionId" wire:loading.remove wire:target="divisionId" class="form-select" id="floatingSelect" aria-label="Floating label select example">
                        <optgroup  label="---------------------------------------------------">
                            <option  value="0" selected >Tanpa Jabatan</option>
                        </optgroup>
                        @foreach ($positions->sortBy('name') as $position)
                            <optgroup class="m-0" label="---------------------------------------------------">
                                <option value="{{ $position->id }}" {{ ($position->users->count() > 0 && $position->is_staff == 0) ?'disabled':'' }}>{{ $position->name }}
                                   @foreach ($position->users as $user)
                                        <option value="" disabled class=" fst-italic">- {{ $user->name }}</option> 
                                    @endforeach
                                </option>  
                            </optgroup>
                        @endforeach
                    </select>
                    <label for="floatingSelect">Pilih Jabatan</label>
                </div>
                {{ $divisionId }}
                {{ $positionId }} --}}
                <div class="form-check form-switch">
                    <input wire:model="userIsPlt" class="form-check-input" type="checkbox" id="flexSwitchCheckDefault">
                    <label class="form-check-label" for="flexSwitchCheckDefault">Status PLT</label>
                </div>
                <button 
                    wire:click="updateUser({{ $userId }})" 
                    type="submit" 
                    class="btn btn-primary mt-3" 
                    data-bs-dismiss="modal" 
                    {{-- {{ $disabled == true ? 'disabled' :'' }} --}}
                >
                    <i class="bi bi-save"></i>
                    Simpan
                </button>
            </div>
        </div>
    </div>
</div> 