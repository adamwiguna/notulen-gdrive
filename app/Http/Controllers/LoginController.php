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
        } else {
            $response = Http::accept('application/json')->post('http://employee.test/api/login' ,[
                'email' => $request->email,
                'password' => $request->password,
            ]);

            $user = Http::accept('application/json')->withToken($response['token'])->get('http://employee.test/api/get-user')->object();
            $user = collect($user)->first();

            // dd($user->name);

            $newUser = User::updateOrCreate(
                ['id' =>  $user->id], 
                [
                    'password' => $user->slug,
                    'id' =>  $user->id,
                    'email' =>  $user->email,
                    'name' => $user->name,
                    'slug' => $user->slug,
                    'organization_id' => $user->user_positions[0]->position_organization->organization_id ?? null,
                    'position_id' => $user->user_positions[0]->position_organization->position_id ?? null,
                ]
            );

            if($user->user_positions){
                $position = $newUser->position()->updateOrCreate(
                    ['id' => $user->user_positions[0]->position_organization->position_id],
                    [
                        'id' =>$user->user_positions[0]->position_organization->position_id,
                        'name' =>$user->user_positions[0]->position_organization->position->name,
                        'alias' =>$user->user_positions[0]->position_organization->position->alias,
                        'organization_id' =>$user->user_positions[0]->position_organization->organization_id,
                    ]
                );
                $organization = $newUser->organization()->updateOrCreate(
                    ['id' => $user->user_positions[0]->position_organization->organization_id],
                    [
                        'id' =>$user->user_positions[0]->position_organization->organization_id,
                        'name' =>$user->user_positions[0]->position_organization->organization->name,
                        'alias' =>$user->user_positions[0]->position_organization->organization->alias,
                    ]
                );

            }
            
           

            Auth::loginUsingId($newUser->id);

            
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

            
            return redirect()->route('user.dashboard');

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
