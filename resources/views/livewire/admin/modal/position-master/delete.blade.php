<div wire:ignore.self class="modal fade" id="deletePositionMasterModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div wire:loading  wire:target="createPositionMaster, getPositionMaster">
                <div class="d-flex justify-content-center">
                    <div class="spinner-border" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            </div>
            <div wire:loading.remove  wire:target="createPositionMaster, getPositionMaster" class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ingin menghapus "{{ $positionName }}"?</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div wire:loading.remove  wire:target="createPositionMaster, getPositionMaster" class="modal-body">
                Jabatan ini dipegang oleh : <br>
                @forelse ($users->where('position_id', $positionId) as $user)
                   - {{ $user->name }} <br>
                @empty
                    Tidak ada
                @endforelse
            </div>
            <div wire:loading.remove  wire:target="createPositionMaster, getPositionMaster" class="modal-footer">
                <button class="btn btn-secondary" type="button"  data-bs-dismiss="modal">Cancel</button>
                <button wire:click="destroyPositionMaster({{ $positionId }})" class="btn btn-danger text-white"  data-bs-dismiss="modal">Hapus</button>
            </div>
        </div>
    </div>
</div>