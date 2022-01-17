<?php

namespace App\Http\Livewire\Admin\User;

use App\Models\User;
use Livewire\Component;
use App\Models\Division;
use App\Models\Position;
use Illuminate\Support\Str;
use App\Models\Organization;
use Livewire\WithPagination;

class IndexUser extends Component
{
    use WithPagination;

    public $cari;
    public $perPage = 10;
    protected $paginationTheme = 'bootstrap';
    protected $queryString = ['cari'];

    public $isOperator = false;
    public $isNotInOrganization = false;
    public $isNotHavePosition = false;
    public $isNotHavePositionButHaveOrganization = false;

    //variable untuk CRUD User Master
    public $userId;
    public $userNIP;
    public $userPassword;
    public $userName;
    public $userSlug;
    public $organizationId;
    public $divisionId;
    public $positionId;
    public $userIsPlt = false;


    public function render()
    {
        $userModel = User::latest();

        if ($this->isOperator == true) {
            $userModel->where(function ($query){
                $query->where('is_operator', true)
                        ->orWhere('is_admin', true);
            });
        } else {
            $userModel->where('is_operator', false);
            $userModel->where('is_admin', false);
        }

        if ($this->isNotInOrganization == true) {
            $userModel->where('organization_id', null);
        }

        if ($this->isNotHavePosition == true) {
            $userModel->where('position_id', null);
        }
        if ($this->isNotHavePositionButHaveOrganization == true) {
            $userModel->where('position_id', null);
            $userModel->where('organization_id','<>', null);
        }

        if ($this->cari) {
            $userModel->where('name', 'like', '%'. $this->cari.'%')
                        ->orWhere('email', 'like', '%'. $this->cari.'%')
                        ->orWhereHas('position', function ($query){
                            $query->where('name', 'like', '%'. $this->cari.'%');
                            $query->orWhere('alias', 'like', '%'. $this->cari.'%');
                        })
                        // ->orWhereHas('division', function ($query){
                        //     $query->where('name', 'like', '%'. $this->cari.'%');
                        //     $query->orWhere('alias', 'like', '%'. $this->cari.'%');
                        // })
                        ->orWhereHas('organization', function ($query){
                            $query->where('name', 'like', '%'. $this->cari.'%');
                            $query->orWhere('alias', 'like', '%'. $this->cari.'%');
                        });
        }


        return view('livewire.admin.user.index-user', [
            'users' => $userModel->paginate($this->perPage),
            'organizations' => Organization::orderBy('name', 'asc')->get(),
            'divisions' => Division::orderBy('name', 'asc')->get(),
            'positions' => Position::orderBy('name', 'asc')->get(),
        ]);
    }

    public function createUserMaster()
    {
        $this->reset([
            'userId',
            'userNIP',
            'userPassword',
            'userName',
            'userSlug',
            'organizationId',
            'divisionId',
            'positionId',
            'userIsPlt',
        ]);
    }

    public function resetDivsionAndPosition()
    {
        $this->divisionId = null;
        $this->positionId = null;
    }

    public function getUserMaster(User $user)
    {
        $this->userId = $user->id;
        $this->userNIP = $user->email;
        $this->userName = $user->name;
        $this->userSlug = $user->slug;
        $this->organizationId = $user->organization_id;
        $this->divisionId = $user->division_id;
        $this->positionId = $user->position_id;
        $this->userIsPlt = $user->id_plt;
    }

    public function mutasiRemove($userId)
    {
        User::find($userId)->update([
            'organization_id' => null,
            'division_id' => null,
            'position_id' => null,
            'is_plt' => false,
        ]);
        
        session()->flash('message' , 'Data User '.$this->userName.' telah dilepas struktur dan jabatannya');
    }

    public function destroyUserMaster($userId)
    {
        User::find($userId)->delete();
        
        session()->flash('message' , 'Data User '.$this->userName.' telah dihapus');

    }

    public function updateUserMaster($userId)
    {
        $this->validate([
            'userName' => 'required|max:100',
            'userPassword' => 'nullable|max:100',
            'organizationId' => 'nullable',
            'divisionId' => 'nullable',
            'positionId' => 'nullable',
        ]);

        $user = User::where('id', $userId);
        $user->update([
            'name' => $this->userName,
            'organization_id' =>  $this->organizationId == 0 ? null : $this->organizationId,
            // 'division_id' =>  $this->divisionId == 0 ? null : $this->divisionId,
            'position_id' =>  $this->positionId == 0 ? null : $this->positionId,
            'is_plt' =>  $this->userIsPlt == null ? false : $this->userIsPlt,
        ]);
        if ($this->userPassword !== null) {
            $user->update([
                'password' => bcrypt($this->userPassword),
            ]);
        }
        
        session()->flash('message' , 'Data User '.$this->userName.' berhasil diubah');
    }

    public function storeUserMaster()
    {
        $this->userSlug = Str::random(50);

        $this->validate([
            'userNIP' => 'required|max:100|unique:users,email',
            'userPassword' => 'required|max:100',
            'userName' => 'required|max:100',
            'userSlug' => 'required|max:100|unique:users,slug',
            'organizationId' => 'nullable',
            'divisionId' => 'nullable',
            'positionId' => 'nullable',
            'userIsPlt' => 'nullable',
        ]);

        $user = User::create([
            'email' => $this->userNIP,
            'password' =>  bcrypt($this->userPassword),
            'name' => $this->userName,
            'slug' =>  $this->userSlug,
            'organization_id' =>  $this->organizationId == 0 ? null : $this->organizationId,
            'division_id' =>  $this->divisionId == 0 ? null : $this->divisionId,
            'position_id' =>  $this->positionId == 0 ? null : $this->positionId,
            'is_plt' =>  $this->userIsPlt == null ? false : $this->userIsPlt,
        ]);

        $this->reset([
            'userNIP',
            'userPassword',
            'userName',
            'userSlug',
            'organizationId',
            'divisionId',
            'positionId',
            'userIsPlt',
        ]);

        session()->flash('message' , $user['name'].'  berhasil ditambahkan');

        return redirect()->route('admin.user.index');
    }
}
