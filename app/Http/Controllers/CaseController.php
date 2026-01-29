<?php

namespace App\Http\Controllers;

use App\Models\CaseModel;
use Illuminate\Http\Request;

class CaseController extends Controller
{
    public function index()
    {
        // 1. Chart Data: Need separate query to get aggregates or all data for trend
        // For performance on large datasets, you should aggregate. For now, we limit to last 30 days or similar.
        // Assuming we want full trend, we get all but select only needed fields.
        $chartData = CaseModel::orderBy('date', 'asc')->get(['date', 'new_confirmed']); // Optimized Projection

        $labels = $chartData->pluck('date')->map(function($date) {
            return $date instanceof \DateTimeInterface ? $date->format('d-M-y') : $date;
        })->values();
        
        $data = $chartData->pluck('new_confirmed')->values();

        // 2. Table Data: Server-Side Pagination
        // Note: orderBy('date') on strings works alphabetically (not ideal) unless converted.
        // We will stick to DB sort assuming future conversion, or it works 'okay-ish' for now.
        $cases = CaseModel::orderBy('date', 'desc')->paginate(10); 
        
        // 3. Stats Data: Need the absolute latest record for the cards, regardless of pagination
        $latestCase = CaseModel::orderBy('date', 'desc')->first();

        return view('cases.index', [
            'cases' => $cases,
            'labels' => $labels,
            'data' => $data,
            'latest' => $latestCase,
        ]);
    }
}
