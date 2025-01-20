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
use Illuminate\Support\Facades\Log;

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
            'accountabilities' => Accountability::count()
           
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

        $submitted = ($accountabilities / $requisition) * 100;

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
            $balance = ($remainingBudget / $program->budget) *100;
            $used = ($totalUsed /$program->budget) *100;

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

        // dd($chartData);

        return view('dashboard.average_approval_time', compact(
            'chartData',
            'programs'
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
    public static function getAverageApprovalTimeData()
    {
        // $programs = Program::all();

        // // Fetch requisitions with approval times
        // $query = DB::table('requisitions')
        //     ->select(DB::raw('DATE_FORMAT(updated_at, "%Y-%m") as period'), DB::raw('AVG(TIMESTAMPDIFF(DAY, created_at, updated_at)) as avg_days'))
        //     ->whereNotNull('updated_at')
        //     ->groupBy(DB::raw('DATE_FORMAT(updated_at, "%Y-%m")'))
        //     ->orderBy(DB::raw('DATE_FORMAT(updated_at, "%Y-%m")'))
        //     ->get();

        // // Map results to the required format
        // $chartData = $query->map(function($item) {
        //     return [
        //         'period' => $item->period,
        //         'avg_days' => $item->avg_days,
        //     ];
        // });

        // return [
        //     'chartData' => $chartData,
        //     'programs' => $programs,
        // ];

        $treemapData = [
            [
                'category' => 'LLF',
                'value' => 85
            ],
            [
                'category' => 'VRC',
                'value' => 65
            ],
            [
                'category' => 'G',
                'value' => 45
            ],
            [
                'category' => 'DRR',
                'value' => 75
            ],
            [
                'category' => 'DSR',
                'value' => 55
            ],
            [
                'category' => 'RKY',
                'value' => 90
            ],
            [
                'category' => 'PTE',
                'value' => 70
            ],
            [
                'category' => 'APGR',
                'value' => 80
            ]
        ];

        // Sample data for bar chart
        $barChartLabels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'];
        $lerData = [100, 95, 90, 85, 80, 85];
        $rxrData = [80, 85, 75, 70, 65, 70];

        return view('dashboard.average_approval_time', compact(
            'treemapData',
            'barChartLabels',
            'lerData',
            'rxrData'
        ));
    }

    



}
    

    
    

   

   

   

 


    
    
    


