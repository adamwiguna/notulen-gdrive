<?php

namespace App\Http\Controllers\Operator;

use App\Models\Note;
use App\Models\User;
use App\Models\Position;
use Carbon\CarbonPeriod;
use Chartisan\PHP\Chartisan;
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
    
        $notes = Note::oldest()
                        ->where('organization_id', auth()->user()->organization_id)
                        ->where('created_at', '<=', now())
                        ->where('created_at' , '>=', $sixMonthAgo->startOfMonth())
                        ->get()->groupBy(function($note) {
                            $a = Carbon::parse($note->created_at->toDateTimeString())->format('Y-M');
                            return $a;
                        });

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
        $noteReads = NoteDistribution::oldest()
                        ->whereHas('note', function($query){
                            $query->where('organization_id', auth()->user()->organization_id);
                        })
                        ->where('is_read', true)
                        ->where('created_at', '<=', now())
                        ->where('created_at' , '>=', $sixMonthAgo->startOfMonth())
                        ->get()->groupBy(function($note) {
                            $a = Carbon::parse($note->created_at->toDateTimeString())->format('Y-M');
                            return $a;
                        });

        $period = CarbonPeriod::create(now()->subMonth(5),'1 month', now());

        foreach ($period as $date) {
            $monthLables[] =  $date->format('Y-M');
        }

      
     
        foreach ($monthLables as $keyMonth => $month) {
            $data['data'][] = $notes->has($month) ? $notes[$month]->count() : 0;
            $data['send'][] = $noteSends->has($month) ?  $noteSends[$month]->count() : 0;
            $data['read'][] = $noteReads->has($month) ?  $noteReads[$month]->count() : 0;
        }

        // dd($monthLables);

      

        // $thisMonth = Carbon::now();
        // $sixMonthAgo = Carbon::now()->subMonth(5);
        // $noteSends = NoteDistribution::oldest()
        //                 ->whereHas('note', function($query){
        //                     $query->where('organization_id', auth()->user()->organization_id);
        //                 })
        //                 ->where('created_at', '<=', now())
        //                 ->where('created_at' , '>=', $sixMonthAgo->startOfMonth())
        //                 ->get()->groupBy(function($note) {
        //                     $a = Carbon::parse($note->created_at->toDateTimeString())->format('Y-M');
        //                     return $a;
        //                 });
        //                 // dd($noteSends);
                       
        //                 $period = CarbonPeriod::create(now()->subMonth(5),'1 month', now());

        //                 foreach ($period as $date) {
        //                     $monthLables[] =  $date->format('Y-M');
        //                 }
                        // dd($monthLables);
        return view('operator.dashboard.index', [
            'sidebar' => 'dashboard',
            'totalPosition' => Position::where('organization_id', auth()->user()->organization_id)->get()->count(),
            'freePosition' => Position::where('organization_id', auth()->user()->organization_id)->whereDoesntHave('users')->get()->count(),
            'totalUser' => User::where('organization_id', auth()->user()->organization_id)->get()->count(),
            // 'totalUser' => User::where('organization_id', auth()->user()->organization_id)->where('is_operator', false)->get()->count(),
            'freeUser' => User::where('organization_id', auth()->user()->organization_id)->where('position_id', null)->get()->count(),
            // 'freeUser' => User::where('organization_id', auth()->user()->organization_id)->where('position_id', null)->where('is_operator', false)->get()->count(),
            'notesCount' => Note::where('organization_id', auth()->user()->organization_id)->get()->count(),
            'notesDistributions' => NoteDistribution::whereHas('note', function($query){$query->where('organization_id', auth()->user()->organization_id);})->get()->count(),
            // 'notesReadCount' => Note::where('organization_id', auth()->user()->organization_id)->whereHas('noteDistributions', function($query){$query->where('is_read', true);})->get()->count(),
            'notesReadCount' => NoteDistribution::whereHas('note', function($query){$query->where('organization_id', auth()->user()->organization_id);})->where('is_read', true)->get()->count(),
            'userMutaiCount' =>  User::where('id', '>', 0)->where('is_operator', false)->where('is_admin', false)->where('organization_id', null)->get()->count(),
            'data' => $data,
            'months' => $monthLables,
        ]);
    }
}
