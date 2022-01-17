<?php

namespace App\Http\Livewire\User\Note;

use auth;
use App\Models\Note;
use App\Models\User;
use Livewire\Component;
use App\Models\Attendance;
use Livewire\WithPagination;
use App\Models\NoteDistribution;

class IndexNote extends Component
{

    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    protected $queryString = [
        'cari', 
        'noteCreator', 
        'noteReceived', 
        'noteNew',
        'noteSent', 
        'perPage', 
        'settings', 
    ];


    // protected $noteModel;

    public $attendanceName;
    public $attendancePosition;
    public $attendanceOrganization;

    public $settings = false;
    public $cari;
    public $search;
    public $noteCreator = false;
    public $noteNew = false;
    public $noteReceived = false;
    public $noteSent = false;

    public $perPage = 10;

    public function updatingPerPage()
    {
        $this->resetPage();
    }
    public function updatingCari()
    {
        $this->resetPage();
    }
    public function updatingNoteCreator()
    {
        $this->resetPage();
    }
    public function updatingNoteReceived()
    {
        $this->resetPage();
    }
    public function updatingNoteNew()
    {
        $this->resetPage();
    }
    public function updatingNoteSent()
    {
        $this->resetPage();
    }

    public function render()
    {
        // $this->noteModel = Note::where('user_id', auth()->user()->id)->latest();
        // $this->noteModel = Note::where('user_id', auth()->user()->id);
        
        // $this->noteModel->orWhereHas('noteDistributions', function ($query) {
        //     $query->where('receiver_user_id', auth()->user()->id);
        // });

        // if (!auth()->user()->position->is_staff) {
        //     $this->noteModel->orWhereHas('noteDistributions', function ($query) {
        //         $query->where('receiver_position_id', auth()->user()->position_id);
        //     });
        // }

        $noteModel;

        if (auth()->user()->is_admin) {
            $noteModel = Note::where('id', '>', 0);
        } else {
            $noteModel = Note::where(function ($query) {
                $query->where('user_id', auth()->user()->id);
                $query->orWhereHas('noteDistributions', function ($query) {
                    $query->where('receiver_user_id', auth()->user()->id);
                });
                if (auth()->user()->position) {
                    if (!auth()->user()->position->is_staff) {
                        $query->orWhereHas('noteDistributions', function ($query) {
                            $query->where('receiver_position_id', auth()->user()->position_id);
                        });
                    }
                }
            });
        }

        if ($this->noteCreator == true) {
            $noteModel->where('user_id', auth()->user()->id);
        } 

        if ($this->noteNew == true) {
            $noteModel->whereHas('noteDistributions', function ($query) {
                $query->where('receiver_position_id', auth()->user()->position->id);
                $query->where('is_read', 0);
                if (auth()->user()->position) {
                    if (!auth()->user()->position->is_staff) {
                        $query->where('receiver_position_id', auth()->user()->position_id);
                    }
                }
            });
        } 

        if ($this->noteReceived == true) {
            $noteModel->whereHas('noteDistributions', function ($query) {
                $query->where('receiver_position_id', auth()->user()->position->id);
                if (auth()->user()->position) {
                    if (!auth()->user()->position->is_staff) {
                        $query->where('receiver_position_id', auth()->user()->position_id);
                    }
                }
            });
        } 

        if ($this->noteSent == true) {
            $noteModel->whereHas('noteDistributions', function ($query) {
                $query->where('sender_user_id', auth()->user()->id);
                if (auth()->user()->position) {
                    if (!auth()->user()->position->is_staff) {
                        $query->where('sender_position_id', auth()->user()->position_id);
                    }
                }
            });
        } 

        if ($this->cari) {
            $noteModel->where(function ($query) {
                             $query->where('title', 'like', '%'. $this->cari.'%')
                                    ->orWhere('organizer', 'like', '%'. $this->cari.'%')
                                    ->orWhere('slug', $this->cari);
                        }
            );
        }

        return view('livewire.user.note.index-note', [
            // 'notes' => Note::all(),
            'notes' => $noteModel->with(['user', 'photos', 'attendances', 'noteDistributions'])->orderBy('id', 'DESC')->paginate($this->perPage),
            // 'notes' => $this->noteModel->latest()->get(),
        ]);

    }
    
    public function read_note(Note $note, User $user)
    {
        $noteDistribution = NoteDistribution::where('note_id', $note->id)->where('receiver_position_id', $user->position_id);
        if ($noteDistribution) {
            $noteDistribution->update(['is_read' => 1]);
        }
        // dd($noteDistribution->get());
    }

}
