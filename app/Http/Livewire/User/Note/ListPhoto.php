<?php

namespace App\Http\Livewire\User\Note;

use App\Models\Photo;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use CURLFile;

class ListPhoto extends Component
{
    private $modelPhoto;
    public $note;
    public $photo;
    use WithFileUploads;

    public function render()
    {
        // $this->modelPhoto = Photo::where('note_id', $this->note->id)->latest()->get();
        $this->modelPhoto = $this->note->load('photos');
        // dd($this->modelPhoto);
        return view('livewire.user.note.list-photo', [
            // 'photos' => $this->modelPhoto,
            'photos' => $this->note->photos,
        ]);
    }
}
