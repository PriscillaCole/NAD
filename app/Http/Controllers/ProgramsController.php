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

    public function store(Request $request)
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
            'outcomes' => 'array',
            'outcomes.*.id' => 'nullable',  
            'outcomes.*.name' => 'required|string|max:255',
            'outcomes.*.budget' => 'required|numeric|min:0',
            'outcomes.*.outputs' => 'array',
            'outcomes.*.outputs.*.id' => 'nullable',  
            'outcomes.*.outputs.*.name' => 'required|string|max:255',
            'outcomes.*.outputs.*.budget' => 'required|numeric|min:0',
            'outcomes.*.outputs.*.activities' => 'array',
            'outcomes.*.outputs.*.activities.*.id' => 'nullable',  
            'outcomes.*.outputs.*.activities.*.name' => 'required|string|max:255',
            'outcomes.*.outputs.*.activities.*.budget' => 'required|numeric|min:0',
            'outcomes.*.outputs.*.activities.*.budget_lines' => 'array',
            'outcomes.*.outputs.*.activities.*.budget_lines.*.id' => 'nullable',  
            'outcomes.*.outputs.*.activities.*.budget_lines.*.name' => 'required|string|max:255',
            'outcomes.*.outputs.*.activities.*.budget_lines.*.unitcost' => 'required|numeric|min:0',
            'outcomes.*.outputs.*.activities.*.budget_lines.*.quantity' => 'required|numeric|min:0',
            'outcomes.*.outputs.*.activities.*.budget_lines.*.frequency' => 'required|numeric|min:0',
            'outcomes.*.outputs.*.activities.*.budget_lines.*.budget' => 'required|numeric|min:0',

            'contingency' => 'array',
            'contingency.*.id' => 'nullable',
            'contingency.*.name' => 'required',
            'contingency.*.budget' => 'required',

        ]);

        Log::info(['validated:', $validated]);
    
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
            $submittedOutcomeIds = collect($validated['outcomes'])->pluck('id')->filter()->toArray();
            
            // Remove outcomes that are no longer present
            Outcome::whereIn('id', array_diff($currentOutcomeIds, $submittedOutcomeIds))
                ->where('program_id', $program->id)
                ->delete();
    
            // Handle outcomes
            foreach ($validated['outcomes'] as $outcomeData) {
                $outcome = Outcome::updateOrCreate(
                    [
                        'id' => $outcomeData['id'] ?? null,
                        'program_id' => $program->id
                    ],
                    [
                        'name' => $outcomeData['name'],
                        'budget' => $outcomeData['budget'],
                    ]
                );
    
                // Get current output IDs for this outcome
                $currentOutputIds = $outcome->outputs->pluck('id')->toArray();
                $submittedOutputIds = collect($outcomeData['outputs'] ?? [])->pluck('id')->filter()->toArray();
    
                // Remove outputs that are no longer present
                Output::whereIn('id', array_diff($currentOutputIds, $submittedOutputIds))
                    ->where('outcome_id', $outcome->id)
                    ->delete();
    
                // Handle outputs
                foreach ($outcomeData['outputs'] ?? [] as $outputData) {
                    $output = Output::updateOrCreate(
                        [
                            'id' => $outputData['id'] ?? null,
                            'outcome_id' => $outcome->id
                        ],
                        [
                            'name' => $outputData['name'],
                            'budget' => $outputData['budget'],
                        ]
                    );
    
                    // Get current activity IDs for this output
                    $currentActivityIds = $output->activities->pluck('id')->toArray();
                    $submittedActivityIds = collect($outputData['activities'] ?? [])->pluck('id')->filter()->toArray();
    
                    // Remove activities that are no longer present
                    Activity::whereIn('id', array_diff($currentActivityIds, $submittedActivityIds))
                        ->where('output_id', $output->id)
                        ->delete();
    
                    // Handle activities
                    foreach ($outputData['activities'] ?? [] as $activityData) {
                        $activity = Activity::updateOrCreate(
                            [
                                'id' => $activityData['id'] ?? null,
                                'output_id' => $output->id
                            ],
                            [
                                'name' => $activityData['name'],
                                'budget' => $activityData['budget'],
                            ]
                        );
    
                        // Get current budget line IDs for this activity
                        $currentBudgetLineIds = $activity->budget_lines->pluck('id')->toArray();
                        $submittedBudgetLineIds = collect($activityData['budget_lines'] ?? [])->pluck('id')->filter()->toArray();
    
                        // Remove budget lines that are no longer present
                        BudgetLines::whereIn('id', array_diff($currentBudgetLineIds, $submittedBudgetLineIds))
                            ->where('activity_id', $activity->id)
                            ->delete();
    
                        // Handle budget lines
                        foreach ($activityData['budget_lines'] ?? [] as $budgetLineData) {
                            BudgetLines::updateOrCreate(
                                [
                                    'id' => $budgetLineData['id'] ?? null,
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
                }
            }

            // Load existing relationships
            $program->load('contingencyBudgets');
    
            // Get all current IDs for comparison
            $currentOutcomeIds = $program->contingencyBudgets->pluck('id')->toArray();
            $submittedOutcomeIds = collect($validated['contingency'])->pluck('id')->filter()->toArray();
            
            // Remove outcomes that are no longer present
            ContingencyBudget::whereIn('id', array_diff($currentOutcomeIds, $submittedOutcomeIds))
                ->where('program_id', $program->id)
                ->delete();
    

            // Handle contingency budgets
            foreach ($validated['contingency'] as $contingency){
                $contingency = ContingencyBudget::updateOrCreate(
                    [
                        'id' => $contingency['id'] ?? null,
                        'program_id' => $program->id
                    ],
                    [
                        'name' => $contingency['name'],
                        'budget' => $contingency['budget'],
                    ]
                );
            }
    
            \DB::commit();
            admin_toastr('Budget Updated successfully!', 'success');
            return redirect(admin_url('budgets'));
        } catch (\Exception $e) {
            \DB::rollBack();
            Log::error($e);
            return redirect()->back()->with('error', 'Failed to update program. ' . $e->getMessage());
        }
    }




}