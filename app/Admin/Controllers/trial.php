<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\BudgetLines;
use App\Models\ContingencyBudget;
use App\Models\Program;
use App\Models\Outcome;
use App\Models\Output;
use App\Models\Utils;
use Illuminate\Http\Request;
use Encore\Admin\Form;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Laravel\Pail\ValueObjects\Origin\Console;

class ProgramsController extends Controller
{
    public function create()
    {
        return view('programs.edit',);
    }

    /* public function store(Request $request)
    {

        try {
            // Validate the incoming data
            $validated = $request->validate([
                'program_id' => 'required|',
                'outcomes' => 'nullable|array',
                'outcomes.*.name' => 'required_with:outcomes|string|max:255',
                'outcomes.*.budget' => 'nullable|numeric|min:0', // Validate outcome budget
                'outcomes.*.outputs' => 'nullable|array',
                'outcomes.*.outputs.*.name' => 'required_with:outcomes.*.outputs|string|max:255',
                'outcomes.*.outputs.*.budget' => 'nullable|numeric|min:0', // Validate output budget
                'outcomes.*.outputs.*.activities' => 'nullable|array',
                'outcomes.*.outputs.*.activities.*.name' => 'required_with:outcomes.*.outputs.*.activities|string|max:255',
                'outcomes.*.outputs.*.activities.*.budget' => 'nullable|numeric|min:0', // Validate activity budget
                'outcomes.*.outputs.*.activities.*.budget_lines' => 'nullable|array',
                'outcomes.*.outputs.*.activities.*.budget_lines.*.name' => 'required_with:outcomes.*.outputs.*.activities.*.budget_lines|string|max:255',
                'outcomes.*.outputs.*.activities.*.budget_lines.*.budget' => 'required_with:outcomes.*.outputs.*.activities.*.budget_lines|numeric|min:0',
                'outcomes.*.outputs.*.activities.*.budget_lines.*.frequency' => 'required_with:outcomes.*.outputs.*.activities.*.budget_lines|numeric|min:0',
                'outcomes.*.outputs.*.activities.*.budget_lines.*.unitcost' => 'required_with:outcomes.*.outputs.*.activities.*.budget_lines|numeric|min:0',
                'outcomes.*.outputs.*.activities.*.budget_lines.*.quantity' => 'required_with:outcomes.*.outputs.*.activities.*.budget_lines|numeric|min:0',
            ]);

     

            // Begin transaction
            \DB::beginTransaction();
    
          
            $program = Program::findOrFail($validated['program_id']);
    
            // Loop through outcomes
            if (!empty($validated['outcomes'])) {
                foreach ($validated['outcomes'] as $outcomeData) {
                    $outcome = $program->outcomes()->create([
                        'name' => $outcomeData['name'],
                        'budget' => $outcomeData['budget'] ?? null,
                    ]);
    
                    // Loop through outputs
                    if (!empty($outcomeData['outputs'])) {
                        foreach ($outcomeData['outputs'] as $outputData) {
                            $output = $outcome->outputs()->create([
                                'name' => $outputData['name'],
                                'budget' => $outputData['budget'] ?? null,
                            ]);
    
                            // Loop through activities
                            if (!empty($outputData['activities'])) {
                                foreach ($outputData['activities'] as $activityData) {
                                    $activity = $output->activities()->create([
                                        'name' => $activityData['name'],
                                        'budget' => $activityData['budget'] ?? null,
                                    ]);
    
                                    // Loop through budget lines
                                    if (!empty($activityData['budget_lines'])) {
                                        foreach ($activityData['budget_lines'] as $budgetLineData) {
                                            $activity->budget_lines()->create([
                                                'name' => $budgetLineData['name'],
                                                'budget' => $budgetLineData['budget'],
                                                'unitcost' => $budgetLineData['unitcost'] ,
                                                'quantity' => $budgetLineData['quantity'] ,
                                                'frequency' => $budgetLineData['frequency'],
                                            ]);
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
    
            // Commit transaction
            \DB::commit();
    
            // Redirect with success message
            admin_toastr('Budget created successfully!', 'success');
            return redirect(admin_url('budgets'));
            // return redirect()->route('programsCreate');
        } catch (\Exception $e) {
            // Rollback transaction if anything goes wrong
            \DB::rollBack();
    
            // Log the error
            \Log::error($e);

            // $this->error('An error occurred: ' . $e->getMessage());
            // Redirect with error message
            admin_toastr('Failed to create program. Please try again.'. $e->getMessage(), 'error');
            return back()->withInput();
        }
    }
     */

