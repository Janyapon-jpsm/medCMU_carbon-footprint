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

        // Get carbon footprint by type
        $selectedMonth = $request->input('month');
        $selectedYear = $request->input('year');

        $carbonFootprintQuery = DB::table('emission_calculations as ec')
            ->join('emission_types as et', 'ec.em_id', '=', 'et.em_id')
            ->select('et.type', DB::raw('SUM(ec.total_cf) as total_carbon_footprint'));

        if ($selectedMonth && $selectedYear) {
            $carbonFootprintQuery->whereMonth('ec.month', $selectedMonth)
                                ->whereYear('ec.year', $selectedYear);
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
} 