<?php

namespace App\Http\Controllers\Operator;

use App\Models\Note;
use App\Models\User;
use App\Models\Position;
use Illuminate\Http\Request;
use App\Models\NoteDistribution;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{

    
    public function index()
    {
        return view('operator.dashboard.index', [
            'sidebar' => 'dashboard',
            'freePosition' => Position::where('organization_id', auth()->user()->organization_id)->whereDoesntHave('users')->get()->count(),
            'freeUser' => User::where('organization_id', auth()->user()->organization_id)->where('position_id', null)->where('is_operator', false)->get()->count(),
            'notesCount' => Note::where('organization_id', auth()->user()->organization_id)->get()->count(),
            'notesDistributions' => NoteDistribution::whereHas('note', function($query){$query->where('organization_id', auth()->user()->organization_id);})->get()->count(),
            // 'notesReadCount' => Note::where('organization_id', auth()->user()->organization_id)->whereHas('noteDistributions', function($query){$query->where('is_read', true);})->get()->count(),
            'notesReadCount' => NoteDistribution::whereHas('note', function($query){$query->where('organization_id', auth()->user()->organization_id);})->where('is_read', true)->get()->count(),
            'userMutaiCount' =>  User::where('id', '>', 0)->where('is_operator', false)->where('is_admin', false)->where('organization_id', null)->get()->count(),
        ]);
    }
}
