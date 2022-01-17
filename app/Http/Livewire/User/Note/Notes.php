<?php

namespace App\Http\Livewire\User\Note;

use App\Models\Note;
use Livewire\Component;
use Livewire\WithPagination;

class Notes extends Component
{

    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    protected $queryString = ['cari'];
// 

    // protected $noteModel;

    public $attendanceName;
    public $attendancePosition;
    public $attendanceOrganization;

    public $cari;
    public $search;
    public $noteCreator = false;
    public $noteReceived = false;
    public $noteSent = false;

    public function render()
    {
        $noteModel;

        if (auth()->user()->is_admin) {
            $noteModel = Note::where('id', '>', 0);
        } else {
            $noteModel = Note::where(function ($query) {
                $query->where('user_id', auth()->user()->id);
                // $query->orWhereHas('noteDistributions', function ($query) {
                //     $query->where('receiver_user_id', auth()->user()->id);
                // });
                // if (auth()->user()->position) {
                //     if (!auth()->user()->position->is_staff) {
                //         $query->orWhereHas('noteDistributions', function ($query) {
                //             $query->where('receiver_position_id', auth()->user()->position_id);
                //         });
                //     }
                // }
            });
        }

        if ($this->noteCreator == true) {
            $noteModel = Note::where('user_id', auth()->user()->id);
        } 

        if ($this->cari) {
            $noteModel->where(function ($query) {
                             $query->where('title', 'like', '%'. $this->cari.'%')
                                    ->orWhere('organizer', 'like', '%'. $this->cari.'%');
                            });
        }
        return view('livewire.user.note.notes', [
            'notes' => $noteModel->orderBy('id', 'DESC')->get(),
        ]);
    }
}
