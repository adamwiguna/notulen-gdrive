<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Support\Str;
use App\Models\Organization;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrganizationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.organization.index', [
            'sidebar' => 'organization',
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.organization.create', [
            'sidebar' => 'organization',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'alias' => 'required|max:255',
            'username' => 'required|max:255|unique:users,email',
            'slug' => 'required|max:255|unique:users,slug',
            'password' => 'required|max:255|confirmed',
        ]);


        //cek ada data sudah ada?
        $organization = Organization::where('name', $request->name)
                                    ->where('alias', $request->alias)
                                    ->first();
        if ($organization == null) {
            // Menyimpan data Organisasi / SKPD
            $organization = new Organization;
            $organization->name = $request->name;
            $organization->alias = $request->alias;
            $organization->save();
        }

        // Menyimpan data Operataro pada Table User
        $user = new User;
        $user->slug = $request->slug;
        $user->email = $request->username;
        $user->name = $request->username;
        $user->password = $request->password;
        $user->is_operator = true;
        $user->organization_id = $organization->id;
        $user->save();

        $request->session()->flash('message', 'Berhasil menambahkan SKPD');
        return redirect()->route('admin.organization.index');
       
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Organization  $organization
     * @return \Illuminate\Http\Response
     */
    public function show(Organization $organization)
    {
        return view('admin.organization.show', [
            'sidebar' => 'organization',
            'organization' => $organization,
            // 'organization' => Organization::all(),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Organization  $organization
     * @return \Illuminate\Http\Response
     */
    public function edit(Organization $organization)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Organization  $organization
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Organization $organization)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Organization  $organization
     * @return \Illuminate\Http\Response
     */
    public function destroy(Organization $organization)
    {
        //
    }
}
