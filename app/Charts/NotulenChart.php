<?php

declare(strict_types = 1);

namespace App\Charts;

use App\Models\Note;
use Carbon\CarbonPeriod;
use App\Models\Organization;
use Chartisan\PHP\Chartisan;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use ConsoleTVs\Charts\BaseChart;

class NotulenChart extends BaseChart
{
    /**
     * Handles the HTTP request for the given chart.
     * It must always return an instance of Chartisan
     * and never a string or an array.
     */
    public function handler(Request $request): Chartisan
    {

        $thisMonth = Carbon::now();
        $sixMonthAgo = Carbon::now()->subMonth(5);
    
        $notes = Note::oldest()->where('created_at', '<=', now())
                        ->where('created_at' , '>=', $sixMonthAgo->startOfMonth())
                        ->get()->groupBy(function($note) {
            $a = Carbon::parse($note->created_at->toDateTimeString())->format('Y-M');
            return $a;
        });

        $period = CarbonPeriod::create(now()->subMonth(5),'1 month', now());

        foreach ($period as $date) {
            $monthLables[] =  $date->format('Y-M');
        }
        
        $organizations = Organization::all();


        $chart = Chartisan::build()
        ->labels($notes->keys()->toArray());

        foreach ($notes as $key => $row) {
            $data['data'][] = $row->count();
        }

        foreach ($organizations as $key => $organization) {
            foreach ($monthLables as $keyMonth => $month) {
                $data[$organization->id][] = $notes->has($month) ? $notes[$month]->where('organization_id', $organization->id)->count() : 0;
            }
            $chart->dataset($organization->alias, $data[$organization->id]);
        }
        // $chart->dataset('$key', $data['data']);

        return $chart;
    }
}