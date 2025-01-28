<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // Use the DB facade for database queries

class DataController extends Controller
{
    public function fetchData(Request $request)
    {
        $month = $request->input('month');
        $year = $request->input('year');

        // Initialize arrays to hold the data
        $totalCF = [];
        $carbonType = [];

        // Check if month and year are provided
        if ($month !== null && $year !== null) {
            // Fetch data for the specific month and year
            $results = DB::table('emission_calculations as ec')
                ->join('emission_types as et', 'ec.em_id', '=', 'et.em_id')
                ->select('et.type', DB::raw('SUM(ec.total_cf) as total_carbon_footprint'))
                ->whereMonth('ec.month', $month)
                ->whereYear('ec.year', $year)
                ->groupBy('et.type')
                ->orderBy('total_carbon_footprint', 'desc')
                ->get();
        } else {
            // Fetch overall data if no month and year are provided
            $results = DB::table('emission_calculations as ec')
                ->join('emission_types as et', 'ec.em_id', '=', 'et.em_id')
                ->select('et.type', DB::raw('SUM(ec.total_cf) as total_carbon_footprint'))
                ->groupBy('et.type')
                ->orderBy('total_carbon_footprint', 'desc')
                ->get();
        }

        // Populate the arrays with the results
        foreach ($results as $row) {
            $totalCF[] = floatval($row->total_carbon_footprint);
            $carbonType[] = $row->type;
        }

        // Return the data as a JSON response
        return response()->json([
            'totalCF' => $totalCF,
            'carbonType' => $carbonType
        ]);
    }
}
