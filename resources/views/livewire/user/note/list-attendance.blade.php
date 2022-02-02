<div>
    @can('manage-this-note', $note)
    <div wire:ignore.self class="input-group input-group-sm small mb-3">
        <input wire:model.defer="attendanceName" type="text" aria-label="First name" class="form-control form-control-sm" placeholder="Nama">
        <input wire:model.defer="attendancePosition" type="text" aria-label="Last name" class="form-control form-control-sm" placeholder="Jabatan">
        <input wire:model.defer="attendanceOrganization" type="text" aria-label="Last name" class="form-control form-control-sm" placeholder="Instansi">
        <button wire:click.defer="storeAttendance({{ $note->id }})" class="btn btn-sm btn-success" >
            <i class="bi bi-plus-square"></i>
        </button>
    </div>
    @endcan
    @if (session()->has('message-attendance'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('message-attendance') }} 
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <div class="overflow-auto"  style="aspect-ratio: 8/5;">
    <table class="table mx-1 small table-sm">
        <thead>
            <tr>
                <th scope="col">No</th>
                <th scope="col">Nama</th>
                <th scope="col">Jabatan</th>
                <th scope="col">Instansi</th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
            @forelse ($attendances as $attendance)
                <tr>
                    <th scope="row">{{ $loop->iteration }}</th>
                    <td>{{ $attendance->name }}</td>
                    <td>{{ $attendance->position }}</td>
                    <td>{{ $attendance->organization }}</td>
                    <td>
                        <button class="btn btn-danger btn-sm small py-0 px-1" data-bs-toggle="modal" data-bs-target="#exampleModalDelete{{ $attendance->id }}">
                            <i class="bi bi-trash"></i>
                        </button>
                    </td>
                </tr>
                <!-- Modal Delete Note -->
                <div class="modal fade " id="exampleModalDelete{{ $attendance->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Anda Yakin?</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                Hapus Kehadiran "{{ $attendance->name }}"
                            </div>
                            <div class="modal-footer ">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                <button wire:click="deleteAttendance({{ $attendance->id }})" class="btn btn-danger d-block" data-bs-dismiss="modal"><i class="bi bi-trash-fill"></i> Hapus</button>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <tr>
                    <td colspan="5">Tidak Ada Data</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    </div>
</div>
