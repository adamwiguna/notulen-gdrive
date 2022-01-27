<?php

namespace App\Http\Livewire\Admin\Organization;

use Livewire\Component;
use App\Models\Position;
use App\Models\Organization;
use Livewire\WithPagination;

class ListPosition extends Component
{
    public Organization $getOrganization;
    public Division $getDivision;
    public $organizationId;
    public $organizationName;
    public $organizationAlias;

    public $positionId;
    public $positionName;
    public $positionAlias;
    public $divisionId;
    public $positionIsStaff = false;
    public $positionCanViewOrganization = false;
    public $positionCanViewDivision = true;
    public $positionCanShare = false;
    public $positionCanViewShared = false;

    public $disabled;
    
    public $organization;
    
    
    use WithPagination;
    public $cari;
    public $perPage = 25;
    protected $paginationTheme = 'bootstrap';
    public $free = false;
    public $canShare = false;
    public $canReceive = false;
    protected $queryString = [
        'cari', 
        'canShare', 
        'canReceive', 
        'perPage', 
        'free',
    ];

    private $positionModel;

    protected $rules = [
        'positionName' => 'required|max:100',
        'positionAlias' => 'required|max:100',
    ];

    protected $messages = [
        'positionName.required' => 'Tidak Boleh Kosong',
        'positionAlias.required' => 'Tidak Boleh Kosong - Bisa Disamakan',
    ];

    public function updated($propertyName)
    {
        $this->disabled = true;
        $this->validateOnly($propertyName);

        $validated = $this->validate(); //shows all errors
        $this->disabled = false;
    }


    public function updatingCari()
    {
        $this->resetPage();
    }

    public function render()
    {
       
        $this->positionModel = Position::where('id', '>', 0);
        if($this->organization instanceof Organization){
            $this->getOrganization = $this->organization;
            $this->organizationId = $this->organization->id;
            $this->organizationName = $this->organization->name;
            $this->organizationAlias = $this->organization->alias;
            $this->positionModel->where('organization_id', $this->organization->id);
            if (auth()->user()->division_id) {
                $this->positionModel->where('division_id',auth()->user()->division_id);                
            }
        }

        if ($this->canShare == true) {
            $this->positionModel->where('can_share_note', 1);
        }
        if ($this->canReceive == true) {
            $this->positionModel->where('can_view_shared_note', 1);
        }
        if ($this->free == true) {
            $this->positionModel->whereDoesntHave('users');
        }


        if ($this->cari) {
            $this->positionModel->where(function($query){
                                            $query->where('name', 'like', '%'. $this->cari.'%')
                                                    ->orWhere('alias', 'like', '%'. $this->cari.'%');
                                        }
            );
        }

        return view('livewire.admin.organization.list-position', [
            'positions' => $this->positionModel->latest()->paginate($this->perPage),
        ]);
    }

    public function createPosition()
    {
        $this->resetValidation();
        $this->positionName = null;
        $this->positionAlias = null;
        $this->divisionId = null;
        $this->positionIsStaff = false;
        $this->positionCanViewOrganization = false;
        $this->positionCanViewDivision = true;
        $this->positionCanShare = false;
        $this->positionCanViewShared = false;
    }

    public function storePosition()
    {
        $this->validate([
            'positionName' => 'required|max:100',
            'positionAlias' => 'required|max:100',
            // 'divisionId' => 'nullable',
        ]);

        $position = Position::create([
            'name' => $this->positionName,
            'alias' =>  $this->positionAlias,
            // 'division_id' =>  $this->divisionId,
            'organization_id' =>  $this->organizationId,
            // 'can_view_note_in_division' =>  $this->positionCanViewDivision,
            // 'can_view_note_in_organization' =>  $this->positionCanViewOrganization,
            'can_share_note' =>  $this->positionCanShare,
            'can_view_shared_note' =>  $this->positionCanViewShared,
            'is_staff' =>  $this->positionIsStaff,
        ]);



        session()->flash('message' , $position['name'].' berhasil ditambahkan pada '. $this->organization->name);

        // return redirect()->route('admin.organization.show', ['organization' => $this->organization]);
    }

    public function getPosition(Position $position)
    {
        $this->resetValidation();
        $this->positionId = $position->id;
        $this->positionName = $position->name;
        $this->positionAlias = $position->alias;
        $this->divisionId = $position->division_id;
        $this->positionCanViewDivision = $position->can_view_note_in_division;
        $this->positionCanViewOrganization = $position->can_view_note_in_organization;
        $this->positionCanShare = $position->can_share_note;
        $this->positionCanViewShared = $position->can_view_shared_note;
        $this->positionIsStaff= $position->is_staff;
    }

    public function updatePosition($id)
    {
        $this->validate([
            'positionName' => 'required|max:100',
            'positionAlias' => 'required|max:100',
            // 'divisionId' => 'nullable',
        ]);

        $position = Position::where('id', $id);
        $position->update([
            'name' => $this->positionName,
            'alias' =>  $this->positionAlias,
            // 'division_id' =>  $this->divisionId,
            'organization_id' =>  $this->organizationId,
            // 'can_view_note_in_division' =>  $this->positionCanViewDivision,
            // 'can_view_note_in_organization' =>  $this->positionCanViewOrganization,
            'can_share_note' =>  $this->positionCanShare,
            'can_view_shared_note' =>  $this->positionCanViewShared,
            'is_staff' =>  $this->positionIsStaff,
        ]);
        
        session()->flash('message' , 'Jabatan berhasil diubah pada '. $this->organization->name);
    }

    public function destroyPosition($id)
    {
        if ($id) {
            session()->flash('message' , 'Jabatan berhasil dihapus');
            Position::where('id', $id)->delete();
        }
    }
}
