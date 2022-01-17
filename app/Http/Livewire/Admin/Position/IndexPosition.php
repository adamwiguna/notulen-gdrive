<?php

namespace App\Http\Livewire\Admin\Position;

use auth;
use App\Models\User;
use Livewire\Component;
use App\Models\Division;
use App\Models\Position;
use App\Models\Organization;
use Livewire\WithPagination;

class IndexPosition extends Component
{
    use WithPagination;

    public $cari;
    public $perPage = 10;
    protected $paginationTheme = 'bootstrap';
    protected $queryString = [
        'cari',
        'canShare',
        'canReceive',
    ];

    public $username;

    private $positionUsers;

    // CRUD untuk Position Master
    public $positionId;
    public $positionName;
    public $positionAlias;
    public $positionIsStaff = false;
    public $divisionId;
    public $organizationId;
    public $canViewNoteInDivision = false;
    public $canViewNoteInOrganization = false;
    public $canShareNote = false;
    public $canViewSharedNote = false;

    public $canShare = false;
    public $canReceive = false;

    
    public function render()
    {
        $positionModel = Position::latest();
        $this->positionUsers = User::latest();

        if ($this->cari) {
            $positionModel->where('name', 'like', '%'. $this->cari.'%')
                        ->orWhere('alias', 'like', '%'. $this->cari.'%')
                        ->orWhereHas('users', function ($query){
                            $query->where('name', 'like', '%'. $this->cari.'%');
                        })
                        ->orWhereHas('organization', function ($query){
                            $query->where('name', 'like', '%'. $this->cari.'%');
                            $query->orWhere('alias', 'like', '%'. $this->cari.'%');
                        });
        }

        if ($this->canShare == true) {
            $positionModel->where('can_share_note', 1);
        }
        if ($this->canReceive == true) {
            $positionModel->where('can_view_shared_note', 1);
        }

        return view('livewire.admin.position.index-position', [
            'positions' => $positionModel->paginate($this->perPage),
            'organizations' => Organization::orderBy('name', 'asc')->get(),
            'divisions' => Division::orderBy('name', 'asc')->get(),
            'users' => User::orderBy('name', 'asc')->get(),
        ]);
    }

    public function resetDivsionAndPosition()
    {
        $this->divisionId = null;
        $this->positionId = null;
    }

    public function createPositionMaster()
    {
        $this->reset([
            'positionId',
            'positionName',
            'positionAlias',
            'positionIsStaff',
            'divisionId',
            'organizationId',
            'canViewNoteInDivision',
            'canViewNoteInOrganization',
            'canShareNote',
            'canViewSharedNote',
        ]);
    }

    public function storePositionMaster()
    {
        $this->validate([
            'positionName' => 'required|max:100',
            'positionAlias' => 'required|max:100',
            'positionIsStaff' => 'nullable',
            // 'divisionId' => 'required',
            'organizationId' => 'required',
            'canViewNoteInDivision' => 'nullable',
            'canViewNoteInOrganization' => 'nullable',
            'canShareNote' => 'nullable',
            'canViewSharedNote' => 'nullable',
        ]);        

        Position::create([
            'name' => $this->positionName,
            'alias' => $this->positionAlias,
            'is_staff' => $this->positionIsStaff,
            'organization_id' => $this->organizationId,
            // 'division_id' => $this->divisionId,
            'can_view_note_in_division' => $this->canViewNoteInDivision,
            'can_view_note_in_organization' => $this->canViewNoteInOrganization,
            'can_share_note' => $this->canShareNote,
            'can_view_shared_note' => $this->canViewSharedNote,
        ]);

        session()->flash('message' , 'Jabatan '.$this->positionName.' berhasil ditambahkan');

        $this->reset([
            'positionId',
            'positionName',
            'positionAlias',
            'positionIsStaff',
            'divisionId',
            'organizationId',
            'canViewNoteInDivision',
            'canViewNoteInOrganization',
            'canShareNote',
            'canViewSharedNote',
        ]);
    }

    public function getPositionMaster(Position $position)
    {
        $this->positionId = $position->id;
        $this->positionName = $position->name;
        $this->positionAlias = $position->alias;
        $this->positionIsStaff = $position->is_staff;
        $this->divisionId = $position->division_id;
        $this->organizationId = $position->organization_id;
        $this->canViewNoteInDivision = $position->can_view_note_in_division;
        $this->canViewNoteInOrganization = $position->can_view_note_in_organization;
        $this->canShareNote = $position->can_share_note;
        $this->canViewSharedNote = $position->can_view_shared_note;
        // $this->positionUsers->where('position_id', $position->id);
    }

    public function destroyPositionMaster($positionId)
    {
        $users = User::where('position_id', $positionId)
        ->update([
            'position_id' => null,
            'division_id' => null,
            'organization_id' => null,
            'is_plt' => false,
        ]);
        Position::find($positionId)->delete();
        
        session()->flash('message' , 'Jabatan '.$this->positionName.' telah dihapus user tersebut telah dihilangkan jabatan dan strukturnya');
    }

    public function updatePositionMaster($positionId)
    {
        $this->validate([
            'positionName' => 'required|max:100',
            'positionAlias' => 'required|max:100',
            'positionIsStaff' => 'nullable',
            // 'divisionId' => 'required',
            'organizationId' => 'required',
            'canViewNoteInDivision' => 'nullable',
            'canViewNoteInOrganization' => 'nullable',
            'canShareNote' => 'nullable',
            'canViewSharedNote' => 'nullable',
        ]);        

        Position::find($positionId)->update([
            'name' => $this->positionName,
            'alias' => $this->positionAlias,
            'is_staff' => $this->positionIsStaff,
            'organization_id' => $this->organizationId,
            // 'division_id' => $this->divisionId,
            'can_view_note_in_division' => $this->canViewNoteInDivision,
            'can_view_note_in_organization' => $this->canViewNoteInOrganization,
            'can_share_note' => $this->canShareNote,
            'can_view_shared_note' => $this->canViewSharedNote,
        ]);

        session()->flash('message' , 'Jabatan '.$this->positionName.' berhasil di-edit');

        $this->reset([
            'positionId',
            'positionName',
            'positionAlias',
            'positionIsStaff',
            'divisionId',
            'organizationId',
            'canViewNoteInDivision',
            'canViewNoteInOrganization',
            'canShareNote',
            'canViewSharedNote',
        ]);
    }
}