    // function to update a program
    public function update(Request $request, $id)
    {
        try {
        // dd($request->input());
        // Log::info(['request:',$request]);
        // Validate the incoming request
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'outcomes' => 'sometimes|nullable|array',
            'outcomes.*.id' => 'sometimes|nullable',  
            'outcomes.*.name' => 'sometimes|required|string|max:255',
            'outcomes.*.budget' => 'sometimes|required|numeric|min:0',
            'outcomes.*.Second_budget' => 'sometimes|nullable|numeric|min:0',
            'outcomes.*.third_budget' => 'sometimes|nullable|numeric|min:0',
            'outcomes.*.outputs' => 'sometimes|nullable|array',
            'outcomes.*.outputs.*.id' => 'sometimes|nullable',  
            'outcomes.*.outputs.*.name' => 'sometimes|required|string|max:255',
            'outcomes.*.outputs.*.budget' => 'sometimes|required|numeric|min:0',
            'outcomes.*.outputs.*.Second_budget' => 'sometimes|nullable|numeric|min:0',
            'outcomes.*.outputs.*.third_budget' => 'sometimes|nullable|numeric|min:0',
            'outcomes.*.outputs.*.activities' => 'sometimes|nullable|array',
            'outcomes.*.outputs.*.activities.*.id' => 'sometimes|nullable',  
            'outcomes.*.outputs.*.activities.*.name' => 'sometimes|required|string|max:255',
            'outcomes.*.outputs.*.activities.*.budget' => 'sometimes|required|numeric|min:0',
            'outcomes.*.outputs.*.activities.*.Second_budget' => 'sometimes|nullable|numeric|min:0',
            'outcomes.*.outputs.*.activities.*.third_budget' => 'sometimes|nullable|numeric|min:0',
            'outcomes.*.outputs.*.activities.*.budget_lines' => 'sometimes|nullable|array',
            'outcomes.*.outputs.*.activities.*.budget_lines.*.id' => 'sometimes|nullable',  
            'outcomes.*.outputs.*.activities.*.budget_lines.*.name' => 'sometimes|required|string|max:255',
            'outcomes.*.outputs.*.activities.*.budget_lines.*.unitcost' => 'sometimes|required|numeric|min:0',
            'outcomes.*.outputs.*.activities.*.budget_lines.*.quantity' => 'sometimes|required|numeric|min:0',
            'outcomes.*.outputs.*.activities.*.budget_lines.*.frequency' => 'sometimes|required|numeric|min:0',
            'outcomes.*.outputs.*.activities.*.budget_lines.*.budget' => 'sometimes|required|numeric|min:0',
            'outcomes.*.outputs.*.activities.*.contingency' => 'sometimes|nullable|array',
            'outcomes.*.outputs.*.activities.*.contingency.*.id' => 'sometimes|nullable',
            'outcomes.*.outputs.*.activities.*.contingency.*.name' => 'sometimes|required|string|max:255',
            'outcomes.*.outputs.*.activities.*.contingency.*.budget' => 'sometimes|required',

            'MEbudget_lines' => 'sometimes|nullable|array',
            'MEbudget_lines.*.id' => 'sometimes|nullable',  
            'MEbudget_lines.*.name' => 'sometimes|nullable|string|max:255',
            'MEbudget_lines.*.units' => 'sometimes|nullable|string|max:255',
            'MEbudget_lines.*.unitcost' => 'sometimes|nullable|numeric|min:0',
            'MEbudget_lines.*.quantity' => 'sometimes|nullable|numeric|min:0',
            'MEbudget_lines.*.frequency' => 'sometimes|nullable|numeric|min:0',
            'MEbudget_lines.*.budget' => 'sometimes|nullable|numeric|min:0',
            'MEbudget_lines.*.dev_org' => 'sometimes|nullable|numeric|min:0',
            'MandEBudget' => 'sometimes|required|numeric|min:0'

        ]);

