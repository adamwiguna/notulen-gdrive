<?php

namespace App\Http\Controllers\User;

use App\Models\Note;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        Note::where('user_id', auth()->user()->id)->where('slug', null)->delete();

        return view('user.dashboard.index', [
            'sidebar' => 'dashboard',
            // 'notes' => Note::where('user_id', auth()->user()->id)->get(),
        ]);
    }
    
}
