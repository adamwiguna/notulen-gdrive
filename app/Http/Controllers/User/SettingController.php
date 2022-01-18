<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SettingController extends Controller
{
    public function updatePassword(Request $request)
    {
        $request->validate([
            'password' => "required",
        ]);

        User::find(auth()->user()->id)->update([
            'password' => bcrypt($request->password),
        ]);

        session()->flash('message' , 'Password berhasil diubah');

        return redirect()->back();
    }
}