        Log::info(['validated:', $validated]);
        // Log::info(['request:', $request]);
    
        // Start database transaction
        DB::beginTransaction();
    
        // try {
            // Update the program
            $program = Program::findOrFail($id);
            $program->update([
                'name' => $validated['name'],
                'description' => $validated['description'],
            ]);
    
            // Load existing relationships
            $program->load('outcomes.outputs.activities.budget_lines');
    
            // Get all current IDs for comparison
            $currentOutcomeIds = $program->outcomes->pluck('id')->toArray();
            $outcomeIds = array_keys($validated['outcomes']);
            
            
            // Remove outcomes that are no longer present
            Outcome::whereIn('id', array_diff($currentOutcomeIds, $outcomeIds))
                ->where('program_id', $program->id)
                ->delete();
    
            // Handle outcomes
            // foreach ($validated['outcomes'] as $outcomeData) {
            foreach ($validated['outcomes'] as $outcomeId => $outcomeData) {
                $outcome = Outcome::updateOrCreate(
                    [
                        // 'id' => $outcomeData['id'] ?? null,
                        'id' => is_numeric($outcomeId) ? $outcomeId : null,
                        'program_id' => $program->id
                    ],
                    [
                        'name' => $outcomeData['name'],
                        'budget' => $outcomeData['budget'],
                        'Second_budget' => $outcomeData['Second_budget']? $outcomeData['Second_budget'] : null,
                        'third_budget' => $outcomeData['third_budget']? $outcomeData['third_budget'] : null
                    ]
                );
                if(!empty($outcomeData['outputs'])){
    
                    // Get current output IDs for this outcome
                    $currentOutputIds = $outcome->outputs->pluck('id')->toArray();
                    $submittedOutputIds = array_keys($outcomeData['outputs']);
                
                    // $submittedOutputIds = collect($outcomeData['outputs'] ?? [])->pluck('id')->filter()->toArray();

                    // Remove outputs that are no longer present
                    Output::whereIn('id', array_diff($currentOutputIds, $submittedOutputIds))
                        ->where('outcome_id', $outcome->id)
                        ->delete();
        
                    // Handle outputs
                    foreach ($outcomeData['outputs'] ?? [] as $outputId => $outputData) {
                        $output = Output::updateOrCreate(
                            [
                                'id' => is_numeric($outputId) ? $outputId : null,
                                'outcome_id' => $outcome->id
                            ],
                            [
                                'name' => $outputData['name'],
                                'budget' => $outputData['budget'],
                                'Second_budget' => $outputData['Second_budget']? $outputData['Second_budget'] :null,
                                'third_budget' => $outputData['third_budget']? $outputData['third_budget']: null
                            ]
                        );

                        if(!empty($outputData['activities'])){
        
                            // Get current activity IDs for this output
                            $currentActivityIds = $output->activities->pluck('id')->toArray();
                            $submittedActivityIds = array_keys($outputData['activities']);
            
                            // Remove activities that are no longer present
                            Activity::whereIn('id', array_diff($currentActivityIds, $submittedActivityIds))
                                ->where('output_id', $output->id)
                                ->delete();
            
                            // Handle activities
                            foreach ($outputData['activities'] ?? [] as $activityId => $activityData) {
                                $activity = Activity::updateOrCreate(
                                    [
                                        'id' => is_numeric($activityId) ? $activityId : null,
                                        'output_id' => $output->id,
                                    ],
                                    [
                                        'program_id' =>$program->id,
                                        'name' => $activityData['name'],
                                        'budget' => $activityData['budget'],
                                        'Second_budget' => $activityData['Second_budget']? $activityData['Second_budget']: null,
                                        'third_budget' => $activityData['third_budget']? $activityData['third_budget']: null
                                    ]
                                );
            
                                if (!empty($activityData['budget_lines'])) {
                                    // Get current budget line IDs for this activity
                                    $currentBudgetLineIds = $activity->budget_lines->pluck('id')->toArray();
                                    $submittedBudgetLineIds = array_keys($activityData['budget_lines']);
                
                                    // Remove budget lines that are no longer present
                                    BudgetLines::whereIn('id', array_diff($currentBudgetLineIds, $submittedBudgetLineIds))
                                        ->where('activity_id', $activity->id)
                                        ->delete();
                
                                    // Handle budget lines
                                    foreach ($activityData['budget_lines'] ?? [] as $budgetLineId => $budgetLineData) {
                                        BudgetLines::updateOrCreate(
                                            [
                                                'id' => is_numeric($budgetLineId) ? $budgetLineId : null,
                                                'activity_id' => $activity->id
                                            ],
                                            [
                                                'name' => $budgetLineData['name'],
                                                'unitcost' => $budgetLineData['unitcost'],
                                                'quantity' => $budgetLineData['quantity'],
                                                'frequency' => $budgetLineData['frequency'],
                                                'budget' => $budgetLineData['budget'],
                                            ]
                                        );
                                    }
                                }
                                // $contingencies = $activityData['contingency'];

                                if (!empty($activityData['contingency'])) {
                                    // Get current budget line IDs for this activity
                                    $currentContigencyIds = $activity->contingencies->pluck('id')->toArray();
                                    $submittedContigencyIds = array_keys($activityData['contingency']);
                
                                    // Remove budget lines that are no longer present
                                    ContingencyBudget::whereIn('id', array_diff($currentContigencyIds, $submittedContigencyIds))
                                        ->where('activity_id', $activity->id)
                                        ->delete();
                
                                    // Handle budget lines
                                    foreach ($activityData['contingency'] ?? [] as $contigencyId => $contigencyData) {
                                        ContingencyBudget::updateOrCreate(
                                            [
                                                'id' => is_numeric($contigencyId) ? $contigencyId : null,
                                                'activity_id' => $activity->id
                                            ],
                                            [
                                                'name' => $contigencyData['name'],
                                                'budget' => $contigencyData['budget'],
                                            ]
                                        );
                                    }
                                }
                                // $contingencies = $validated['outcomes.*.outputs.*.activities.*.contingency'] ?? [];   // default to empty array

                                // // Log($contingencies);
                                // if (!empty($contingencies)) {

                                //     // Get current budget line IDs for this activity
                                //     $currentContingencyIds = $activity->contingency->pluck('id')->toArray();
                                //     $submittedContingencyIds = collect($activityData['contingency'] ?? [])->pluck('id')->filter()->toArray();
                
                                //     // Remove budget lines that are no longer present
                                //     ContingencyBudget::whereIn('id', array_diff($currentContingencyIds, $submittedContingencyIds))
                                //         ->where('activity_id', $activity->id)
                                //         ->delete();
                    
                                //     foreach ($activityData['contingency'] ?? [] as $contingencyData) {
                                //         ContingencyBudget::updateOrCreate(
                                //             [
                                //                 'id' => $contingencyData['id'] ?? null,
                                //                 'activity_id' => $activity->id
                                //             ],
                                //             [
                                //                 'name' => $contingencyData['name'],
                                //                 'budget' => $contingencyData['budget'],
                                //             ]
                                //         );
                                //     }
                                // }
                            }
                        }
                    }
                }
            }

