<div wire:ignore.self class="modal fade" id="deleteOrganizationModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                    <h5 class="modal-title" id="exampleModalLabel">Ingin menghapus "{{ $organizationName }}"?</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">Pilih "Hapus" dibawah jika ingin menghapus data diatas</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button"  data-bs-dismiss="modal">Cancel</button>
                    <button wire:click="destroyOrganization({{ $organizationId }})" class="btn btn-danger text-white"  data-bs-dismiss="modal">Hapus</button>
                </div>
            </div>
        </div>
    </div>
</div>