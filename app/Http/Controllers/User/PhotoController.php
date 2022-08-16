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
        
        // $ext = strtolower($request->photo->getClientOriginalExtension());
        // // $image_name = Str::random(50).'_'.time();
        // // $image_full_name = $image_name.'.'.$ext;
        // // $upload_path = 'public/photos/'.$note->id.'/';
        // $image_name = $note->id.'_'.Str::random(50).'_'.time();
        // $image_full_name = $image_name.'.'.$ext;
        // $upload_path = 'public/photos/';
        // $image_url = '/'.$upload_path.$image_full_name;
        // $request->photo->move($upload_path, $image_full_name);

        $ext = strtolower($request->photo->getClientOriginalExtension());
        $image_name = $note->id.'_'.Str::random(50).'_'.time();
        $image_full_name = $image_name.'.'.$ext;
        $upload_path = 'public/photos/';
        // $image_full_name = $image_name.'.'.$ext;
        // $upload_path = 'public/photos/'.$note->id.'/';
        $image_url = '/'.$upload_path.$image_full_name;

        // Storage::disk('google')->putFileAs(
        //     $request->file('photo')->getPathName(), $request->file('photo'), $image_full_name
        // );
        
       

        try {
            // dd($request->photo);
            $content = $request->file('photo')->getContent();
            Storage::disk('google')->put($image_full_name, $content);
            session()->flash('message-gdrive' , 'Foto berhasil dibackup ke Google-Drive');
            // Validate the value...
        } catch (\Exception  $e) {
            report($e);
            // session()->forget('message-gdrive');
            session()->flash('message-gdrive-failed' , 'Foto GAGAL dibackup ke Google-Drive');
            // dd($e);
            // return false;
        }
        
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
        // dd(str_replace('/public/photos/','', $photo->url));
        $photo->delete();
        File::delete(public_path($photo->url));
        Storage::delete($photo->url);
        session()->flash('message' , 'Foto berhasil dihapus');
        
        return redirect()->route('user.photo.create', ['note' => $note]);
    }
}
