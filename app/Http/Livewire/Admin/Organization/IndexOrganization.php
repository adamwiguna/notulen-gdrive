<?php

namespace App\Http\Livewire\Admin\Organization;

use App\Models\User;
use Livewire\Component;
use App\Models\Division;
use App\Models\Position;
use Illuminate\Support\Str;
use App\Models\Organization;
use Livewire\WithPagination;

class IndexOrganization extends Component
{
    use WithPagination;

    public $cari;
    public $perPage = 10;
    protected $paginationTheme = 'bootstrap';

    // variable untuk menampilkan data Oraganisasi pada Modal Edit Organisasi
    // public Organization $organization;
    public Organization $getOrganization;
    public $organizationId;
    public $organizationName;
    public $organizationAlias;

    // Variable untuk  data Bidang/Bagian/Division
    public Division $getDivision;
    public $divisionId;
    public $divisionName;
    public $divisionAlias;
    public $selectDivisions;

    // Variable untuk store data Operator
    public User $getOperator;
    public $operatorId;
    public $operatorUsername;
    public $operatorPassword;

    // Variable untuk edit data Operator
    public $editOperatorUsername;
    public $editOperatorPassword;


    public function render()
    {
        $organizationModel = Organization::latest();

        if ($this->cari) {
            $organizationModel->where('name', 'like', '%'. $this->cari.'%')
                                ->orWhere('alias', 'like', '%'. $this->cari.'%');
        }

        return view('livewire.admin.organization.index-organization', [
            'organizations' => $organizationModel->paginate($this->perPage),
            'divisions' => Division::where('organization_id', $this->organizationId)->get(),
        ]);
    }

    public function updatingCari()
    {
        $this->resetPage();
    }

    public function destroyOrganization($id)
    {
        if ($id) {
            $organization = Organization::find($id);
            session()->flash('message' , $organization['name'].' ('.$organization['alias'].') berhasil dihapus');
            $organization->delete();

            $operator = User::where('organization_id', $id)->where('is_operator', true);
            $operator->delete();

            Division::where('organization_id', $id)->delete();
            Position::where('organization_id', $id)->delete();
            User::where('organization_id', $id)->update([
                'position_id' => null,
                'organization_id' => null,
                'is_plt' => false,
            ]);
        }

        $this->organizationId = null;
        $this->organizationName = null;
        $this->organizationAlias = null;
        return redirect()->route('admin.organization.index');
    }

    public function showOrganization($id)
    {
        $organization = Organization::find($id);
        $this->organizationName = $organization['name'];
        $this->organizationAlias = $organization['alias'];
    }

    public function getOrganization(Organization $organization)
    {
        $this->resetOperator();

        $this->getDivision = new Division;
        $this->divisionName = null;
        $this->divisionAlias = null;
        $this->divisionId = null;

        $this->getOrganization = new Organization;
        $this->organizationId = null;
        $this->organizationName = null;
        $this->organizationAlias = null;

        $this->getOrganization = $organization;
        $this->organizationId = $organization->id;
        $this->organizationName = $organization['name'];
        $this->organizationAlias = $organization['alias'];
    }


    public function update($id)
    {
        $this->validate([
            'organizationName' => 'required|max:100',
            'organizationAlias' => 'required|max:100'
        ]);

        if ($id) {
            $organization = Organization::find($id);
            $organization->update([
                'name' => $this->organizationName,
                'alias' => $this->organizationAlias,
            ]);

            session()->flash('message' , $organization['name'].' ('.$organization['alias'].') berhasil diupdate');

            return redirect()->route('admin.organization.index');
        }
    }

    public function resetOperator()
    {
        $this->operatorId = null;
        $this->operatorUsername = null;
        $this->operatorPassword = null;
    }

    public function getOperator(User $operator, Organization $organization)
    {
        // $this->resetOperator();
        $this->divisionId = $operator->division_id;
        $this->getOperator = $operator;
        $this->getOrganization = $organization;
        $this->organizationId = $organization->id;
        $this->organizationName = $organization->name;
        $this->operatorId = $operator->id;
        $this->operatorUsername = $operator['email'];
    }

    public function destroyOperator(User $operator)
    {
        if ($operator) {
            session()->flash('message' , $operator['name'].' ('.$operator->organization->name.') berhasil dihapus');
            $operator->delete();
        }

        return redirect()->route('admin.organization.index');
    }

    public function showOperator(User $operator, Organization $organization)
    {
        $this->editOperatorUsername = $operator['email'];
        // dd($operator);
    }


    public function updateOperator(User $operator, Organization $organization)
    {
        $this->validate([
            'operatorUsername' => 'required|max:100',
            'operatorPassword' => 'nullable|max:100'
        ]);

        if ($operator) {
            $operator->update([
                'name' => $this->operatorUsername,
                'email' => $this->operatorUsername,
                'division_id' => is_int( $this->divisionId) ? $this->divisionId : null,
                // 'password' => bcrypt($this->operatorPassword),
                'is_operator' =>  true,
            ]);

            if ($this->operatorPassword !== null) {
                $operator->update([
                    'password' => bcrypt($this->operatorPassword),
                ]);
            }

            session()->flash('message' , 'Password '.$operator['name'].' ('.$organization['alias'].') berhasil diupdate');

            return redirect()->route('admin.organization.index');
        }
    }

    public function storeOperator($organizationId)
    {
        $this->validate([
            'operatorUsername' => 'required|max:100|unique:users,email',
            'operatorPassword' => 'required|max:100'
        ]);

        $operator = User::create([
            'name' => $this->operatorUsername,
            'slug' =>  $this->operatorUsername,
            'email' => $this->operatorUsername,
            'password' =>  bcrypt($this->operatorPassword),
            'division_id' =>  $this->divisionId,
            'organization_id' =>  $organizationId,
            'is_operator' =>  true,
        ]);

        $this->operatorUsername = null;
        $this->operatorPassword = null;

        session()->flash('message' , $operator['name'].' ('.$this->getOrganization['alias'].') berhasil ditambahkan');

        return redirect()->route('admin.organization.index');
    }

    public function getDivision(Division $division, Organization $organization)
    {
        // $this->resetOperator();
        $this->getDivision = $division;
        $this->getOrganization = $organization;
        $this->organizationName = $organization->name;
        $this->divisionName = $division->name;
        $this->divisionAlias= $division->alias;
    }

    public function destroyDivision(Division $division)
    {
        if ($division) {
            session()->flash('message' , $division['name'].' ('.$division->organization->name.') berhasil dihapus');
            $division->delete();
        }

        return redirect()->route('admin.organization.index');
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

        return redirect()->route('admin.organization.index');
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

            session()->flash('message' , 'Password '.$division['name'].' ('.$organization['alias'].') berhasil diupdate');

            return redirect()->route('admin.organization.index');
        }
    }

}
