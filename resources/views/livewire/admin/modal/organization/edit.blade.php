<div wire:ignore.self class="modal fade" id="editOrganizationModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div wire:loading wire:target="getOrganization">
                <div class="d-flex justify-content-center">
                    <div class="spinner-border" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            </div>
            <div wire:loading.remove wire:target="getOrganization">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Form Edit "{{ $organizationName }}"?</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-floating mb-3">
                        <input wire:model="organizationName" type="text" class="form-control  @error('organizationName') is-invalid @enderror" id="floatingName" placeholder="name">
                        <label for="floatingName">Nama SKPD</label>
                        @error('organizationName')
                        <span class="invalid-feedback">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-floating mb-3">
                        <input wire:model="organizationAlias" type="text" class="form-control @error('organizationAlias') is-invalid @enderror" id="floatingAlias" placeholder="Alias">
                        <label for="floatingAlias">Singkatan Nama SKPD/ Alias </label>
                        @error('organizationAlias')
                        <span class="invalid-feedback">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div> 
                    <button wire:click="update({{ $organizationId }})" type="submit" class="btn btn-primary">
                        <i class="bi bi-save"></i>
                        Update
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>