<?php

namespace App\Http\Livewire\Operator\Position;

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

    public $username;

    private $positionUsers;

    // CRUD untuk Position 
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

    public function render()
    {
        $positionModel = Position::where('organization_id', auth()->user()->organization_id)->latest();
        $this->positionUsers = User::latest();

        $this->organizationId = auth()->user()->organization_id;

        return view('livewire.operator.position.index-position', [
            'positions' => $positionModel->paginate($this->perPage),
            'organizations' => Organization::orderBy('name', 'asc')->get(),
            'divisions' => Division::orderBy('name', 'asc')->get(),
            'users' => User::orderBy('name', 'asc')->get(),
        ]);
    }
}
