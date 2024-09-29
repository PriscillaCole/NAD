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

    public function fetchActivities($programId)
    {
        $program = Program::with('activities')->find($programId);
        //for each activity, get the requisitions
        $activities = $program->activities->map(function($activity){
            $activity->requisitions = $activity->requisitions;
            return $activity;
        });

        //for each requisition, get the items
        $activities = $activities->map(function($activity){
            $activity->requisitions = $activity->requisitions->map(function($requisition){
                $requisition->items = $requisition->requisition_items;
                return $requisition;
            });
            return $activity;
        });

        $data = [
            'program' => $program,
            'activities' => $activities
        ];

        Log::info($data);
    
        return response()->json($data);
    }
}
