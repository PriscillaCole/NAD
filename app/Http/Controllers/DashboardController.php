<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Facades\Admin;
use App\Models\Program;
use App\Models\Staff;
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
        $user = auth()->user()->id;
        $staff_id = Staff::where('user_id', $user);

        // Fetch all programs to populate the dropdown
        $programs = Program::all(); // Assuming you have a Program model
    
        $query = Requisition::select('activity_id', DB::raw('SUM(amount) as total_amount'))
            // ->where('staff_id', $staff_id)
            ->groupBy('activity_id')
            ->whereNotNull('program_id')
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


    //function to group the activities by project 
    public static function showProgramsWithActivities()
    {
        // Fetch all programs with their associated activities
        // $programs = Program::with('outcomes.outputs.activities')->get(); // Assuming 'activities' relationship exists in the Program model
        // $program = Program::findOrFail('33');

        $programs = Program::with('outcomes')->get();
        // dd($program->outcomes->outputs);
        return view('dashboard.programs_activities', compact('programs'));
    }

    public static function getBudgetComparisonData($programId2 = null)
    {
        // Get initial budgets from activities with their hierarchy
        $activitiesQuery = DB::table('activities')
            ->join('outputs', 'activities.output_id', '=', 'outputs.id')
            ->join('outcomes', 'outputs.outcome_id', '=', 'outcomes.id')
            ->join('programs', 'outcomes.program_id', '=', 'programs.id')
            ->select(
                'activities.id as activity_id',
                'activities.name as activity_name',
                'activities.budget',
                'outputs.name as output_name',
                'outcomes.name as outcome_name'
            );

        // Filter by program if provided
        if ($programId2) {
            $activitiesQuery->where('programs.id', $programId2);
        

        $activities = $activitiesQuery->get();

        // Get actual amounts used from accountabilities through requisitions
        $accountabilityQuery = DB::table('accountabilities')
            ->join('requisitions', 'accountabilities.requisition_id', '=', 'requisitions.id')
            ->join('activities', 'requisitions.activity_id', '=', 'activities.id')
            ->select(
                'activities.id as activity_id',
                DB::raw('SUM(accountabilities.amount_used) as total_amount_used')
            )
            ->groupBy('activities.id');

        if ($programId2) {
            $accountabilityQuery->join('outputs', 'activities.output_id', '=', 'outputs.id')
                ->join('outcomes', 'outputs.outcome_id', '=', 'outcomes.id')
                ->join('programs', 'outcomes.program_id', '=', 'programs.id')
                ->where('programs.id', $programId2);
        }

        $accountabilities = $accountabilityQuery->get();

        // Get all programs
        $programs = Program::all();

        // Combine data for the chart
        $chartData = $activities->map(function($activity) use ($accountabilities) {
            $actualAmount = $accountabilities->firstWhere('activity_id', $activity->activity_id);
            return [
                'activity_name' => $activity->activity_name,
                'output_name' => $activity->output_name,
                'outcome_name' => $activity->outcome_name,
                'budget' => $activity->budget,
                'amount_used' => $actualAmount ? $actualAmount->total_amount_used : 0
            ];
        });

        // dd($chartData);

        return [
            'chartData' => $chartData,
            'programs' => $programs
        ];}
        else{
            // Get all programs
            $programs = Program::all();

            return [
                'chartData' => [],
                'programs' => $programs
            ];
        }
    }


    // In DashboardController.php
    public static function getAverageApprovalTimeData($period = 'month')
    {
        $programs = Program::all();

        // Fetch requisitions with approval times
        $query = DB::table('requisitions')
            ->select(DB::raw('DATE_FORMAT(updated_at, "%Y-%m") as period'), DB::raw('AVG(TIMESTAMPDIFF(DAY, created_at, updated_at)) as avg_days'))
            ->whereNotNull('updated_at')
            ->groupBy(DB::raw('DATE_FORMAT(updated_at, "%Y-%m")'))
            ->orderBy(DB::raw('DATE_FORMAT(updated_at, "%Y-%m")'))
            ->get();

        // Map results to the required format
        $chartData = $query->map(function($item) {
            return [
                'period' => $item->period,
                'avg_days' => $item->avg_days,
            ];
        });

        return [
            'chartData' => $chartData,
            'programs' => $programs,
        ];
    }

    



}
    

    
    

   

   

   

 


    
    
    


