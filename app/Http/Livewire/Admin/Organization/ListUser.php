<?php

namespace App\Http\Livewire\Admin\Organization;

use App\Models\User;
use Livewire\Component;
use App\Models\Position;
use Illuminate\Support\Str;
use App\Models\Organization;
use Livewire\WithPagination;
use App\Models\NoteDistribution;

class ListUser extends Component
{
    public $sidebar;

    public Organization $getOrganization;
    public $organization;
    public $organizationId;
    public $organizationName;
    public $organizationAlias;
    
    public Division $getDivision;
    public $divisionId;


    public $positionId;
    public $positionName;
    public $positionAlias;
    private $positionModel;

    public User $user;
    public $userId;
    public $userNIP;
    public $userPassword;
    public $userName;
    public $userSlug;
    public $userIsPlt = false;
    public $newPassword;


    use WithPagination;

    public $cari;
    public $isNotHavePosition = false;
    public $isMutasi = false;
    public $perPage = 25;
    protected $paginationTheme = 'bootstrap';

    private $userModel;

    public $disabled = true;

    protected $queryString = [
        'cari', 
        'isNotHavePosition', 
        'isMutasi', 
        'perPage', 
        'disabled', 
    ];

    // protected $rules = [
    //     'userNIP' => 'required|max:100|unique:users,email',
    //     'userPassword' => 'required|max:200',
    //     'userName' => 'required|max:100',
    //     'userSlug' => 'required|max:100|unique:users,slug',
    //     'positionId' => 'nullable',
    // ];

    protected function rules()
    {
        return [
            'userNIP' => 'required|max:100|unique:users,email,'.$this->userId,
            'userPassword' => 'required|max:200',
            'userName' => 'required|max:100',
            'userSlug' => 'required|max:100|unique:users,slug,'.$this->userId,
            'positionId' => 'nullable',
        ];
    }

    protected $messages = [
        'userNIP.required' => 'Tidak Boleh Kosong',
        'userNIP.unique' => 'NIP sudah Ada',
        'userPassword.required' => 'Tidak Boleh Kosong ',
        'userName.required' => 'Tidak Boleh Kosong ',
        'userSlug.required' => 'Tidak Boleh Kosong ',
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

    public function updatingIsNotHavePosition()
    {
        $this->resetPage();
    }

    public function updatingIsMutasi()
    {
        $this->resetPage();
    }

    public function render()
    {
        // dd($this->sidebar);
        $this->userModel = User::where('id', '>', 0)->where('is_operator', false)->where('is_admin', false);
        if($this->organization instanceof Organization){
            $this->getOrganization = $this->organization;
            $this->organizationId = $this->organization->id;
            $this->organizationName = $this->organization->name;
            $this->organizationAlias = $this->organization->alias;
            $this->userModel->where('organization_id', $this->organization->id);
            if (auth()->user()->division_id) {
                $this->userModel->where('division_id', auth()->user()->division_id);
            }
        }
        // if ($this->sidebar == 'mutasi') {
        //     $this->userModel = User::where('id', '>', 0)->where('is_operator', false)->where('is_admin', false);
        //     $this->userModel->where('organization_id', null);
        // }

        
        if ($this->isMutasi == true) {
            $this->userModel = User::where('id', '>', 0)->where('is_operator', false)->where('is_admin', false);
            $this->userModel->where('organization_id', null);
        }
            
        if ($this->isNotHavePosition == true) {
            $this->userModel->where('position_id', null);
        }
        if ($this->cari) {
            $this->userModel->where('id', '>', 0)->where('is_operator', false)->where('is_admin', false)->where(function($query){
                                $query->where('name', 'like', '%'. $this->cari.'%')
                                        ->orWhere('email', 'like', '%'. $this->cari.'%');
                            });          
        }

        $this->positionModel = Position::where('organization_id', $this->organizationId);
        $this->positionModel->where('division_id', $this->divisionId == 0 ? null : $this->divisionId);

        return view('livewire.admin.organization.list-user', [
            'users' => $this->userModel->with(['division', 'position', 'notes'])->latest()->paginate($this->perPage),
            'positions' => $this->positionModel->get(),
            'noteDistributions' => NoteDistribution::latest()->get(),
        ]);
    }

    public function resetPositionId()
    {
        $this->positionId = 0;
    }

    public function createUser()
    {
        $this->disabled = true;
        $this->resetValidation();
        $this->userId = null;
        $this->userName =null;
        $this->userNIP = null;
        $this->userPassword = null;
        $this->positionId = null;
        $this->divisionId = null;
        $this->userIsPlt = false;
        $this->userSlug = Str::random(50);
        $this->positionId = 0;
        $this->divisionId = 0;
    }

    public function storeUser()
    {
        $this->validate([
            'userNIP' => 'required|max:100|unique:users,email',
            'userPassword' => 'required|max:100',
            'userName' => 'required|max:100',
            'userSlug' => 'required|max:100|unique:users,slug',
            'divisionId' => 'nullable',
            'positionId' => 'nullable',
        ]);

        $user = User::create([
            'name' => $this->userName,
            'email' => $this->userNIP,
            'slug' => $this->userSlug,
            'password' => bcrypt($this->userPassword),
            'position_id' =>  $this->positionId,
            'division_id' =>  $this->divisionId,
            'organization_id' =>  $this->organizationId,
            'is_plt' =>  $this->userIsPlt == null ? false : $this->userIsPlt,
        ]);

        session()->flash('message' , $user['name'].' berhasil ditambahkan pada '. $this->organization->name);

    }

    public function getUser(User $user)
    {
        $this->disabled = true;
        $this->resetValidation();
        $this->userId = $user->id;
        $this->userName = $user->name;
        $this->userNIP = $user->email;
        $this->userPassword = $user->password;
        $this->userIsPlt = $user->is_plt;
        $this->userSlug = $user->slug;

        $this->positionId = $user->position_id;
        $this->positionName = $user->position->name??null;
        
        $this->divisionId = $user->division_id;

        $this->organizationId = $user->organization_id;
    }

    public function destroyUser($userId)
    {
        if ($userId) {
            session()->flash('message' , $this->userName.' ('.$this->userNIP.') berhasil dihapus');
            User::find($userId)->delete();
        }

    }

    public function updateUser($userId)
    {
        // $this->validate([
        //     'userPassword' => 'nullable|max:100',
        //     'userName' => 'required|max:100',
        //     'divisionId' => 'nullable',
        //     'positionId' => 'nullable',
        // ]);

        $user = User::where('id', $userId);
        $user->update([
            'name' => $this->userName,
            'position_id' =>  $this->positionId,
            // 'division_id' =>  $this->divisionId,
            'organization_id' =>  $this->organizationId,
            'is_plt' =>  $this->userIsPlt == null ? false : $this->userIsPlt,
        ]);
        if ($this->newPassword !== null) {
            $user->update([
                'password' => bcrypt($this->newPassword),
                // 'password' => ($this->newPassword),
            ]);
        }

        $this->userPassword = null;
        
        session()->flash('message' , 'Data User '.$this->userName.' berhasil diubah');
    }

    public function removeUserPosition($userId)
    {
        User::find($userId)->update([
            'position_id' =>  null,
            'is_plt' =>  false,
        ]);

        $this->positionName = null;
        $this->positionId = null;

        session()->flash('message' , $this->userName.' berhasil dilepas jabatannya');
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

}
