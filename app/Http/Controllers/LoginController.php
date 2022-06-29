<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class LoginController extends Controller
{
    public function authenticate(Request $request)
    {
        
        $credentials = $request->validate([
            'email' => ['required'],
            'password' => ['required'],
        ]);
        // dd($credentials);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            if(auth()->user()->is_admin){
                return redirect()->route('admin.dashboard');
            }else if(auth()->user()->is_operator) {
                return redirect()->route('operator.dashboard');
            }else if(!auth()->user()->position_id || !auth()->user()->organization_id) {
                $request->session()->invalidate();
        
                $request->session()->regenerateToken();
                return back()->with('loginError', 'Login Gagal!! </br> <div class=" text-small small"> Jabatan dan Instansi Anda Belum ter-Update</br> Silahkan Hubungi Admin/Operator </div>');
            }else {
                return redirect()->route('user.dashboard');
            }
        }
        
        return back()->with('loginError', 'Login Gagal!!!');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
