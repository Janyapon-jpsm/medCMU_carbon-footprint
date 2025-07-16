<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function showEmissionDashboard(Request $request)
    {
        // Get emissions by year
        $emissionsData = DB::table('emission_calculations')
            ->select(DB::raw('year, SUM(total_cf) as total_emission'))
            ->groupBy('year')
            ->orderBy('year')
            ->get();

        $years = [];
        $emissions = [];
        $reductions = [];

        foreach ($emissionsData as $row) {
            $years[] = $row->year;
            $emissions[] = $row->total_emission;
            $reductions[] = 0;
        }

        // Get reductions by year
        $reductionsData = DB::table('reduction_calculations')
            ->select(DB::raw('year, SUM(total_cf) as total_reduction'))
            ->groupBy('year')
            ->orderBy('year')
            ->get();

        foreach ($reductionsData as $row) {
            $index = array_search($row->year, $years);
            if ($index !== false) {
                $reductions[$index] += $row->total_reduction;
            } else {
                $years[] = $row->year;
                $emissions[] = 0;
                $reductions[] = $row->total_reduction;
            }
        }

        // Calculate progress percentages
        $totalEmissions = DB::table('emission_calculations')->sum('total_cf');
        $totalReductions = DB::table('reduction_calculations')->sum('total_cf');
        $total = $totalEmissions + $totalReductions;

        $emissionPercentage = $total ? ($totalEmissions / $total) * 100 : 0;
        $reductionPercentage = $total ? ($totalReductions / $total) * 100 : 0;

        // Get carbon footprint by type with date filter
        $selectedDate = $request->input('selected_date');

        $carbonFootprintQuery = DB::table('emission_calculations as ec')
            ->join('emission_types as et', 'ec.em_id', '=', 'et.em_id')
            ->select('et.type', DB::raw('SUM(ec.total_cf) as total_carbon_footprint'));

        if ($selectedDate) {
            $year = date('Y', strtotime($selectedDate));
            $month = (int)date('m', strtotime($selectedDate));

            $carbonFootprintQuery->where('ec.year', $year)
                ->where('ec.month', $month);
        }

        $carbonFootprintData = $carbonFootprintQuery->groupBy('et.type')
            ->orderByDesc('total_carbon_footprint')
            ->get();

        $totalCF = [];
        $carbonType = [];

        foreach ($carbonFootprintData as $row) {
            $totalCF[] = floatval($row->total_carbon_footprint);
            $carbonType[] = $row->type;
        }

        return view('dashboard-em', [
            'years' => $years,
            'emissions' => $emissions,
            'reductions' => $reductions,
            'totalEmissions' => $totalEmissions,
            'emissionPercentage' => $emissionPercentage,
            'reductionPercentage' => $reductionPercentage,
            'totalCF' => $totalCF,
            'carbonType' => $carbonType
        ]);
    }

    public function showReductionDashboard(Request $request)
    {
        //emission by year
        $emissionsData = DB::table('emission_calculations')
            ->select(DB::raw('year, SUM(total_cf) as total_emission'))
            ->groupBy('year')
            ->orderBy('year')
            ->get();

        $years = [];
        $emissions = [];
        $reductions = [];

        foreach ($emissionsData as $row) {
            $years[] = $row->year;
            $emissions[] = $row->total_emission;
            $reductions[] = 0;
        }

        //reductions by year
        $reductionsData = DB::table('reduction_calculations')
            ->select(DB::raw('year, SUM(total_cf) as total_reduction'))
            ->groupBy('year')
            ->orderBy('year')
            ->get();

        foreach ($reductionsData as $row) {
            $index = array_search($row->year, $years);
            if ($index !== false) {
                $reductions[$index] += $row->total_reduction;
            } else {
                $years[] = $row->year;
                $emissions[] = 0;
                $reductions[] = $row->total_reduction;
            }
        }

        // Calculate progress percentages
        $totalEmissions = DB::table('emission_calculations')->sum('total_cf');
        $totalReductions = DB::table('reduction_calculations')->sum('total_cf');
        $total = $totalEmissions + $totalReductions;

        $emissionPercentage = $total ? ($totalEmissions / $total) * 100 : 0;
        $reductionPercentage = $total ? ($totalReductions / $total) * 100 : 0;

        // Get carbon footprint by type with date filter
        $selectedDate = $request->input('selected_date');

        $carbonFootprintQuery = DB::table('reduction_calculations as rc')
            ->join('reduction_types as rt', 'rc.re_id', '=', 'rt.re_id')
            ->select('rt.type', DB::raw('SUM(rc.total_cf) as total_carbon_footprint'));

        if ($selectedDate) {
            $year = date('Y', strtotime($selectedDate));
            $month = (int)date('m', strtotime($selectedDate));

            $carbonFootprintQuery->where('rc.year', $year)
                ->where('rc.month', $month);
        }

        $carbonFootprintData = $carbonFootprintQuery->groupBy('rt.type')
            ->orderByDesc('total_carbon_footprint')
            ->get();

        $totalCF = [];
        $carbonType = [];

        foreach ($carbonFootprintData as $row) {
            $totalCF[] = floatval($row->total_carbon_footprint);
            $carbonType[] = $row->type;
        }

        return view('dashboard-re', [
            'years' => $years,
            'emissions' => $emissions,
            'reductions' => $reductions,
            'totalReductions' => $totalReductions,
            'emissionPercentage' => $emissionPercentage,
            'reductionPercentage' => $reductionPercentage,
            'totalCF' => $totalCF,
            'carbonType' => $carbonType
        ]);
    }

    public function showEmissionDetails(Request $request)
{
    $selectedDate = $request->input('selected_date');
    
    // Define chart types to match your HTML IDs
    $chartTypes = [
        'CarbonFootprintจากการเผาไหม้เชื้อเพลิง',
        'CarbonFootprintจากการรั่วไหลและอื่นๆ',
        'CarbonFootprintจากการใช้พลังงาน',
        'CarbonFootprintทางอ้อมอื่นๆ'
    ];
    
    // Base query for emissions detail
    $query = DB::table('emission_types as et')
        ->join('emission_sub_types as est', 'et.em_id', '=', 'est.em_id')
        ->leftJoin('emission_calculations as ec', 'est.em_sub_id', '=', 'ec.em_sub_id');
    
    // Apply date filter if selected
    if ($selectedDate) {
        $year = date('Y', strtotime($selectedDate));
        $month = (int)date('m', strtotime($selectedDate));
        
        $query->where('ec.year', $year)
              ->where('ec.month', $month);
    }
    
    $emissionsDetail = $query
        ->select(DB::raw('et.type as emission_type, est.sub_type, COALESCE(SUM(ec.total_cf), 0) as total_cf'))
        ->whereIn('et.type', [
            'Carbon Footprint จากการเผาไหม้เชื้อเพลิง',
            'Carbon Footprint จากการรั่วไหลและอื่นๆ',
            'Carbon Footprint จากการใช้พลังงาน',
            'Carbon Footprint ทางอ้อมอื่นๆ'
        ])
        ->groupBy('et.type', 'est.sub_type')
        ->orderByDesc('total_cf')
        ->get();

    // Prepare data for each chart type
    $chartLabels = [];
    $chartValues = [];

    foreach ($emissionsDetail as $row) {
        $type = $row->emission_type;
        $chartLabels[$type][] = $row->sub_type;
        $chartValues[$type][] = floatval($row->total_cf);
    }

    return view('em-detail', [
        'chartLabels' => $chartLabels,
        'chartValues' => $chartValues,
        'chartTypes' => $chartTypes
    ]);
}
}