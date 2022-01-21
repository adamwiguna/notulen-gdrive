<?php

namespace App\Http\Controllers\User;

use CURLFile;
use App\Models\Note;
use App\Models\Photo;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class PhotoController extends Controller
{
    public function create(Note $note)
    {
        return view('user.photo.create', ['note' => $note]);
    }

    public function store(Request $request, Note $note)
    {
        $request->validate([
            'photo' => 'mimes:jpeg,bmp,png,jpg|max:2048',
        ]);
        
        $ext = strtolower($request->photo->getClientOriginalExtension());
        $image_name = Str::random(50).'_'.time();
        $image_full_name = $image_name.'.'.$ext;
        $upload_path = 'photos/'.$note->id.'/';
        $image_url = '/'.$upload_path.$image_full_name;
        $request->photo->move($upload_path, $image_full_name);
        
        $photo = new Photo;
        $photo->url = $image_url;
        $photo->note_id = $note->id;
        $photo->save();
        
        session()->flash('message' , 'Foto berhasil ditambahkan');
        
        return redirect()->route('user.photo.create', ['note' => $note]);
    }

    public function destroy(Note $note, Photo $photo)
    {
        $photo->delete();
        File::delete(public_path($photo->url));
        session()->flash('message' , 'Foto berhasil dihapus');
        
        return redirect()->route('user.photo.create', ['note' => $note]);
    }
}