            // $program->load('activities.budget_lines');
            $program->load('outcomes.outputs.activities.budget_lines');
    

            $currentMandE = $program->outcomes->where('name', 'M and E')->first();

            if($currentMandE){
                $MandE_outcome = Outcome::updateOrCreate(
                    [
                        'id' => $currentMandE ? $currentMandE->id : null,
                        'program_id' => $program->id
                    ],
                    [
                        'name' => 'M and E',
                        'budget' => $validated['MandEBudget'],
                    ]
                );

                $currentMandE_output = $MandE_outcome->outputs->where('name', 'M and E')->first();

                if($MandE_outcome){

                    $MandE_output = Output::updateOrCreate(
                        [
                            'id' => $currentMandE_output ? $currentMandE_output->id : null,
                            'outcome_id' => $MandE_outcome->id ,
                        ],
                        [
                            'name' => 'M and E',
                            'budget' => $validated['MandEBudget'],
                        ]
                    );

                    $currentMandE_activity = $MandE_output->activities->where('name', 'M and E')->first();

                    if($MandE_output){

                        $MandE_activity = Activity::updateOrCreate(
                            [
                                'id' => $currentMandE_activity ? $currentMandE_activity->id : null,
                                'output_id' => $MandE_output->id,
                                'program_id' => $program->id
                            ],
                            [
                                'name' => 'M and E',
                                'budget' => $validated['MandEBudget'],
                            ]
                        );
        
                        if(!empty($validated['MEbudget_lines'])){
                            $currentBudgetLineIds = $MandE_activity->budget_lines->pluck('id')->toArray();
                            $submittedBudgetLineIds = array_keys($validated['MEbudget_lines']);
        
                            // Remove budget lines that are no longer present
                            BudgetLines::whereIn('id', array_diff($currentBudgetLineIds, $submittedBudgetLineIds))
                                ->where('activity_id', $MandE_activity->id)
                                ->delete();
        
                            // Handle budget lines
                            foreach ($validated['MEbudget_lines'] ?? [] as $MEbudgetLineId => $MEbudgetLineData) {
                                BudgetLines::updateOrCreate(
                                    [
                                        'id' => is_numeric($MEbudgetLineId) ? $MEbudgetLineId : null,
                                        'activity_id' => $MandE_activity->id
                                    ],
                                    [
                                        'name' => $MEbudgetLineData['name'],
                                        'unitcost' => $MEbudgetLineData['unitcost'],
                                        'units' => $MEbudgetLineData['units'],
                                        'quantity' => $MEbudgetLineData['quantity'],
                                        'frequency' => $MEbudgetLineData['frequency'],
                                        'budget' => $MEbudgetLineData['budget'],
                                        'dev_Vs_Org'=> $MEbudgetLineData['dev_org']
                                    ]
                                );
                            }
                        }

                    }}
    
                }

            
            DB::commit();
            admin_toastr('Budget Updated successfully!', 'success');
            return redirect(admin_url('budgets'));
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e);
            return redirect()->back()->with('error', 'Failed to update program. ' . $e->getMessage());
        }
    }

