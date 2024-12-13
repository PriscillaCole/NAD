<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Excel;
use App\Exports\ActivitiesExport;
use App\Models\Program;
use Illuminate\Support\Facades\Log;

class BudgetController extends Controller
{
    // public function downloadExcel($programId)
    // {
    //     $data = $this->getActivitiesData($programId); // Fetch the required data
    
    //     return Excel::download(new ActivitiesExport($data), 'activities.xlsx');
    // }

    // public function fetchActivities($programId)
    // {
    //     $program = Program::with('activities')->find($programId);
    //     //for each activity, get the requisitions
    //     $activities = $program->activities->map(function($activity){
    //         $activity->requisitions = $activity->requisitions;
    //         return $activity;
    //     });

    //     //for each requisition, get the items
    //     $activities = $activities->map(function($activity){
    //         $activity->requisitions = $activity->requisitions->map(function($requisition){
    //             $requisition->items = $requisition->requisition_items;
    //             return $requisition;
    //         });
    //         return $activity;
    //     });

    //     $data = [
    //         'program' => $program,
    //         'activities' => $activities
    //     ];

    //     Log::info($data);
    
    //     return response()->json($data);
    // }

    public function fetchActivities($programId)
{
    try {
        $program = Program::with([
            'outcomes',
            'outcomes.outputs',
            'outcomes.outputs.activities',
            'outcomes.outputs.activities.budgetlines'
        ])
        ->findOrFail($programId);

        // Transform the data to match the expected frontend structure
        $transformedData = [
            'program' => [
                'id' => $program->id,
                'name' => $program->name
            ],
            'outcomes' => $program->outcomes->map(function ($outcome) {
                return [
                    'id' => $outcome->id,
                    'name' => $outcome->name,
                    'outputs' => $outcome->outputs->map(function ($output) {
                        return [
                            'id' => $output->id,
                            'name' => $output->name,
                            'activities' => $output->activities->map(function ($activity) {
                                return [
                                    'id' => $activity->id,
                                    'name' => $activity->name,
                                    'budget' => $activity->budget,
                                    'budgetlines' => $activity->budgetlines->map(function ($budgetline) {
                                        return [
                                            'name' => $budgetline->name,
                                            'unit_cost' => (float)$budgetline->unit_cost,
                                            'quantity' => (int)$budgetline->quantity,
                                            'frequency' => (int)$budgetline->frequency,
                                            'total_cost' => (float)($budgetline->unit_cost * $budgetline->quantity * $budgetline->frequency)
                                        ];
                                    })
                                ];
                            })
                        ];
                    })
                ];
            })
        ];

        return response()->json($transformedData);

    } catch (\Exception $e) {
        return response()->json([
            'error' => 'Failed to fetch program structure',
            'message' => $e->getMessage()
        ], 500);
    }
}

}
