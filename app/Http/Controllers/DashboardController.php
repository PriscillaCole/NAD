<?php

namespace App\Http\Controllers;

use App\Models\Accountability;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Facades\Admin;
use App\Models\Program;
use App\Models\Staff;
use App\Models\Requisition;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{

    public static function getRequisitionStatus()
    {
        //function to display the amount as 2M or 2K
        function formatAmount($amount)
        {
            if ($amount >= 1000000) {
                return round($amount / 1000000, 1) . 'M'; // Converts to millions
            } elseif ($amount >= 1000) {
                return round($amount / 1000, 1) . 'K'; // Converts to thousands
            }
            return $amount; // Returns as-is for smaller numbers
        }
        $data = [
            'total_requisitions' => Requisition::count(),
            'pending_requisitions' => Requisition::where('status', 'pending')->orWhere('status', null)->count(),
            'director_requisitions' => Requisition::where('status', 'accepted')->count(),
            'approved_requisitions' => Requisition::where('status', 'approved')->whereDoesntHave('accountability')->count(),
            'rejected_requisitions' => Requisition::where('status', 'rejected')->count(),
            'halted_requisitions' => Requisition::where('status', 'halted')->count(),
            //get the total amount of money requested in all requisitions
            'total_amount_requested' => formatAmount(Requisition::whereYear('created_at', Carbon::now()->year)->sum('amount')),
            'accountabilities' => Accountability::whereMonth('created_at', Carbon::now()->month)->count(),
            'closed_accountabilities' => Accountability::whereMonth('created_at', Carbon::now()->month)->where('status', 'closed')->count()
        ];
        

        return view('dashboard.requisition_status_cards', ['data' => $data]);
       
    }

    

    public static function RequisitionStatuschart()
    {
        $total = Requisition::all()->count();
        $pendingCount = Requisition::where('status', 'pending')->count();
        $approvedCount = Requisition::where('status', 'approved')->count();
        $rejectedCount = Requisition::where('status', 'rejected')->count();
        $ammendedCount = Requisition::where('status', 'amended')->count();
        $acceptedCount = Requisition::where('status', 'accepted')->count();

        return compact('pendingCount', 'total', 'approvedCount', 'rejectedCount', 'ammendedCount', 'acceptedCount');

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
        $requisition = Requisition::all()->count();
        $accountabilities = Accountability::all()->count();

        $submitted = round(($accountabilities / $requisition) * 100, 0);

        $pending = 100 - $submitted;

        // Accountability status
        $pendingCount = Accountability::where('status', null)->count();
        $haltedCount = Accountability::where('status', 'halted')->count();
        $acceptedCount = Accountability::where('status', 'closed')->count();

        return view('dashboard.Accountability_Submission_Progress', compact('submitted', 'pending', 'pendingCount', 'haltedCount', 'acceptedCount'));
    }

    public static function programBudget($programId2 = null){
        $user = auth()->user();
            if ($user->isRole('staff')){
                $programs = Program::where('user_id', $user->id)->get();
                
            }else {
                $programs = Program::all();

            }
            
        if ($programId2){
            $program = Program::findOrFail($programId2);
            $totalUsed = $program->outcomes()
                            ->with(['outputs.activities.requisitions.accountability'])
                            ->get()
                            ->flatMap(function ($outcome) {
                                return $outcome->outputs;
                            })
                            ->flatMap(function ($output) {
                                return $output->activities;
                            })
                            ->flatMap(function ($activity) {
                                return $activity->requisitions;
                            })
                            ->map(function ($requisition) {         
                                return $requisition->accountability; 
                            })
                            ->filter()                              
                            ->sum('amount_used');
                        
                            // Calculate remaining budget
                            $remainingBudget = $program->budget - $totalUsed;
            // $programs = Program::all();
            $balance = round(($remainingBudget / $program->budget) * 100);
            $used = round(($totalUsed / $program->budget) * 100);

            Log::info([$remainingBudget, $totalUsed]);
            Log::info([$used, $balance]);
            return [
                'data' => [$used, $balance],
                'programs' => $programs,
                'budget' => $program->budget
            ];
        }else{
            
            // Get all programs
            // $programs = Program::all();

            return [
                'data' => [],
                'programs' => $programs
            ];
        }
    }

    public static function yearExpense($year = null){
        if ($year){
            // $totalAmount = Requisition::where('status', 'approved')->sum('amount');

            $monthlyTotals = Requisition::select(
                DB::raw("MONTH(created_at) as month"),
                DB::raw("SUM(amount) as total_amount")
            )
            ->whereYear('created_at', $year)
            ->groupBy(DB::raw("MONTH(created_at)"))
            ->orderBy('month')
            ->get()
            ->pluck('total_amount', 'month') // Converts to key-value array: [month => total_amount]
            ->toArray();

            Log:: info(['month:'=> $monthlyTotals]);

            return [
                'fund' => $monthlyTotals
            ];
            
        }else{
            
            return [
                'fund' => [],
            ];
        }
    }

    public static function getBudgetComparisonData($programId = null)
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

        $user = auth()->user();
        if ($user->isRole('staff')){
            $programs = Program::where('user_id', $user->id)->get();
            
        }else {
            $programs = Program::all();

        }
        // Filter by program if provided
        if ($programId) {
            $activitiesQuery->where('programs.id', $programId);
        

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

        if ($programId) {
            $accountabilityQuery->join('outputs', 'activities.output_id', '=', 'outputs.id')
                ->join('outcomes', 'outputs.outcome_id', '=', 'outcomes.id')
                ->join('programs', 'outcomes.program_id', '=', 'programs.id')
                ->where('programs.id', $programId);
        }

        $accountabilities = $accountabilityQuery->get();

        // Get all programs
        // $programs = Program::all();

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

        // $heatmap = DashboardController::getBudgetUtilization();
        // $heatmap = DashboardController::getProgramHierarchy($programId);
        
        // Log::info([$heatmap]);

        // dd($chartData);
        
        return view('dashboard.average_approval_time', compact(
            'chartData',
            'programs',
            // 'heatmap'
        ));
        }
        else{
            // Get all programs
            // $programs = Program::all();
            $chartData = [];

            return view('dashboard.average_approval_time', compact('chartData', 'programs'));
        }
    }


    // In DashboardController.php
    public static function getBudgetUtilization()
    {
        // Get all hierarchical data
        $results = DB::table('activities')
            ->join('outputs', 'activities.output_id', '=', 'outputs.id')
            ->join('outcomes', 'outputs.outcome_id', '=', 'outcomes.id')
            ->join('programs', 'outcomes.program_id', '=', 'programs.id')
            ->select(
                'activities.id as id',
                'activities.name as activity_name',
                'activities.budget as activity_budget',
                'outputs.id as output_id',
                'outputs.name as output_name',
                'outputs.budget as output_budget',
                'outcomes.id as outcome_id',
                'outcomes.name as outcome_name',
                'outcomes.budget as outcome_budget',
                'programs.id as program_id',
                'programs.name as program_name',
                'programs.budget as program_budget'
            )
            ->get();

        $structuredData = [];

        foreach ($results as $row) {
            // Calculate percentages at each level
            
            // Activity as percentage of its Output
            if ($row->output_budget > 0) {
                $activityPercentage = round(($row->activity_budget / $row->output_budget) * 100, 2);
            } else {
                $activityPercentage = 0;
            }
            
            // Output as percentage of its Outcome
            if ($row->outcome_budget > 0) {
                $outputPercentage = round(($row->output_budget / $row->outcome_budget) * 100, 2);
            } else {
                $outputPercentage = 0;
            }
            
            // Outcome as percentage of its Program
            if ($row->program_budget > 0) {
                $outcomePercentage = round(($row->outcome_budget / $row->program_budget) * 100, 2);
            } else {
                $outcomePercentage = 0;
            }

            // Add Activity data
            $structuredData[$row->activity_name] = [
                'name' => $row->activity_name,
                'utilization' => $activityPercentage / 100,
                'budget_amount' => $row->activity_budget,
                'parent_budget' => $row->output_budget,
                'level' => 1
            ];

            // Add Output data if not already added
            if (!isset($structuredData[$row->output_name])) {
                $structuredData[$row->output_name] = [
                    'name' => $row->output_name,
                    'utilization' => $outputPercentage / 100,
                    'budget_amount' => $row->output_budget,
                    'parent_budget' => $row->outcome_budget,
                    'level' => 2
                ];
            }

            // Add Outcome data if not already added
            if (!isset($structuredData[$row->outcome_name])) {
                $structuredData[$row->outcome_name] = [
                    'name' => $row->outcome_name,
                    'utilization' => $outcomePercentage / 100,
                    'budget_amount' => $row->outcome_budget,
                    'parent_budget' => $row->program_budget,
                    'level' => 3
                ];
            }

            // Add Program data if not already added
            if (!isset($structuredData[$row->program_name])) {
                $structuredData[$row->program_name] = [
                    'name' => $row->program_name,
                    'utilization' => 1, // Program is 100% of itself
                    'budget_amount' => $row->program_budget,
                    'parent_budget' => $row->program_budget,
                    'level' => 4
                ];
            }
        }

        return $structuredData;
    }

    public static function getProgramHierarchy($programId)
    {
        // Get all hierarchical data filtered by program
        $results = DB::table('activities')
            ->join('outputs', 'activities.output_id', '=', 'outputs.id')
            ->join('outcomes', 'outputs.outcome_id', '=', 'outcomes.id')
            ->join('programs', 'outcomes.program_id', '=', 'programs.id')
            ->where('programs.id', '=', $programId)
            ->select(
                'activities.id as activity_id',
                'activities.name as activity_name',
                'activities.budget as activity_budget',
                'outputs.id as output_id',
                'outputs.name as output_name',
                'outputs.budget as output_budget',
                'outcomes.id as outcome_id',
                'outcomes.name as outcome_name',
                'outcomes.budget as outcome_budget',
                'programs.id as program_id',
                'programs.name as program_name',
                'programs.budget as program_budget'
            )
            ->get();

        if ($results->isEmpty()) {
            return [];
        }

        // Structure the data hierarchically
        $programData = [];
        
        foreach ($results as $row) {
            // Calculate utilization percentages
            $activityPercentage = $row->output_budget > 0 
                ? round(($row->activity_budget / $row->output_budget) * 100, 2) / 100 
                : 0;
                
            $outputPercentage = $row->outcome_budget > 0 
                ? round(($row->output_budget / $row->outcome_budget) * 100, 2) / 100 
                : 0;
                
            $outcomePercentage = $row->program_budget > 0 
                ? round(($row->outcome_budget / $row->program_budget) * 100, 2) / 100 
                : 0;

            // Build hierarchical structure
            if (!isset($programData['outcomes'][$row->outcome_name])) {
                $programData['outcomes'][$row->outcome_name] = [
                    'name' => $row->outcome_name,
                    'budget_amount' => $row->outcome_budget,
                    'utilization' => $outcomePercentage,
                    'outputs' => []
                ];
            }

            if (!isset($programData['outcomes'][$row->outcome_name]['outputs'][$row->output_name])) {
                $programData['outcomes'][$row->outcome_name]['outputs'][$row->output_name] = [
                    'name' => $row->output_name,
                    'budget_amount' => $row->output_budget,
                    'utilization' => $outputPercentage,
                    'activities' => []
                ];
            }

            // Add activity
            $programData['outcomes'][$row->outcome_name]['outputs'][$row->output_name]['activities'][$row->activity_name] = [
                'name' => $row->activity_name,
                'budget_amount' => $row->activity_budget,
                'utilization' => $activityPercentage
            ];
        }

        // Add program level information
        $programData['program'] = [
            'name' => $results->first()->program_name,
            'budget_amount' => $results->first()->program_budget
        ];

        return $programData;
    }

    // API endpoint to fetch data for the frontend
    public function getBudgetData()
    {
        try {
            $data = $this->getBudgetUtilization();
            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


    



}
    

    
    

   

   

   

 


    
    
    


