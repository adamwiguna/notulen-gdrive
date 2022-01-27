<?php

namespace App\Http\Livewire\User\Note;

use App\Models\User;
use Livewire\Component;
use App\Models\Position;
use App\Models\NoteDistribution;
use Illuminate\Support\Facades\Auth;

class Share extends Component
{
    public $note;

    public $cari;

    public function render()
    {
       

        $positions = Position::
                                // where('organization_id', auth()->user()->organization_id)
                                where(function($query){
                                    if (auth()->user()->is_admin) {
                                        $query->latest();
                                    } else {
                                        $query->where('organization_id', auth()->user()->organization_id);
                                    }
                                })
                                // ->whereHas('notes', function ($query) {
                                //     $query->where('id', '!=', $this->note->id);
                                // })
                                ->where('id', '<>',$this->note->position_id)
                                ->where('is_staff', 0);

        if (auth()->user()->is_admin || auth()->user()->position->can_share_note === 1) {
            $positionsOutsideOrganization = Position::where('organization_id', '<>', auth()->user()->is_admin? '0' : auth()->user()->position->organization_id)
                                            ->where('can_view_shared_note', 1);
            if ($this->cari) {
            $positionsOutsideOrganization->where(function ($query) {
                             $query->where('name', 'like', '%'. $this->cari.'%')
                                    ->orWhereHas('users', function ($query) {
                                        $query->where('name', 'like', '%'. $this->cari.'%');
                                    });
                            });
            } 
        
        }
        else {
            $positionsOutsideOrganization = Position::where('id', 1);
        }

        if ($this->cari) {
            $positions->where(function ($query) {
                             $query->where('name', 'like', '%'. $this->cari.'%')
                                    ->orWhereHas('users', function ($query) {
                                        $query->where('name', 'like', '%'. $this->cari.'%');
                                    });
                            });
        }

        return view('livewire.user.note.share', [
            'note' => $this->note,
            // 'users' => $users->latest()->get()->except(Auth::id()),
            'positions' => $positions->latest()->get()->except(auth()->user()->position_id),
            'positionsOutsideOrganization' => $positionsOutsideOrganization->latest()->get()->except(auth()->user()->position_id),
        ]);
    }

    public function shareTo($note_id, $position_id)
    {
        $data = NoteDistribution::where('note_id', $note_id)->where('receiver_position_id', $position_id)->get();
        // dd($data->count(?));
        if ($data->count() == 0) {
            $data = NoteDistribution::create([
                'note_id' => $note_id,
                'sender_user_id' => auth()->user()->id,
                'sender_position_id' => auth()->user()->position_id,
                'receiver_position_id' => $position_id,
            ]);
            // $this->emit('dataStored', $data);
            session()->flash('message' , 'Notulen berhasil dikirim');
        }

    }

    public function unShareTo($note_id, $position_id)
    {
        // dd($note_id, $position_id);
        $data = NoteDistribution::where('note_id', $note_id)->where('receiver_position_id', $position_id);
        if ($data->count() > 0) {
            $data->delete();
            session()->flash('message' , 'Notulen batal dikirim');
        }

    }
}
