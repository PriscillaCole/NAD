<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Program;
use App\Models\Outcome;
use App\Models\Output;
use Illuminate\Http\Request;
use Encore\Admin\Form;
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
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
                'user_id' => 'required|exists:admin_users,id',
                // 'budget' => 'nullable|numeric|min:0', // Validate program budget
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
                'outcomes.*.outputs.*.activities.*.budget_lines.*.amount' => 'required_with:outcomes.*.outputs.*.activities.*.budget_lines|numeric|min:0',
                'outcomes.*.outputs.*.activities.*.budget_lines.*.frequency' => 'required_with:outcomes.*.outputs.*.activities.*.budget_lines|numeric|min:0',
                'outcomes.*.outputs.*.activities.*.budget_lines.*.unit_cost' => 'required_with:outcomes.*.outputs.*.activities.*.budget_lines|numeric|min:0',
                'outcomes.*.outputs.*.activities.*.budget_lines.*.quantity' => 'required_with:outcomes.*.outputs.*.activities.*.budget_lines|numeric|min:0',
            ]);

     

            // Begin transaction
            \DB::beginTransaction();
    
          
            // Create the program
            $program = Program::create([
                'name' => $validated['name'],
                'description' => $validated['description'] ?? null,
                'user_id' => $validated['user_id'],
                // 'budget' => $validated['budget'] ?? null,
            ]);
    
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
                                            $activity->budgetLines()->create([
                                                'name' => $budgetLineData['name'],
                                                'budget' => $budgetLineData['amount'],
                                                'unitcost' => $budgetLineData['unit_cost'] ,
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
            admin_toastr('Program created successfully!', 'success');
            return redirect()->route('programs');
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
    
    public function edit(Program $program)
    {
        return view('programs.edit', compact('program'));
    }

    // function to update a program
    public function update(Request $request, $id)
    {
        // Validate incoming data
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'outcomes' => 'nullable|array',
            'outcomes.*.id' => 'nullable|exists:outcomes,id',
            'outcomes.*.name' => 'required_with:outcomes|string|max:255',
            'outcomes.*.outputs' => 'nullable|array',
            'outcomes.*.outputs.*.id' => 'nullable|exists:outputs,id',
            'outcomes.*.outputs.*.name' => 'required_with:outcomes.*.outputs|string|max:255',
            'outcomes.*.outputs.*.activities' => 'nullable|array',
            'outcomes.*.outputs.*.activities.*.id' => 'nullable|exists:activities,id',
            'outcomes.*.outputs.*.activities.*.name' => 'required_with:outcomes.*.outputs.*.activities|string|max:255',
            'outcomes.*.outputs.*.activities.*.budget_lines' => 'nullable|array',
            'outcomes.*.outputs.*.activities.*.budget_lines.*.id' => 'nullable|exists:budget_lines,id',
            'outcomes.*.outputs.*.activities.*.budget_lines.*.name' => 'required_with:outcomes.*.outputs.*.activities.*.budget_lines|string|max:255',
            'outcomes.*.outputs.*.activities.*.budget_lines.*.amount' => 'required_with:outcomes.*.outputs.*.activities.*.budget_lines|numeric|min:0',
        ]);

        \DB::beginTransaction();

        try {
            $program = Program::findOrFail($id);
            $program->update([
                'name' => $validated['name'],
                'description' => $validated['description'] ?? null,
            ]);

            if (!empty($validated['outcomes'])) {
                foreach ($validated['outcomes'] as $outcomeData) {
                    $outcome = $program->outcomes()->updateOrCreate(
                        ['id' => $outcomeData['id'] ?? null],
                        ['name' => $outcomeData['name']]
                    );

                    if (!empty($outcomeData['outputs'])) {
                        foreach ($outcomeData['outputs'] as $outputData) {
                            $output = $outcome->outputs()->updateOrCreate(
                                ['id' => $outputData['id'] ?? null],
                                ['name' => $outputData['name']]
                            );

                            if (!empty($outputData['activities'])) {
                                foreach ($outputData['activities'] as $activityData) {
                                    $activity = $output->activities()->updateOrCreate(
                                        ['id' => $activityData['id'] ?? null],
                                        ['name' => $activityData['name']]
                                    );

                                    if (!empty($activityData['budget_lines'])) {
                                        foreach ($activityData['budget_lines'] as $budgetLineData) {
                                            $activity->budgetLines()->updateOrCreate(
                                                ['id' => $budgetLineData['id'] ?? null],
                                                [
                                                    'name' => $budgetLineData['name'],
                                                    'amount' => $budgetLineData['amount'],
                                                ]
                                            );
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }

            \DB::commit();
            return redirect()->route('programs.index')->with('success', 'Program updated successfully.');
        } catch (\Exception $e) {
            \DB::rollBack();
            return back()->with('error', 'Failed to update program: ' . $e->getMessage());
        }
    }


}