//     public function update(Request $request, $id)
// {
//     try {
//         $validated = $request->validate([
//             'name' => 'required|string|max:255',
//             'description' => 'required|string|max:1000',
//             'outcomes' => 'sometimes|nullable|array',
//             'outcomes.*.id' => 'sometimes|nullable',
//             'outcomes.*.name' => 'sometimes|required|string|max:255',
//             'outcomes.*.budget' => 'sometimes|required|numeric|min:0',

//             'outcomes.*.outputs' => 'sometimes|nullable|array',
//             'outcomes.*.outputs.*.id' => 'sometimes|nullable',
//             'outcomes.*.outputs.*.name' => 'sometimes|required|string|max:255',
//             'outcomes.*.outputs.*.budget' => 'sometimes|required|numeric|min:0',

//             'outcomes.*.outputs.*.activities' => 'sometimes|nullable|array',
//             'outcomes.*.outputs.*.activities.*.id' => 'sometimes|nullable',
//             'outcomes.*.outputs.*.activities.*.name' => 'sometimes|required|string|max:255',
//             'outcomes.*.outputs.*.activities.*.budget' => 'sometimes|required|numeric|min:0',

//             'outcomes.*.outputs.*.activities.*.budget_lines' => 'sometimes|nullable|array',
//             'outcomes.*.outputs.*.activities.*.budget_lines.*.id' => 'sometimes|nullable',
//             'outcomes.*.outputs.*.activities.*.budget_lines.*.name' => 'sometimes|required|string|max:255',
//             'outcomes.*.outputs.*.activities.*.budget_lines.*.unitcost' => 'sometimes|required|numeric|min:0',
//             'outcomes.*.outputs.*.activities.*.budget_lines.*.quantity' => 'sometimes|required|numeric|min:0',
//             'outcomes.*.outputs.*.activities.*.budget_lines.*.frequency' => 'sometimes|required|numeric|min:0',
//             'outcomes.*.outputs.*.activities.*.budget_lines.*.budget' => 'sometimes|required|numeric|min:0',

