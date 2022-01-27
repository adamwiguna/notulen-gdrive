<?php

declare(strict_types = 1);

namespace App\Charts;

use App\Models\Organization;
use Chartisan\PHP\Chartisan;
use Illuminate\Http\Request;
use ConsoleTVs\Charts\BaseChart;

class PieChart extends BaseChart
{
    /**
     * Handles the HTTP request for the given chart.
     * It must always return an instance of Chartisan
     * and never a string or an array.
     */
    public function handler(Request $request): Chartisan
    {
        $organizations = Organization::all();

        $chart = Chartisan::build()
        ->labels($organizations->pluck('alias')->toArray());

        foreach ($organizations as $key => $organization) {
            $data[] = $organization->notes->count();
        }
        $chart->dataset('total', $data);

        return $chart;
    }
}