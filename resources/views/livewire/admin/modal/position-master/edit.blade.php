<div wire:ignore.self  class="modal fade" id="editPositionMasterModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div wire:loading wire:target="createPositionMaster, getPositionMaster">
                <div class="d-flex justify-content-center">
                    <div class="spinner-border" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            </div>
            <div  wire:loading.remove wire:target="createPositionMaster, getPositionMaster" class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Form Create User  </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div  wire:loading.remove wire:target="createPositionMaster, getPositionMaster" class="modal-body">
                <div class="form-floating mb-3">
                    <input wire:model="positionName" type="text" class="form-control  @error('positionName') is-invalid @enderror" id="floatingName" placeholder="name">
                    <label for="floatingName">Nama</label>
                    @error('positionName')
                      <span class="invalid-feedback">
                          <strong>{{ $message }}</strong>
                      </span>
                    @enderror
                </div>
                <div class="form-floating mb-3">
                    <input wire:model="positionAlias" type="text" class="form-control  @error('positionAlias') is-invalid @enderror" id="floatingName" placeholder="name">
                    <label for="floatingName">Singkatan / Alias</label>
                    @error('positionAlias')
                      <span class="invalid-feedback">
                          <strong>{{ $message }}</strong>
                      </span>
                    @enderror
                </div>
                <div class="form-check form-switch mb-5">
                    <input wire:model="positionIsStaff" class="form-check-input " type="checkbox" id="flexSwitchCheckDefault">
                    <label class="form-check-label" for="flexSwitchCheckDefault">Jabatan Staff</label>
                </div>

                <small class=" text-dark fw-bolder mt-5">Hak Akses Notulen</small>
                <hr class="my-0">
                <div class="form-check form-switch">
                    <input wire:model="canViewNoteInDivision" class="form-check-input" type="checkbox" id="flexSwitchCheckDefault">
                    <label class="form-check-label" for="flexSwitchCheckDefault">Dapat melihat semua Notulen pada lingkup Bidang/Bagian</label>
                </div>
                <small class="text-danger mt-5">Khusus Kepala SKPD</small>
                <hr class="my-0">
                <div class="form-check form-switch">
                    <input wire:model="canViewNoteInOrganization" class="form-check-input" type="checkbox" id="flexSwitchCheckDefault">
                    <label class="form-check-label" for="flexSwitchCheckDefault">Dapat melihat semua Notulen pada lingkup SKPD</label>
                </div>
                <div class="form-check form-switch">
                    <input wire:model="canShareNote" class="form-check-input" type="checkbox" id="flexSwitchCheckDefault">
                    <label class="form-check-label" for="flexSwitchCheckDefault">Dapat membagikan Notulen</label>
                </div>
                <small class="text-danger mt-5">Khusus Sekda dan Assisten</small>
                <hr class="my-0">
                <div class="form-check form-switch">
                    <input wire:model="canViewSharedNote" class="form-check-input" type="checkbox" id="flexSwitchCheckDefault">
                    <label class="form-check-label" for="flexSwitchCheckDefault">Dapat melihat Notulen yang dibagikan</label>
                </div>
                <div class="form-group mt-5">
                    <label for="">Posisi Jabatan</label>
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
                   
                <button wire:click="updatePositionMaster({{ $positionId }})" type="submit" class="btn btn-primary mt-3" data-bs-dismiss="modal" >
                    <i class="bi bi-save"></i>
                    Simpan
                </button>
            </div>
        </div>
    </div>
</div> 