//             'outcomes.*.outputs.*.activities.*.contingency' => 'sometimes|nullable|array',
//             'outcomes.*.outputs.*.activities.*.contingency.*.id' => 'sometimes|nullable',
//             'outcomes.*.outputs.*.activities.*.contingency.*.name' => 'sometimes|required|string|max:255',
//             'outcomes.*.outputs.*.activities.*.contingency.*.budget' => 'sometimes|required|numeric|min:0',
//         ]);

//         DB::beginTransaction();

//         // Update program
//         $program = Program::findOrFail($id);
//         $program->update([
//             'name' => $validated['name'],
//             'description' => $validated['description'],
//         ]);

//         // Loop through outcomes
//         foreach ($validated['outcomes'] ?? [] as $outcomeData) {
//             $outcome = Outcome::updateOrCreate(
//                 [
//                     'id' => $outcomeData['id'] ?? null,
//                     'program_id' => $program->id
//                 ],
//                 [
//                     'name' => $outcomeData['name'],
//                     'budget' => $outcomeData['budget'],
//                 ]
//             );

//             // Loop through outputs
//             foreach ($outcomeData['outputs'] ?? [] as $outputData) {
//                 $output = Output::updateOrCreate(
//                     [
//                         'id' => $outputData['id'] ?? null,
//                         'outcome_id' => $outcome->id
//                     ],
//                     [
//                         'name' => $outputData['name'],
//                         'budget' => $outputData['budget'],
//                     ]
//                 );

//                 // Loop through activities
//                 foreach ($outputData['activities'] ?? [] as $activityData) {
//                     $activity = Activity::updateOrCreate(
//                         [
//                             'id' => $activityData['id'] ?? null,
//                             'output_id' => $output->id
//                         ],
//                         [
//                             'name' => $activityData['name'],
//                             'budget' => $activityData['budget'],
//                         ]
//                     );

//                     // Loop through budget lines
//                     foreach ($activityData['budget_lines'] ?? [] as $budgetLineData) {
//                         BudgetLines::updateOrCreate(
//                             [
//                                 'id' => $budgetLineData['id'] ?? null,
//                                 'activity_id' => $activity->id
//                             ],
//                             [
//                                 'name' => $budgetLineData['name'],
//                                 'unitcost' => $budgetLineData['unitcost'],
//                                 'quantity' => $budgetLineData['quantity'],
//                                 'frequency' => $budgetLineData['frequency'],
//                                 'budget' => $budgetLineData['budget'],
//                             ]
//                         );
//                     }

//                     // Loop through contingency budgets
//                     foreach ($activityData['contingency'] ?? [] as $contingencyData) {
//                         ContingencyBudget::updateOrCreate(
//                             [
//                                 'id' => $contingencyData['id'] ?? null,
//                                 'activity_id' => $activity->id
//                             ],
//                             [
//                                 'name' => $contingencyData['name'],
//                                 'budget' => $contingencyData['budget'],
//                             ]
//                         );
//                     }
//                 }
//             }
//         }

//         DB::commit();
//         admin_toastr('Budget Updated successfully!', 'success');
//         return redirect(admin_url('budgets'));

//     } catch (\Exception $e) {
//         DB::rollBack();
//         Log::error($e);
//         return redirect()->back()->with('error', 'Failed to update program. ' . $e->getMessage());
//     }
// }





}