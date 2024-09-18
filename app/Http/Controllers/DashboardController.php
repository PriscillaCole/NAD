<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Facades\Admin;
use App\Models\Program;
use App\Models\Requisition;

class DashboardController extends Controller
{

    public static function getRequisitionStatus()
    {
        $data = [
            'total_requisitions' => Requisition::count(),
            'pending_requisitions' => Requisition::where('status', 'pending')->orWhere('status', null)->count(),
            'approved_requisitions' => Requisition::where('status', 'approved')->count(),
            'rejected_requisitions' => Requisition::where('status', 'rejected')->count(),
            'halted_requisitions' => Requisition::where('status', 'halted')->count(),
            //get the total amount of money requested in all requisitions
            'total_amount_requested' => Requisition::sum('amount'),
           
        ];

        return view('dashboard.requisition_status_cards', ['data' => $data]);
       
    }


    //function to group the accepted requisitions by project and activity
    public static function getActivityRequisitionData($programId = null)
    {
        // Fetch all programs to populate the dropdown
        $programs = Program::all(); // Assuming you have a Program model
    
        $query = Requisition::select('activity_id', DB::raw('SUM(amount) as total_amount'))
            ->groupBy('activity_id')
            ->with('activity'); // Assuming you have a relationship with 'activities'
    
        // Filter by program/project if provided
        if ($programId) {
            $query->where('program_id', $programId);
        }
    
        $data = $query->get();
    
        // Format data for the chart (labels and values)
        $chartData = $data->map(function ($item) {
            return [
                'label' => $item->activity->name, // Assuming 'activity' has a 'name' field
                'value' => $item->total_amount,
            ];
        });
    
        // Pass both chartData and programs to the view
        return view('dashboard.requisition_activity_chart', [
            'chartData' => $chartData,
            'programs' => $programs,
        ]);
    }

}
    

    
    

   

   

   

 


    
    
    


