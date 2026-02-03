<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CaseModel;
use App\Http\Resources\CaseResource;
use Illuminate\Support\Facades\Validator;

class CaseController extends Controller
{
    /**
     * Display the dashboard view.
     */    public function dashboard()
    {
        // 1. Chart Data: Limit to last 30 days for readability and performance
        $chartData = CaseModel::orderBy('date', 'desc')
            ->take(30)
            ->get(['date', 'new_confirmed'])
            ->sortBy('date'); // Re-sort chronologically for the chart (Left=Oldest, Right=Newest)

        $labels = $chartData->pluck('date')->map(function($date) {
            return $date instanceof \DateTimeInterface ? $date->format('d-M-y') : $date;
        })->values();
        
        $data = $chartData->pluck('new_confirmed')->values();

        // 2. Table Data: Server-Side Pagination
        $cases = CaseModel::orderBy('date', 'desc')->paginate(10); 
        
        // 3. Stats Data: Need the absolute latest record for the cards, regardless of pagination
        $latestCase = CaseModel::orderBy('date', 'desc')->first();

        return view('cases.index', [
            'chartData' => $chartData,
            'cases' => $cases,
            'latest' => $latestCase,
            'labels' => $labels,
            'data' => $data
        ]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = CaseModel::all();
        return CaseResource::collection($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'date' => 'required|date',
            'new_confirmed' => 'required|integer',
            'acc_confirmed' => 'required|integer',
            'acc_negative' => 'required|integer',
            'positive_rate' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->first()
            ], 422);
        }

        $data = CaseModel::create($request->all());
        return new CaseResource($data);


    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        
        return new CaseResource(CaseModel::findOrFail($id));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $case = CaseModel::findOrFail($id);
        if(!$case){
            return response()->json([
                'status' => 'error',
                'message' => 'ga ketemu waomwoawoaowmaow'
            ], 404);
        }


        $validator = Validator::make($request->all(), [
            'date' => 'sometimes|required|date',
            'new_confirmed' => 'sometimes|required|integer',
            'acc_confirmed' => 'sometimes|required|integer',
            'acc_negative' => 'sometimes|required|integer',
            'positive_rate' => 'sometimes|required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->first()
            ], 422);
        }

        $case->update($request->all());
        return new CaseResource($case);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $case = CaseModel::findOrFail($id);
        if(!$case){
            return response()->json(
                [
                    'message' => 'ga ketemu waomwoawoaowmaow',
                    'status' => 'error'
                ],
                404
            );
        }
        
        //delete data
        $case->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'mantap coy berhasil dihapus'
        ], 200);
    }
}
