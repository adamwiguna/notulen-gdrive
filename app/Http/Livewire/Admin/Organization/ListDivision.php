<?php

namespace App\Http\Livewire\Admin\Organization;

use Livewire\Component;
use App\Models\Division;
use App\Models\Organization;
use Livewire\WithPagination;

class ListDivision extends Component
{
    use WithPagination;

    public Organization $getOrganization;
    public Division $getDivision;
    public $organizationId;
    public $organizationName;
    public $organizationAlias;

    public $divisionName;
    public $divisionAlias;

    public $organization;

    public $perPage;
    public $cari;

    private $modelDivision;

    protected $rules = [
        'divisionName' => 'required|max:100',
        'divisionAlias' => 'required|max:100'
    ];
 

    public function render()
    {
        $this->modelDivision = Division::where('id', '>', 0);
        if($this->organization instanceof Organization){
            $this->getOrganization = $this->organization;
            $this->organizationId = $this->organization->id;
            $this->organizationName = $this->organization->name;
            $this->organizationAlias = $this->organization->alias;
            $this->modelDivision->where('organization_id', $this->organization->id);
            if (auth()->user()->division_id) {
                $this->modelDivision->where('id', auth()->user()->division_id);
            }
        }

        if ($this->cari) {
            $this->modelDivision->where(function($query){
                                            $query->where('name', 'like', '%'. $this->cari.'%')
                                            ->orWhere('alias', 'like', '%'. $this->cari.'%');
                                        }
            );  
        }

        return view('livewire.admin.organization.list-division', [
            'divisions' => $this->modelDivision->paginate(),
        ]);
    }

    public function updated($divisionName, $divisionAlias)
    {
        $this->validateOnly($divisionName);
        $this->validateOnly($divisionAlias);
    }

    public function getDivision(Division $division)
    {
        $this->getDivision = $division;
        $this->divisionName = $division->name;
        $this->divisionAlias= $division->alias;
    }

    public function createDivision()
    {
        $this->getDivision = new Division;
        $this->divisionName = null;
        $this->divisionAlias= null;
    }

    public function destroyDivision(Division $division)
    {
        if ($division) {
            session()->flash('message' , 'Data berhasil dihapus');
            $division->delete();
        }
        $this->getDivision = new Division;
        $this->divisionName = null;
        $this->divisionAlias= null;


        // return redirect()->route('admin.organization.show', ['organization' => $this->organization]);
    }


    public function storeDivision(Organization $organization)
    {
        $this->validate([
            'divisionName' => 'required|max:100',
            'divisionAlias' => 'required|max:100'
        ]);

        $division = Division::create([
            'name' => $this->divisionName,
            'alias' =>  $this->divisionAlias,
            'organization_id' =>  $organization->id,
        ]);

        $this->divisionName = null;
        $this->divisionAlias = null;

        session()->flash('message' , $division['name'].' ('.$division['alias'].') berhasil ditambahkan pada '. $organization->name);

        $this->getDivision = new Division;
        $this->divisionName = null;
        $this->divisionAlias= null;

        // return redirect()->route('admin.organization.show', ['organization' => $organization]);
    }

    public function updateDivision(Division $division, Organization $organization)
    {
        $this->validate([
            'divisionName' => 'required|max:100',
            'divisionAlias' => 'required|max:100'
        ]);

        if ($division) {
            $division->update([
                'name' => $this->divisionName,
                'alias' => $this->divisionAlias,
                'organization_id' => $organization->id,
            ]);

            session()->flash('message' , $division['name'].' ('.$organization['alias'].') berhasil diupdate');

            // return redirect()->route('admin.organization.show', ['organization' => $organization]);
            $this->getDivision = new Division;
            $this->divisionName = null;
            $this->divisionAlias= null;
    
        }
    }
}
