<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Note;
use App\Models\User;
use App\Models\Position;
use App\Models\Organization;
use Illuminate\Http\Request;
use App\Models\NoteDistribution;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {

        $record = User::select(\DB::raw("COUNT(*) as count"), \DB::raw("DAYNAME(created_at) as day_name"), \DB::raw("DAY(created_at) as day"))
                    ->where('created_at', '>', Carbon::today()->subDay(6))
                    ->groupBy('day_name','day')
                    ->orderBy('day')
                    ->get();

        $users = User::all()->except('is_admin', 1);
        $organizations = Organization::with('note_distributions')->latest()->get();
        // $noteDistributions = NoteDistribution::withCount('noteDistributions')->oldest()->get();
        // dd($organizations->notes);
        $data = Note::selectRaw('year(created_at) year, month(created_at) month, count(*) data, organization_id')
        ->groupBy('year', 'month', 'organization_id')
        ->orderBy('month', 'desc')
        ->get()
        ->where('year', Carbon::today()->format('Y'))
        // ->where('month', '<',  Carbon::today()->subMonths(6))
        ->toArray();
        
        $organizations = Organization::with('notes')->get();
        // dd($organizations);
                
     $data = [];
 
     $total = 0;
     $MonthYear = array();

        $notes = Note::all()->groupBy(function($note) {
            return Carbon::parse($note->created_at->toDateTimeString())->format('Y-M');
        })->take(-6);
       

        //  dd($notes);

//    dd($notes->toArray());
     foreach ($organizations as $organization) {
        //  dd($organization->toQuery());
         $or = $organization->notes->groupBy(function($note) {
            $a = Carbon::parse($note->created_at->toDateTimeString())->format('Y-M');
            // dd($a);
            
            return $a;
        })->map->count();
       
        // dd($or->keys());
        
    }

    $month = [];
    $month[] = date('Y-M');
    for ($i = 1; $i < 6; $i++) {
        $month[] = date('Y-M', strtotime("-$i month"));
    }
    // dd($month);

    $thisMonth = Carbon::now();
    // dd($thisMonth->month);
    $sixMonthAgo = Carbon::now()->subMonth(5);
    // dd($sixMonthAgo);

    // dd(date("F 1, Y", strtotime("-6 months")));
    // dd(now());
    // dd(strtotime("-6 months"));

    $note = Note::where('created_at', '<=', now())
                    ->where('created_at' , '>=', $sixMonthAgo->startOfMonth())
                    ->get()->groupBy(function($note) {
        $a = Carbon::parse($note->created_at->toDateTimeString())->format('Y-M');
        return $a;
    });
    // $note->toBase();
    // $note->keys();
    // $note->all();
    // $note->only($month);
    // dd($note->keys()->toArray());


    //  $bgcolor = array();
    //  foreach($organizations as $row) {
    //     $data['label'][] = $row->name;
    //     // dd($row->notes->count());
    //     // foreach ($row->notes as  $a) {
    //     //     // dd($a->noteDistributions->count());
    //     //     $total = $total + (int) $a->noteDistributions->count();
    //     //     // $total = $total + (int) $a->count();
    //     // }
    //     $data['data'][] = $row->notes->count();
    //     // $data['data'][] = $total;
    //     $total=0;
    //     $bgcolor[] = '#'.substr(md5(rand()), 0, 6);
    //   }
     foreach($note as $key=>$row) {
        $data['label'][] = $key;
        // dd($row->notes->count());
        // foreach ($row->notes as  $a) {
        //     // dd($a->noteDistributions->count());
        //     $total = $total + (int) $a->noteDistributions->count();
        //     // $total = $total + (int) $a->count();
        // }
   
        $data['data'][] = $row->count();
        // $data['data'][] = $total;
        $total=0;
        $bgcolor[] = '#'.substr(md5(rand()), 0, 6);

        $a = $row->groupBy('organization_id');
        // dd($a);
      
      }
    //   dd($bgcolor);
    $data['chart_data'] = json_encode($data);
        return view('admin.dashboard.index', [
            'sidebar' => 'dashboard',
            'data' => $data,
            'bgcolor' => '$bgcolor',
            'label' => json_encode($note->keys()),
            'freePosition' => Position::whereDoesntHave('users')->get()->count(),
            'freeUser' => User::where('is_admin', false)->where('position_id', null)->where('organization_id','<>', null)->where('is_operator', false)->get()->count(),
            'notesCount' => Note::get()->count(),
            'notesDistributions' => NoteDistribution::whereHas('note')->get()->count(),
            'notesReadCount' => NoteDistribution::whereHas('note')->where('is_read', true)->get()->count(),
            'userMutaiCount' =>  User::where('is_operator', false)->where('is_admin', false)->where('organization_id', null)->get()->count(),
        ]);
    }
}
