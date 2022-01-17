<?php

namespace App\Http\Livewire\User\Note;

use Livewire\Component;
use App\Models\Attendance;

class ListAttendance extends Component
{    
    protected $attendanceModel;

    public $note;

    public $attendanceName;
    public $attendancePosition;
    public $attendanceOrganization;
    
    public function render()
    {   
        $this->attendanceModel = Attendance::where('note_id', $this->note->id)->latest()->get();
        // dd($this->attendanceModel);

        return view('livewire.user.note.list-attendance', [
            'attendances' => $this->attendanceModel,
        ]);
    }

    public function storeAttendance($noteId)
    {
        $this->validate([
            'attendanceName' => 'required|max:100',
            'attendancePosition' => 'required|max:100',
            'attendanceOrganization' => 'required|max:100',
        ]);

        Attendance::create([
            'note_id' => $noteId,
            'name' => $this->attendanceName,
            'position' => $this->attendancePosition,
            'organization' => $this->attendanceOrganization,
        ]);

        $this->reset([
            'attendanceName',
            'attendancePosition',
            'attendanceOrganization',
        ]);

        session()->flash('message-attendance' , 'Kehadiran berhasil ditambahkan');
    }

    public function deleteAttendance($id)
    {
        Attendance::find($id)->delete();
        
        session()->flash('message-attendance' , 'Kehadiran berhasil dihapus');
    }
}
