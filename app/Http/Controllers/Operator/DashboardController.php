<?php

namespace App\Http\Controllers\Operator;

use App\Models\Note;
use App\Models\User;
use App\Models\Position;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\NoteDistribution;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        $thisMonth = Carbon::now();
        $sixMonthAgo = Carbon::now()->subMonth(5);
        $noteSends = NoteDistribution::oldest()
                        ->whereHas('note', function($query){
                            $query->where('organization_id', auth()->user()->organization_id);
                        })
                        ->where('created_at', '<=', now())
                        ->where('created_at' , '>=', $sixMonthAgo->startOfMonth())
                        ->get()->groupBy(function($note) {
                            $a = Carbon::parse($note->created_at->toDateTimeString())->format('Y-M');
                            return $a;
                        });
                        // dd($noteSends);
                       
                        $period = CarbonPeriod::create(now()->subMonth(5),'1 month', now());

                        foreach ($period as $date) {
                            $monthLables[] =  $date->format('Y-M');
                        }
                        // dd($monthLables);
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
