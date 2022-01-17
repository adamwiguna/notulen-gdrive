<div wire:ignore.self  class="modal fade" id="createDivisionModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            
            <div wire:loading wire:target="getOrganization, createDivision">
                <div class="d-flex justify-content-center">
                    <div class="spinner-border" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            </div>
            <div  wire:loading.remove wire:target="getOrganization, createDivision" class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Form Create Bidang/Bagian pada "{{ $organizationName }}" </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
               
            </div>
            <div  wire:loading.remove wire:target="getOrganization, createDivision" class="modal-body">
                @if (session()->has('message'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>
                        {{ session('message') }} aaaaa
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                 @endif
                <div class="form-floating mb-3">
                    <input wire:model="divisionName" type="text" class="form-control  @error('divisionName') is-invalid @enderror" id="floatingName" placeholder="name">
                    <label for="floatingName">Nama Bidang / Bagian</label>
                    @error('divisionName')
                      <span class="invalid-feedback">
                          <strong>{{ $message }}</strong>
                      </span>
                    @enderror
                </div>
                <div class="form-floating mb-3">
                    <input wire:model="divisionAlias" type="text" class="form-control @error('divisionAlias') is-invalid @enderror" id="floatingAlias" placeholder="Alias">
                    <label for="floatingAlias">Singakatan Bidang / Alias</label>
                    @error('divisionAlias')
                    <span class="invalid-feedback">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div> 
                <button wire:click="storeDivision({{ $getOrganization}})" type="submit" class="btn btn-primary" >
                    <i class="bi bi-save"></i>
                    Simpan
                </button>
            </div>
        </div>
    </div>
</div> 