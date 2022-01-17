<div wire:ignore.self class="modal fade" id="editOperatorModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div wire:loading wire:target="getOperator">
                <div class="d-flex justify-content-center">
                    <div class="spinner-border" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            </div>
            <div wire:loading.remove wire:target="getOperator">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Form Edit "{{ $operatorUsername}}" pada "{{ $organizationName }}"?</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-floating mb-3">
                        <input disabled wire:model="operatorUsername" type="text" class="form-control  @error('operatorUsername') is-invalid @enderror" id="floatingName" placeholder="name">
                        <label for="floatingName">Username</label>
                        @error('operatorUsername')
                        <span class="invalid-feedback">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-floating mb-3">
                        <input wire:model="operatorPassword" type="text" class="form-control @error('operatorPassword') is-invalid @enderror" id="floatingAlias" placeholder="Alias">
                        <label for="floatingAlias">Password</label>
                        @error('operatorPassword')
                        <span class="invalid-feedback">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div> 
                    <div class="form-floating mb-3">
                        <select wire:model="divisionId" class="form-select" id="floatingSelect" aria-label="Floating label select example">
                            <option value="null" >{{ $organizationName}}</option>
                            @foreach ($divisions as $division)
                                <option value="{{ $division->id }}">{{ $division->name }}</option>
                            @endforeach
                        </select>
                        <label for="floatingSelect">Operator Untuk</label>
                    </div>
                    <button wire:click="updateOperator({{ $getOperator}}, {{ $getOrganization }})" type="submit" class="btn btn-primary" >
                        <i class="bi bi-save"></i>
                        Simpan
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>