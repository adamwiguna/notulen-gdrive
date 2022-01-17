<div wire:ignore.self  class="modal fade" id="createPositionModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div wire:loading wire:target="createPosition, getPosition">
                <div class="d-flex justify-content-center">
                    <div class="spinner-border" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            </div>
            <div  wire:loading.remove wire:target="createPosition, getPosition" class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Form Create Jabatan pada "{{ $organizationName }}" </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div  wire:loading.remove wire:target="createPosition, getPosition" class="modal-body">
                <div class="form-floating mb-3">
                    <input wire:model="positionName" type="text" class="form-control  @error('positionName') is-invalid @enderror" id="floatingName" placeholder="name">
                    <label for="floatingName">Nama Jabatan</label>
                    @error('positionName')
                      <span class="invalid-feedback">
                          <strong>{{ $message }}</strong>
                      </span>
                    @enderror
                </div>
                <div class="form-floating mb-3">
                    <input wire:model="positionAlias" type="text" class="form-control @error('positionAlias') is-invalid @enderror" id="floatingAlias" placeholder="Alias">
                    <label for="floatingAlias">Singakatan / Alias</label>
                    @error('positionAlias')
                    <span class="invalid-feedback">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                {{-- {{ $divisionId }} 
                {{ $positionId }}  --}}
                {{-- <div class="form-floating mb-3">
                    <select wire:model="divisionId" class="form-select" id="floatingSelect" aria-label="Floating label select example">
                      <option  value="0">Diluar Bidang </option>
                      @foreach ($organization->divisions as $division)
                            <option value="{{ $division->id }}">{{ $division->name }}</option>
                      @endforeach
                    </select>
                    <label for="floatingSelect">Pilih Bidang / Bagian</label>
                </div> --}}
                <div class="form-check form-switch">
                    <input wire:model="positionIsStaff" class="form-check-input" type="checkbox" id="flexSwitchCheckDefault">
                    <label class="form-check-label" for="flexSwitchCheckDefault">Struktur/Posisi STAFF</label>
                </div>
                {{-- {{ $positionIsStaff }} --}}
                <br>
                <small class=" text-dark fw-bolder mt-5 mb-3 text-decoration-underline">Hak Akses Notulen</small> <br>
                {{-- <hr class="mt-0 mb-3"> --}}
                <small class="text-danger mt-5">Khusus Kepala Instansi</small>
                <hr class="my-0">
                <div class="form-check form-switch">
                    <input wire:model="positionCanShare" class="form-check-input" type="checkbox" id="flexSwitchCheckDefault">
                    <label class="form-check-label" for="flexSwitchCheckDefault">Dapat membagikan Notulen keluar Instansi</label>
                </div>
                <small class="text-danger mt-5">Khusus Sekda dan Assisten</small>
                <hr class="my-0">
                <div class="form-check form-switch">
                    <input wire:model="positionCanViewShared" class="form-check-input" type="checkbox" id="flexSwitchCheckDefault">
                    <label class="form-check-label" for="flexSwitchCheckDefault">Dapat menerima Notulen dari luar Instansi</label>
                </div>
                <button 
                    wire:click="storePosition" 
                    type="submit" 
                    class="btn btn-primary mt-3" 
                    data-bs-dismiss="modal"
                    {{ $disabled == true ? 'disabled' :'' }}
                >
                    <i class="bi bi-save"></i>
                    Simpan
                    {{-- <i wire:loading='' wire:target='' class="bi bi-save"> --}}
                </button>
            </div>
        </div>
    </div>
</div> 