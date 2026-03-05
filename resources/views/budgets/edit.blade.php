<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Program budget</title>

    <style>
        /* Basic collapsible functionality */
        /* .panel-body {
            display: none;
        } */

        .outcomes,
        .outputs,
        .activities,
        .budgetlines {
            cursor: pointer;
            position: relative;
            padding-right: 30px;
        }

        .inputx {
            border: transparent;
            padding: 1px !important;
        }
        .pd{
            padding: 0px !important;
        }

        /* Initial state - all panels collapsed except outcomes */
        .outcome .output,
        .outcome .activity,
        .outcome .budget-lines {
            margin-left: 20px;
        }

        /* Maintain the existing color scheme */
        .outcomes {
            /* background-color: #FFE6E6 !important; */
            background: -webkit-linear-gradient(right, #d1d3f9, #3c8dbc);
            
        }
        .entity-label{
            color: white !important;
        }

        .outputs {
            background: -webkit-linear-gradient(right, #a1f3ec, #3cbcb1);
        }

        .activities {
            background: -webkit-linear-gradient(right, #aaf7b4, #2da03c);
        }

        .budgetlines {
            background: -webkit-linear-gradient(right, #b6c8fa, #3b4a9c);
        }

        /* Add smooth transition */
        .panel-body {
            transition: all 0.3s ease-out;
        }
    </style>
    <script src="{{asset('js')}}/createProgram.js"></script>
</head>
<body>
<div class="col-md-12">
    <div class="row">
        <div>
            <!-- Program Edit Box -->
            <div class="panel panel-info">
                <div class="panel-heading bg-primary" style="background-color: transparent; display: flex; justify-content: space-between; align-items: center; border-top: 4px solid #87cefa;">
                    <h3 class="panel-title" style="margin: 0;">Edit Budget</h3>
                    <div class="btn-group">
                        <a href="{{ url('budgets') }}" class="btn btn-sm btn-default" title="List">
                            <i class="fa fa-list"></i> List
                        </a>
                    </div>
                </div>

                <!-- Form Body -->
                <div class="panel-body">
                    <form action="{{ url('programs/'. $program->id.'/edit') }}" method="POST" onsubmit="removeFormattingBeforeSubmit()" id="programEditForm" class="form-horizontal" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <!-- Program Name -->
                        <div class="form-group">
                            <label for="name" class="col-sm-2 control-label">Program Name</label>
                            <div class="col-sm-8">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-pencil fa-fw"></i>
                                    </span>
                                    <input type="text" name="name" class="form-control" readonly value="{{ $program->name }}" required />
                                </div>
                            </div>
                        </div>

                        <!-- Program Description -->
                        <div class="form-group">
                            <label for="description" class="col-sm-2 control-label">Program Description</label>
                            <div class="col-sm-8">
                                <textarea name="description" class="form-control" readonly required>{{ $program->description }}</textarea>
                            </div>
                        </div>
                        <!-- Program Budget -->
                        <div class="form-group">
                            <label for="name" class="col-sm-2 control-label">Program Budget (UGX)</label>
                            <div class="col-sm-8">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-pencil fa-fw"></i>
                                    </span>
                                    <?php
                                        // Get the program's initial budget
                                        if (!is_null($program->third_budget)) {
                                            $totalBudget = $program->third_budget;
                                        } elseif (!is_null($program->second_budget)) {
                                            $totalBudget = $program->second_budget;
                                        } elseif (!is_null($program->budget)) {
                                            $totalBudget = $program->budget;
                                        } else {
                                            return "<span style='color: gray;'>No Budget</span>";
                                        }
                                    ?>
                                    <input type="text" class="form-control formatted-input" readonly value="{{ $totalBudget }}" required />
                                </div>
                            </div>
                        </div>

                        <!-- Outcome Section -->
                        <div id="outcomes">

                            {{--  --}}
                        
                            @foreach ($program->outcomes->where('name', '!=', 'M and E') as $outcome)
                                <div class="panel panel-default outcome" id="outcome-{{ $outcome->id }}">
                                    <div class="panel-heading outcomes">
                                        <h4 class="panel-title">
                                            <span class="entity-label">Outcome </span> 
                                        </h4>
                                    </div>
                                    <div class="panel-body">
                                        <!-- Outcome Fields -->
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Outcome Name</label>
                                            <div class="col-sm-8">
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="fa fa-pencil fa-fw"></i>
                                                    </span>
                                                    <input type="text" name="outcomes[{{ $outcome->id }}][name]" class="form-control" value="{{ $outcome->name }}" required>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="description" class="col-sm-2 control-label">Outcome Budget (UGX)</label>
                                            <div class="col-sm-2">
                                                <input type="text" name="outcomes[{{ $outcome->id }}][budget]" oninput= "formatNumber(event)"  class="form-control formatted-input" value=" {{$outcome->budget }}" required>
                                            </div>
                                            <label for="description" class="col-sm-2 control-label">Second budget (revision)</label>
                                            <div class="col-sm-2">
                                                    <input type="text" name="outcomes[{{ $outcome->id }}][Second_budget]" oninput= "formatNumber(event)"  class="form-control formatted-input" value=" {{$outcome->Second_budget }}" required>
                                            </div>
                                            <label for="description" class="col-sm-2 control-label">Third budget (revision)</label>
                                            <div class="col-sm-2">
                                                    <input type="text" name="outcomes[{{ $outcome->id }}][third_budget]" oninput= "formatNumber(event)"  class="form-control formatted-input" value=" {{$outcome->third_budget }}" required>
                                            </div>
                                        </div>
                                        
                                        <!-- Outputs Section -->
                                        <div id="outputs-{{ $outcome->id }}">
                                            @foreach ($outcome->outputs as $output)
                                                <div class="panel panel-default output" id="output-{{ $output->id }}">
                                                    <div class="panel-heading outputs">
                                                        <h5 class="panel-title">
                                                            <span class="entity-label">Output</span> 
                                                        </h5>
                                                    </div>
                                                    <div class="panel-body">
                                                        <!-- Output Fields -->
                                                        <div class="form-group">
                                                            <label class="col-sm-2 control-label">Output Name</label>
                                                            <div class="col-sm-8">
                                                                <div class="input-group">
                                                                    <span class="input-group-addon">
                                                                        <i class="fa fa-pencil fa-fw"></i>
                                                                    </span>
                                                                    <input type="text" name="outcomes[{{ $outcome->id }}][outputs][{{ $output->id }}][name]" class="form-control" value="{{ $output->name }}" required>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="form-group">
                                                            <label for="description" class="col-sm-2 control-label">Outputs Budget (UGX)</label>
                                                            <div class="col-sm-2">
                                                                    <input type="text" name="outcomes[{{ $outcome->id }}][outputs][{{ $output->id }}][budget]" oninput= "formatNumber(event)" class="form-control formatted-input" value=" {{$output->budget}}" required>
                                                            </div>
                                                            <label for="description" class="col-sm-2 control-label">Second budget (revision)</label>
                                                            <div class="col-sm-2">
                                                                    <input type="text" name="outcomes[{{ $outcome->id }}][outputs][{{ $output->id }}][Second_budget]" oninput= "formatNumber(event)" class="form-control formatted-input" value=" {{$output->Second_budget}}" required>
                                                            </div>
                                                            <label for="description" class="col-sm-2 control-label">Third budget (revision)</label>
                                                            <div class="col-sm-2">
                                                                    <input type="text" name="outcomes[{{ $outcome->id }}][outputs][{{ $output->id }}][third_budget]" oninput= "formatNumber(event)" class="form-control formatted-input" value=" {{$output->third_budget}}" required>
                                                            </div>
                                                        </div>

                                                        <!-- Activities Section -->
                                                        <div id="activities-{{ $output->id }}">
                                                            @foreach ($output->activities as $activity)
                                                                <div class="panel panel-default activity" id="activity-{{ $activity->id }}">
                                                                    <div class="panel-heading activities">
                                                                        <h6 class="panel-title">
                                                                            <span class="entity-label">Activity</span> 
                                                                        </h6>
                                                                    </div>
                                                                    <div class="panel-body">
                                                                        <!-- Activity Fields -->
                                                                        <div class="form-group">
                                                                            <label class="col-sm-2 control-label">Activity Name</label>
                                                                            <div class="col-sm-8">
                                                                                <div class="input-group">
                                                                                    <span class="input-group-addon">
                                                                                        <i class="fa fa-pencil fa-fw"></i>
                                                                                    </span>
                                                                                    <input type="text" name="outcomes[{{ $outcome->id }}][outputs][{{ $output->id }}][activities][{{ $activity->id }}][name]" class="form-control " value="{{ $activity->name }}" required>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        {{-- <div class="form-group">
                                                                            <label class="col-sm-2 control-label">Activity Budget (UGX)</label>
                                                                            <div class="col-sm-8">
                                                                                <div class="input-group">
                                                                                    <span class="input-group-addon">
                                                                                        <i class="fa fa-pencil fa-fw"></i>
                                                                                    </span>
                                                                                    <input type="text" name="outcomes[{{ $outcome->id }}][outputs][{{ $output->id }}][activities][{{ $activity->id }}][budget]" oninput= "formatNumber(event)" class="form-control formatted-input" value=" {{($activity->budget) }}" required>
                                                                                </div>
                                                                            </div>
                                                                        </div> --}}
                                                                        <div class="form-group">
                                                                            <label for="description" class="col-sm-2 control-label">Activity Budget (UGX)</label>
                                                                            <div class="col-sm-2">
                                                                                    <input type="text" name="outcomes[{{ $outcome->id }}][outputs][{{ $output->id }}][activities][{{ $activity->id }}][budget]" oninput= "formatNumber(event)" class="form-control formatted-input" value=" {{($activity->budget) }}" required>
                                                                            </div>
                                                                            <label for="description" class="col-sm-2 control-label">Second budget (revision)</label>
                                                                            <div class="col-sm-2">
                                                                                    <input type="text" name="outcomes[{{ $outcome->id }}][outputs][{{ $output->id }}][activities][{{ $activity->id }}][Second_budget]" oninput= "formatNumber(event)" class="form-control formatted-input" value=" {{($activity->Second_budget) }}" required>
                                                                            </div>
                                                                            <label for="description" class="col-sm-2 control-label">Third budget (revision)</label>
                                                                            <div class="col-sm-2">
                                                                                    <input type="text" name="outcomes[{{ $outcome->id }}][outputs][{{ $output->id }}][activities][{{ $activity->id }}][third_budget]" oninput= "formatNumber(event)" class="form-control formatted-input" value=" {{($activity->third_budget) }}" required>
                                                                            </div>
                                                                        </div>
                                                                        <!-- Budget Lines -->
                                                                        <div id="budget-lines-{{ $activity->id }}">
                                                                            @foreach ($activity->budget_lines as $budget_line)
                                                                                <div class="panel panel-default activity" id="activity-{{ $budget_line->id }}">
                                                                                    <div class="panel-heading budgetlines">
                                                                                        <h6 class="panel-title">
                                                                                            <span class="entity-label">Budget Lines</span> 
                                                                                        </h6>
                                                                                    </div>
                                                                                    <div class="panel-body">
                                                                                        <!-- Budget Lines Fields -->
                                                                                        <div class="form-group">
                                                                                            <label class="col-sm-2 control-label">Budget Line Name</label>
                                                                                            <div class="col-sm-8">
                                                                                                <div class="input-group">
                                                                                                    <span class="input-group-addon">
                                                                                                        <i class="fa fa-pencil fa-fw"></i>
                                                                                                    </span>
                                                                                                    <input type="text" name="outcomes[{{ $outcome->id }}][outputs][{{ $output->id }}][activities][{{ $activity->id }}][budget_lines][{{ $budget_line->id }}][name]" class="form-control" value="{{ $budget_line->name }}" required>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="form-group">
                                                                                            <label class="col-sm-2 control-label"> Unit Cost</label>
                                                                                            <div class="col-sm-8">
                                                                                                <div class="input-group">
                                                                                                    <span class="input-group-addon">
                                                                                                        <i class="fa fa-pencil fa-fw"></i>
                                                                                                    </span>
                                                                                                    <input type="text" name="outcomes[{{ $outcome->id }}][outputs][{{ $output->id }}][activities][{{ $activity->id }}][budget_lines][{{ $budget_line->id }}][unitcost]" id="unit-cost-{{$budget_line->id}}" class="form-control formatted-input" oninput="recalculateBudget({{$budget_line->id}})" value="{{ $budget_line->unitcost }}" required>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="form-group">
                                                                                            <label class="col-sm-2 control-label">Quantity</label>
                                                                                            <div class="col-sm-8">
                                                                                                <div class="input-group">
                                                                                                    <span class="input-group-addon">
                                                                                                        <i class="fa fa-pencil fa-fw"></i>
                                                                                                    </span>
                                                                                                    <input type="text" name="outcomes[{{ $outcome->id }}][outputs][{{ $output->id }}][activities][{{ $activity->id }}][budget_lines][{{ $budget_line->id }}][quantity]" id="quantity-{{$budget_line->id}}" class="form-control formatted-input" oninput="recalculateBudget({{$budget_line->id}})" value="{{ $budget_line->quantity }}" required>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="form-group">
                                                                                            <label class="col-sm-2 control-label">Frequency</label>
                                                                                            <div class="col-sm-8">
                                                                                                <div class="input-group">
                                                                                                    <span class="input-group-addon">
                                                                                                        <i class="fa fa-pencil fa-fw"></i>
                                                                                                    </span>
                                                                                                    <input type="text" name="outcomes[{{ $outcome->id }}][outputs][{{ $output->id }}][activities][{{ $activity->id }}][budget_lines][{{ $budget_line->id }}][frequency]" id="frequency-{{$budget_line->id}}" oninput="recalculateBudget({{$budget_line->id}})" class="form-control formatted-input" value="{{ $budget_line->frequency }}" required>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="form-group">
                                                                                            <label class="col-sm-2 control-label">Budget Line Budget (UGX)</label>
                                                                                            <div class="col-sm-8">
                                                                                                <div class="input-group">
                                                                                                    <span class="input-group-addon">
                                                                                                        <i class="fa fa-pencil fa-fw"></i>
                                                                                                    </span>
                                                                                                    <input type="text" name="outcomes[{{ $outcome->id }}][outputs][{{ $output->id }}][activities][{{ $activity->id }}][budget_lines][{{ $budget_line->id }}][budget]" id="budget-{{$budget_line->id}}" oninput= "formatNumber(event)" class="form-control formatted-input" value=" {{($budget_line->budget) }}" readonly required>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="form-group">
                                                                                            <div class="col-sm-8 col-sm-offset-2" style="display: flex; justify-content: flex-end; align-items: center;">
                                                                                                <!-- Delete Button with Bin Icon -->
                                                                                                <button type="button" class="btn btn-danger btn-delete" onclick="deleteBudgetLine({{$budget_line->id}})">
                                                                                                    <i class="fa fa-trash"></i> Delete
                                                                                                </button>
                                                                                            </div>
                                                                                        </div>

                                                                                        
                                                                    
                                                                                        <!-- More fields for Budget Lines -->
                                                                                    </div>
                                                                                </div>
                                                                            @endforeach
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <div class="col-sm-8 col-sm-offset-2" style="display: flex; justify-content: space-between; align-items: center;">
                                                                           <button type="button" class="btn btn-secondary btn-add" onclick="addBudgetLine({{$activity->id}}, {{$output->id}}, {{$outcome->id}})">Add Budget Line</button>
                                                    
                                                                            <!-- Delete Button with Bin Icon -->
                                                                            <button type="button" class="btn btn-danger btn-delete"  onclick="deleteActivity({{$activity->id}})">
                                                                                <i class="fa fa-trash"></i> Delete Activity
                                                                            </button>
                                                                        </div>
                                                                        <div style="height: 20px; border-bottom: 1px solid #eee; text-align: center;margin-top: 20px;margin-bottom: 20px;">
                                                                            <span style="font-size: 18px; background-color: #ffffff; padding: 0 10%;">
                                                                            Contingency Budget
                                                                            </span>
                                                                        </div>

                                                                        <div id="contingency-{{ $activity->id }}" style="padding: 0 15px;">
                                                                            @foreach ($activity->contingencies as $contingency)
                                                                                <div class="panel panel-default activity" id="contingencyBudget-{{ ($contingency->id) }}">
                                                                                    <div class="panel-heading budgetlines">
                                                                                        <h6 class="panel-title">
                                                                                            <span class="entity-label">Contingency Budget</span> 
                                                                                        </h6>
                                                                                    </div>
                                                                                    <div class="panel-body">
                                                                                        <!-- Budget Lines Fields -->
                                                                                        <div class="form-group">
                                                                                            <label class="col-sm-2 control-label">Contingency Name</label>
                                                                                            <div class="col-sm-8">
                                                                                                <div class="input-group">
                                                                                                    <span class="input-group-addon">
                                                                                                        <i class="fa fa-pencil fa-fw"></i>
                                                                                                    </span>
                                                                                                    <!-- outcomes[{{ $outcome->id }}][outputs][{{ $output->id }}][activities][{{ $activity->id }}][budget_lines][{{ $budget_line->id }}][budget] -->
                                                                                                    <input type="text" name="outcomes[{{ $outcome->id }}][outputs][{{ $output->id }}][activities][{{ $activity->id }}][contingency][{{$contingency->id }}][name]" class="form-control " value="{{ $contingency->name }}" required>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                        
                                                                                        <div class="form-group">
                                                                                            <label class="col-sm-2 control-label">Contingency Budget (UGX)</label>
                                                                                            <div class="col-sm-8">
                                                                                                <div class="input-group">
                                                                                                    <span class="input-group-addon">
                                                                                                        <i class="fa fa-pencil fa-fw"></i>
                                                                                                    </span>
                                                                                                    
                                                                                                    <input type="text" name="outcomes[{{ $outcome->id }}][outputs][{{ $output->id }}][activities][{{ $activity->id }}][contingency][{{$contingency->id }}][budget]" class="form-control formatted-input" oninput= "formatNumber(event)" value=" {{($contingency->budget) }}" required>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="form-group">
                                                                                            <div class="col-sm-8 col-sm-offset-2" style="display: flex; justify-content: flex-end; align-items: center;">
                                                                                                <!-- Delete Button with Bin Icon -->
                                                                                                <button type="button" class="btn btn-danger btn-delete" onclick="deleteContingency({{$contingency->id}})">
                                                                                                    <i class="fa fa-trash"></i> Delete
                                                                                                </button>
                                                                                            </div>
                                                                                        </div>
                                                                    
                                                                                        <!-- More fields for Budget Lines -->
                                                                                    </div>
                                                                                </div>
                                                                            @endforeach
                                                                        </div>
                                                                        

                                                                        <div class="form-group">
                                                                            <div class="col-sm-6 col-sm-offset-2" style="display: flex; justify-content: space-between; align-items: center;">
                                                                                <button type="button" class="btn btn-secondary btn-add" onclick="addContigencyBudget({{$activity->id}}, {{$output->id}}, {{$outcome->id}})">Add Contingency Budget</button>
                                                                            </div>
                                                                        </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="col-sm-8 col-sm-offset-2" style="display: flex; justify-content: space-between; align-items: center;">
                                                              <button type="button" class="btn btn-warning btn-add" onclick="addActivity({{$output->id}}, {{$outcome->id}})">Add Activity</button>
                                                              <!-- Delete Button with Bin Icon -->
                                                              <button type="button" class="btn btn-danger btn-delete"  onclick="deleteOutput({{$output->id}})">
                                                                  <i class="fa fa-trash"></i> Delete Output
                                                              </button>
                                                          </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                        
                                        <div class="form-group">
                                            <div class="col-sm-8 col-sm-offset-2" style="display: flex; justify-content: space-between; align-items: center;">
                                                <button type="button" class="btn btn-info btn-add" onclick="addOutput({{$outcome->id}})">Add Output</button>
                                                
                                                <!-- Delete Button with Bin Icon -->
                                                <button type="button" class="btn btn-danger btn-delete" onclick="deleteOutcome({{$outcome->id}})">
                                                    <i class="fa fa-trash"></i> Delete Outcome
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Add Outcome Button -->
                        <div class="form-group">
                            <div class="col-sm-8 col-sm-offset-2">
                                <button type="button" class="btn btn-success btn-add" onclick="addOutcome()">Add Outcome</button>
                            </div>
                        </div>

                        <div style="height: 20px; border-bottom: 1px solid #eee; text-align: center;margin-top: 20px;margin-bottom: 20px;">
                            <span style="font-size: 18px; background-color: #ffffff; padding: 0 10px;">
                              M AND E
                            </span>
                          </div>

                        <div id="contingency">
                            {{-- @foreach ($program->contingencyBudgets as $budget) --}}
                                <div class="panel panel-default " id="activity-{{-- {{ ($budget->id) } --}}}">
                                    <div class="panel-heading budgetlines">
                                        <h6 class="panel-title">
                                            <span class="entity-label">M AND E</span> 
                                        </h6>
                                    </div>
                                    
                                    <div class="panel-body">

                                        <table class="table table-bordered" id="MandE-table">
                                            <thead>
                                                <tr>
                                                    <th>Cost Type</th>
                                                    <th>Units</th>
                                                    <th>Unitcost</th>
                                                    <th>Quantity</th>
                                                    <th>Frequency</th>
                                                    <th>Budget</th>
                                                    <th>Dev Vs Org Budget</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($program->activities->where('name', 'M and E') as $MEData)
                                                @foreach ($MEData->budget_lines as $MEbudgetLineData)
                                                <tr>
                                                    <td class="pd">
                                                        <input type="text" name="MEbudget_lines[${MandEIndex}][name]" value="{{ $MEbudgetLineData->name }}" class="form-control inputx">
                                                    </td>
                                                    <td class="pd">
                                                        <input type="text" name="MEbudget_lines[${MandEIndex}][units]" value="{{ $MEbudgetLineData->name }}" class="form-control inputx">
                                                    </td>
                                                    <td class="pd">
                                                        <input type="number" name="MEbudget_lines[${MandEIndex}][unitcost]" value="{{ $MEbudgetLineData->unitcost }}" class="form-control inputx calc-field">
                                                    </td>
                                                    <td class="pd">
                                                        <input type="number" name="MEbudget_lines[${MandEIndex}][quantity]" value="{{ $MEbudgetLineData->quantity }}" class="form-control inputx calc-field">
                                                    </td>
                                                    <td class="pd">
                                                        <input type="number" name="MEbudget_lines[${MandEIndex}][frequency]" value="{{ $MEbudgetLineData->frequency }}" class="form-control inputx calc-field">
                                                    </td>
                                                    <td class="pd">
                                                        <input type="number" name="MEbudget_lines[${MandEIndex}][budget]" value="{{ $MEbudgetLineData->budget }}" class="form-control inputx budget-field" readonly>
                                                    </td>
                                                    <td class="pd">
                                                        <input type="number" name="MEbudget_lines[${MandEIndex}][dev_org]" value="{{ $MEbudgetLineData->dev_Vs_Org }}" class="form-control inputx">
                                                    </td>
                                                    <td>
                                                        <button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)">Remove</button>
                                                    </td>
                                                </tr>
                                                @endforeach
                                                @endforeach
                                                <!-- Existing crop rows will be inserted here by PHP -->
                                            </tbody>
                                            
                                            <tfoot>
                                                <tr>
                                                    <td colspan="5" class="text-right"><strong>Total:</strong></td>
                                                    <td>
                                                        @php
                                                            $mandE = $program->activities()->where('name', 'M and E')->first();
                                                        @endphp
                                                        <input type="number" name="MandEBudget" id="budget-total-input" class="form-control inputx" value="{{ $mandE?->budget ?? 0 }}" hidden>
                                                    </td>
                                                    <td colspan="2"></td>
                                                </tr>
                                            </tfoot>


                                        </table>

                                        <button type="button" class="btn btn-primary btn-sm" onclick="addMandERow()">+ Add Budget line</button>
                    
                                        <!-- More fields for Budget Lines -->
                                    </div>
                                </div>
                            {{-- @endforeach --}}
                        </div>

                        <!-- Save Button -->
                        <div class="form-group text-right">
                            <div class="col-sm-8 col-sm-offset-2">
                                <button type="submit" class="btn btn-primary">Save Changes</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('click', function (e) {
        if (e.target.matches('.outcomes, .outputs, .activities, .budgetlines')) {
            const panel = e.target.closest('.panel');
            panel.classList.toggle('collapsed');
        }
    });

    document.addEventListener("DOMContentLoaded", function () {
        document.querySelectorAll(".formatted-input").forEach(input => {
            let rawValue = input.value.replace(/,/g, ''); // Remove existing commas (if any)

            // Format the value initially for display
            if (rawValue) {
                let parts = rawValue.split('.');
                parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ','); // Add commas
                input.value = parts.join('.'); // Display formatted value
            }

            // Store the raw value for submission
            input.setAttribute("data-raw", rawValue);

            // Add event listener for formatting on user input
            input.addEventListener("input", function (event) {
                let value = input.value.replace(/[^0-9.]/g, ''); // Remove non-numeric characters except dot
                let parts = value.split('.');

                parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ','); // Add commas
                input.value = parts.join('.'); // Display formatted value

                // Store raw numeric value
                input.setAttribute("data-raw", value);
            });
        });
    });

    // Ensure raw values are submitted
    function removeFormattingBeforeSubmit() {
        document.querySelectorAll(".formatted-input").forEach(input => {
            if (input.hasAttribute("data-raw")) {
                input.value = input.getAttribute("data-raw"); // Replace formatted value with raw value before submission
            }
        });
    }

</script>
</body>
</html>
