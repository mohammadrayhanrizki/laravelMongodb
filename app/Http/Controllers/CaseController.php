<?php

namespace App\Http\Controllers;

use App\Models\CaseModel;
use Illuminate\Http\Request;

class CaseController extends Controller
{
    public function index()
    {
        // Fetch data sorted by date (oldest first for chart trend)
        // We'll reverse it for the table if needed, or just handle it.
        // Actually, charts usually go Left->Right (Old->New). 
        // Table usually goes Top->Bottom (New->Old).
        
        $cases = CaseModel::all(); // Get all to process

        // Sort collection for Chart (Oldest first)
        $chartCases = $cases->sortBy(function($case) {
            return strtotime($case->date);
        });

        $labels = $chartCases->pluck('date')->values();
        $data = $chartCases->pluck('new_confirmed')->values();

        // Sort collection for Table (Newest first)
        $tableCases = $cases->sortByDesc(function($case) {
            return strtotime($case->date);
        });
        
        return view('cases.index', [
            'cases' => $tableCases,
            'labels' => $labels,
            'data' => $data,
        ]);
    }
}
