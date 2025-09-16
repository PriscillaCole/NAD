<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Show Program</title>

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
        .form-control {
            background-color: white !important;
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
    {{-- <script src="/js/createProgram.js"></script> --}}
</head>
<body>
<div class="col-md-12">
    <div class="row">
        <div>
            <!-- Program Edit Box -->
            <div class="panel panel-info">
                <div class="panel-heading bg-primary" style="background-color: transparent; display: flex; justify-content: space-between; align-items: center; border-top: 4px solid #87cefa;">
                    <h3 class="panel-title" style="margin: 0;">Show Budget</h3>
                    <div class="btn-group">
                        <a href="{{ url('budgets') }}" class="btn btn-sm btn-default" title="List">
                            <i class="fa fa-list"></i> List
                        </a>
                    </div>
                </div>

                <!-- Form Body -->
                <div class="panel-body">
                    <form action="{{ url('programs/'. $program->id.'/edit') }}" method="POST" id="programEditForm" class="form-horizontal" enctype="multipart/form-data">
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
                                    <input type="text" name="name" class="form-control" value="{{ $program->name }}" readonly />
                                </div>
                            </div>
                        </div>

                        <!-- Program Description -->
                        <div class="form-group">
                            <label for="description" class="col-sm-2 control-label">Program Description</label>
                            <div class="col-sm-8">
                                <textarea name="description" class="form-control" readonly>{{ $program->description }}</textarea>
                            </div>
                        </div>
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
                        $remainingBudget = $totalBudget - $totalUsed;
                        $color = $remainingBudget < 0 ? 'red' : 'green';
                        
                        // Format the number as currency
                        // return "<span style='color: {$color};'>" . number_format($remainingBudget, 2) . "</span>";
                    ?>
                        <div class="form-group">
                            <label for="description" class="col-sm-2 control-label">Program Budget (UGX)</label>
                            <div class="col-sm-2">
                                <input type="text" name="budget" class="form-control" value="{{ number_format($totalBudget) }}" readonly />
                            </div>
                            <label for="description" class="col-sm-2 control-label">Used Budget (UGX)</label>
                            <div class="col-sm-2">
                                <input type="text" name="budget" class="form-control" value="{{ number_format($totalUsed) }}" readonly />
                            </div>
                            <label for="description" class="col-sm-2 control-label">Remaining amount (UGX)</label>
                            <div class="col-sm-2">
                                <input type="text" name="budget" class="form-control" value="{{ number_format($remainingBudget) }}" readonly />
                            </div>
                        </div>

                        <!-- Outcome Section -->
                        <div id="outcomes">
                        
                        @php
                            $count = 0
                        @endphp
                            @foreach ($program->outcomes as $outcome)
                           @php
                                $count++;
                           @endphp
                               
                                <div class="panel panel-default outcome" id="outcome-{{ $outcome->id }}">
                                    <div class="panel-heading outcomes">
                                        <h4 class="panel-title">
                                            <span class="entity-label">Outcome {{$count}} </span> 
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
                                                    <input type="text" name="outcomes[{{ $outcome->id }}][name]" class="form-control" value="{{ $outcome->name }}" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                            $totalUsed = $outcome->outputs()
                                            ->with(['activities.requisitions.accountability'])
                                            ->get()
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
                                            $outcomeremainingBudget = $outcome->budget - $totalUsed;
                                            $color = $remainingBudget < 0 ? 'red' : 'green';
                                        ?>

                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Outcome Budget (UGX)</label>
                                            <div class="col-sm-2">
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="fa fa-pencil fa-fw"></i>
                                                    </span>
                                                    <input type="text" name="outcomes[{{ $outcome->id }}][budget]" class="form-control" value="{{ number_format($outcome->budget) }}" readonly>
                                                </div>
                                            </div>
                                            <label class="col-sm-2 control-label">Used Budget (UGX)</label>
                                            <div class="col-sm-2">
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="fa fa-pencil fa-fw"></i>
                                                    </span>
                                                    <input type="text" name="outcomes[{{ $outcome->id }}][budget]" class="form-control" value="{{ number_format($totalUsed) }}" readonly>
                                                </div>
                                            </div>
                                            <label class="col-sm-2 control-label">Remaining Budget (UGX)</label>
                                            <div class="col-sm-2">
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="fa fa-pencil fa-fw"></i>
                                                    </span>
                                                    <input type="text" name="outcomes[{{ $outcome->id }}][budget]" class="form-control" value="{{ number_format($outcomeremainingBudget) }}" readonly>
                                                </div>
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
                                                                    <input type="text" name="outcomes[{{ $outcome->id }}][outputs][{{ $output->id }}][name]" class="form-control" value="{{ $output->name }}" readonly>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <?php
                                                            $totalUsed = $output->activities()
                                                            ->with(['requisitions.accountability'])
                                                            ->get()
                                                            ->flatMap(function ($activity) {
                                                                return $activity->requisitions;
                                                            })
                                                            ->map(function ($requisition) {         
                                                                return $requisition->accountability; 
                                                            })
                                                            ->filter()                              
                                                            ->sum('amount_used');
                                                        
                                                            // Calculate remaining budget
                                                            $outputremainingBudget = $output->budget - $totalUsed;
                                                            $color = $remainingBudget < 0 ? 'red' : 'green';
                                                        ?>

                                                        <div class="form-group">
                                                            <label class="col-sm-2 control-label">Output Budget (UGX)</label>
                                                            <div class="col-sm-2">
                                                                <div class="input-group">
                                                                    <span class="input-group-addon">
                                                                        <i class="fa fa-pencil fa-fw"></i>
                                                                    </span>
                                                                    <input type="text" name="outcomes[{{ $outcome->id }}][outputs][{{ $output->id }}][budget]" class="form-control" value="{{ number_format($output->budget) }}" readonly>
                                                                </div>
                                                            </div>
                                                            <label class="col-sm-2 control-label">Used Budget (UGX)</label>
                                                            <div class="col-sm-2">
                                                                <div class="input-group">
                                                                    <span class="input-group-addon">
                                                                        <i class="fa fa-pencil fa-fw"></i>
                                                                    </span>
                                                                    <input type="text" name="outcomes[{{ $outcome->id }}][outputs][{{ $output->id }}][budget]" class="form-control" value="{{ number_format($totalUsed) }}" readonly>
                                                                </div>
                                                            </div>
                                                            <label class="col-sm-2 control-label">Remaining Budget (UGX)</label>
                                                            <div class="col-sm-2">
                                                                <div class="input-group">
                                                                    <span class="input-group-addon">
                                                                        <i class="fa fa-pencil fa-fw"></i>
                                                                    </span>
                                                                    <input type="text" name="outcomes[{{ $outcome->id }}][outputs][{{ $output->id }}][budget]" class="form-control" value="{{ number_format($outputremainingBudget) }}" readonly>
                                                                </div>
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
                                                                                    <input type="text" name="outcomes[{{ $outcome->id }}][outputs][{{ $output->id }}][activities][{{ $activity->id }}][name]" class="form-control" value="{{ $activity->name }}" readonly>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <?php
                                                                            $totalUsed = $activity->requisitions()
                                                                            ->with(['accountability'])
                                                                            ->get()
                                                                            ->map(function ($requisition) {         
                                                                                return $requisition->accountability; 
                                                                            })
                                                                            ->filter()                              
                                                                            ->sum('amount_used');
                                                                        
                                                                            // Calculate remaining budget
                                                                            $activityremainingBudget = $activity->budget - $totalUsed;
                                                                            $color = $remainingBudget < 0 ? 'red' : 'green';
                                                                        ?>
                                                                        <div class="form-group">
                                                                            <label class="col-sm-2 control-label">Activity Budget</label>
                                                                            <div class="col-sm-2">
                                                                                <div class="input-group">
                                                                                    <span class="input-group-addon">
                                                                                        <i class="fa fa-pencil fa-fw"></i>
                                                                                    </span>
                                                                                    <input type="text" name="outcomes[{{ $outcome->id }}][outputs][{{ $output->id }}][activities][{{ $activity->id }}][budget]" class="form-control" value="{{ number_format($activity->budget) }}" readonly>
                                                                                </div>
                                                                            </div>
                                                                            <label class="col-sm-2 control-label">Used Budget</label>
                                                                            <div class="col-sm-2">
                                                                                <div class="input-group">
                                                                                    <span class="input-group-addon">
                                                                                        <i class="fa fa-pencil fa-fw"></i>
                                                                                    </span>
                                                                                    <input type="text" name="outcomes[{{ $outcome->id }}][outputs][{{ $output->id }}][activities][{{ $activity->id }}][budget]" class="form-control" value="{{ number_format($totalUsed) }}" readonly>
                                                                                </div>
                                                                            </div>
                                                                            <label class="col-sm-2 control-label">Remaining Budget</label>
                                                                            <div class="col-sm-2">
                                                                                <div class="input-group">
                                                                                    <span class="input-group-addon">
                                                                                        <i class="fa fa-pencil fa-fw"></i>
                                                                                    </span>
                                                                                    <input type="text" name="outcomes[{{ $outcome->id }}][outputs][{{ $output->id }}][activities][{{ $activity->id }}][budget]" class="form-control" value="{{number_format($activityremainingBudget, 0) }}" readonly>
                                                                                </div>
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
                                                                                                    <input type="text" name="outcomes[{{ $outcome->id }}][outputs][{{ $output->id }}][activities][{{ $activity->id }}][budget_lines][{{ $budget_line->id }}][name]" class="form-control" value="{{ $budget_line->name }}" readonly>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="form-group">
                                                                                            <label class="col-sm-2 control-label"> Unit Cost  (UGX)</label>
                                                                                            <div class="col-sm-8">
                                                                                                <div class="input-group">
                                                                                                    <span class="input-group-addon">
                                                                                                        <i class="fa fa-pencil fa-fw"></i>
                                                                                                    </span>
                                                                                                    <input type="text" name="outcomes[{{ $outcome->id }}][outputs][{{ $output->id }}][activities][{{ $activity->id }}][budget_lines][{{ $budget_line->id }}][unitcost]" class="form-control" value="{{  number_format($budget_line->unitcost) }}" readonly>
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
                                                                                                    <input type="text" name="outcomes[{{ $outcome->id }}][outputs][{{ $output->id }}][activities][{{ $activity->id }}][budget_lines][{{ $budget_line->id }}][quantity]" class="form-control" value="{{ $budget_line->quantity }}" readonly>
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
                                                                                                    <input type="text" name="outcomes[{{ $outcome->id }}][outputs][{{ $output->id }}][activities][{{ $activity->id }}][budget_lines][{{ $budget_line->id }}][frequency]" class="form-control" value="{{ $budget_line->frequency}}" readonly>
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
                                                                                                    <input type="text" name="outcomes[{{ $outcome->id }}][outputs][{{ $output->id }}][activities][{{ $activity->id }}][budget_lines][{{ $budget_line->id }}][budget]" class="form-control" value="{{ number_format($budget_line->budget, 0) }}" readonly>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                        
                                                                                    </div>
                                                                                </div>
                                                                            @endforeach
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
                                                                        
                                                                        {{-- </div> --}}
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                        
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                        
                                        
                                    </div>
                                </div>
                            @endforeach
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
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($program->activities->where('name', 'M and E') as $MEData)
                                                @foreach ($MEData->budget_lines as $MEbudgetLineData)
                                                <tr>
                                                    <td class="pd">
                                                        <input type="text" name="MEbudget_lines[${MandEIndex}][name]" value="{{ $MEbudgetLineData->name }}" class="form-control inputx" readonly>
                                                    </td>
                                                    <td class="pd">
                                                        <input type="text" name="MEbudget_lines[${MandEIndex}][units]" value="{{ $MEbudgetLineData->name }}" class="form-control inputx " readonly>
                                                    </td>
                                                    <td class="pd">
                                                        <input type="number" name="MEbudget_lines[${MandEIndex}][unitcost]" value="{{ $MEbudgetLineData->unitcost }}" class="form-control inputx calc-field" readonly >
                                                    </td>
                                                    <td class="pd">
                                                        <input type="number" name="MEbudget_lines[${MandEIndex}][quantity]" value="{{ $MEbudgetLineData->quantity }}" class="form-control inputx calc-field" readonly>
                                                    </td>
                                                    <td class="pd">
                                                        <input type="number" name="MEbudget_lines[${MandEIndex}][frequency]" value="{{ $MEbudgetLineData->frequency }}" class="form-control inputx calc-field" readonly>
                                                    </td>
                                                    <td class="pd">
                                                        <input type="number" name="MEbudget_lines[${MandEIndex}][budget]" value="{{ $MEbudgetLineData->budget }}" class="form-control inputx budget-field" readonly>
                                                    </td>
                                                    <td class="pd">
                                                        <input type="number" name="MEbudget_lines[${MandEIndex}][dev_org]" value="{{ $MEbudgetLineData->dev_Vs_Org }}" class="form-control inputx" readonly>
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
                                                        {{-- <strong id="budget-total-display">0.00</strong> --}}
                                                        <input type="number" name="MandEBudget" id="budget-total-input" class="form-control inputx"  value="{{$program->activities->where('name', 'M and E')->first()->budget}}" readonly>
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
</script>
</body>
</html>
