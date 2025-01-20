<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\AdminActivity;
use App\Models\AdminBudget_lines;
use App\Models\AdminProgram;
use App\Models\BudgetLines;
use App\Models\Program;
use App\Models\Outcome;
use App\Models\Output;
use App\Models\Staff;
use App\Models\Utils;
use Illuminate\Http\Request;
use Encore\Admin\Form;
use Illuminate\Support\Facades\Log;
use Laravel\Pail\ValueObjects\Origin\Console;

class AdminBudgetController extends Controller
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
            'program_name' => 'required',
            'description' => 'nullable',
            'user_id' => 'required',
            'budget'=> 'required',
            'outcomes' => 'nullable|array',
            'outcomes.*.name' => 'required_with:outcomes|string|max:255',
            'outcomes.*.budget' => 'nullable|numeric|min:0',
            'outcomes.*.outputs' => 'nullable|array',
            'outcomes.*.outputs.*.name' => 'required_with:outcomes.*.outputs|string|max:255',
            'outcomes.*.outputs.*.budget' => 'nullable|numeric|min:0',
        ]);

        $user_id = $validated['user_id'];
        $staffid = Staff::where('user_id', $user_id)->first()->id;

        Log::info($staffid);
        // Begin transaction
        \DB::beginTransaction();

        // Find or create the program
        $adminprogram = AdminProgram::create([
            'name'=> $validated['program_name'],
            'description' => $validated['description'] ?? null,
            'budget' => $validated['budget'],
            'user_id' => $staffid
        ]);
        
        // Loop through outcomes and save them
        if (!empty($validated['outcomes'])) {
            foreach ($validated['outcomes'] as $outcomeData) {
                $outcome = $adminprogram->adminActivities()->create([
                    'name' => $outcomeData['name'],
                    'budget' => $outcomeData['budget'] ?? null,
                ]);

                // Loop through outputs and save them
                if (!empty($outcomeData['outputs'])) {
                    foreach ($outcomeData['outputs'] as $outputData) {
                        $output = $outcome->adminBudgetLines()->create([
                            'name' => $outputData['name'],
                            'total_cost' => $outputData['budget'] ?? null,
                        ]);
                    }
                }
            }
        }

        // Commit transaction
        \DB::commit();

        // Redirect with success message
        admin_toastr('Program created successfully!', 'success');
        return redirect('/adminBudget');
    } catch (\Exception $e) {
        // Rollback transaction if an error occurs
        \DB::rollBack();

        // Log the error
        \Log::error($e);

        // Redirect with error message
        admin_toastr('Failed to create program. Please try again. ' . $e->getMessage(), 'error');
        return back()->withInput();
    }
}

    

    // function to update a program
    public function update(Request $request, $id)
    {
        try {
            // Validate the incoming request
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'nullable|string|max:1000',
                'budget' => 'required|numeric|min:0',
                'outcomes' => 'nullable|array',
                'outcomes.*.id' => 'nullable|integer',
                'outcomes.*.name' => 'required|string|max:255',
                'outcomes.*.budget' => 'nullable|numeric|min:0',
                'outcomes.*.outputs' => 'nullable|array',
                'outcomes.*.outputs.*.id' => 'nullable|integer',
                'outcomes.*.outputs.*.name' => 'required|string|max:255',
                'outcomes.*.outputs.*.budget' => 'nullable|numeric|min:0',
            ]);
    
    
            // Begin transaction
            \DB::beginTransaction();
    
            // Find the existing program
            $adminProgram = AdminProgram::findOrFail($id);
            $adminProgram->update([
                'name' => $validated['name'],
                'description' => $validated['description'],
                'budget' => $validated['budget'],
            ]);
    
            // Get current outcome IDs for comparison
            $currentOutcomeIds = $adminProgram->adminActivities->pluck('id')->toArray();
            $submittedOutcomeIds = collect($validated['outcomes'])->pluck('id')->filter()->toArray();
    
            // Remove outcomes that are not in the submitted data
            AdminActivity::whereIn('id', array_diff($currentOutcomeIds, $submittedOutcomeIds))
                ->where('admin_program_id', $adminProgram->id)
                ->delete();
    
            // Handle outcomes
            foreach ($validated['outcomes'] ?? [] as $outcomeData) {
                $outcome = AdminActivity::updateOrCreate(
                    [
                        'id' => $outcomeData['id'] ?? null,
                        'admin_program_id' => $adminProgram->id
                    ],
                    [
                        'name' => $outcomeData['name'],
                        'budget' => $outcomeData['budget'] ?? null,
                    ]
                );
    
                // Get current output IDs for comparison
                $currentOutputIds = $outcome->adminBudgetLines->pluck('id')->toArray();
                $submittedOutputIds = collect($outcomeData['outputs'] ?? [])->pluck('id')->filter()->toArray();
    
                // Remove outputs that are not in the submitted data
                AdminBudget_lines::whereIn('id', array_diff($currentOutputIds, $submittedOutputIds))
                    ->where('admin_activity_id', $outcome->id)
                    ->delete();
    
                // Handle outputs
                foreach ($outcomeData['outputs'] ?? [] as $outputData) {
                    AdminBudget_lines::updateOrCreate(
                        [
                            'id' => $outputData['id'] ?? null,
                            'admin_activity_id' => $outcome->id
                        ],
                        [
                            'name' => $outputData['name'],
                            'budget' => $outputData['budget'] ?? null,
                        ]
                    );
                }
            }
    
            \DB::commit();
            admin_toastr('Program updated successfully!', 'success');
            return redirect('/requisitions');
        } catch (\Exception $e) {
            \DB::rollBack();
            \Log::error($e);
            admin_toastr('Failed to update program. Please try again. ' . $e->getMessage(), 'error');
            return back()->withInput();
        }
    }
    




}