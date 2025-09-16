<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Show Program</title>
    {{-- <style>
        .ml-4 { margin-left: 1.5rem; }
        .ml-5 { margin-left: 3rem; }
        .btn-add { margin-top: 10px; margin-bottom: 10px; }
        .delete-btn { color: red; cursor: pointer; margin-left: 10px; }
        .panel-body { padding: 15px; }
        .entity-label { font-weight: bold; margin-right: 10px; }
        .text-right { text-align: right; }
    </style> --}}

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

        /* Add toggle indicators
        .outcomes::after,
        .outputs::after,
        .activities::after,
        .budgetlines::after {
            content: '▼';
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            transition: transform 0.3s ease;
        } */

        /* .panel.collapsed,
        .outcomes::after, */
        /* .outputs::after, */
        /* .activities::after { 
            transform: translateY(-50%) rotate(-90deg);
        } */
        /* Show panel body when not collapsed */
        /* .panel:not(.collapsed) > .panel-body {
            display: block;
        } */

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
    <script src="{{asset('js')}}/adminbudget.js"></script>
</head>
<body>
<div class="col-md-12">
    <div class="row">
        <div>
            <!-- Program Edit Box -->
            <div class="panel panel-info">
                <div class="panel-heading bg-primary" style="background-color: transparent; display: flex; justify-content: space-between; align-items: center; border-top: 4px solid #87cefa;">
                    <h3 class="panel-title" style="margin: 0;">Edit Program</h3>
                    <div class="btn-group">
                        <a href="{{ url('adminBudget') }}" class="btn btn-sm btn-default" title="List">
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
                        // $totalUsed = $program->adminActivities()
                        // ->with(['adminBudgetLines.requisitions.accountability'])
                        // ->get()
                        // ->flatMap(function ($outcome) {
                        //     return $outcome->outputs;
                        // })
                        // ->flatMap(function ($output) {
                        //     return $output->activities;
                        // })
                        // ->flatMap(function ($activity) {
                        //     return $activity->requisitions;
                        // })
                        // ->map(function ($requisition) {         
                        //     return $requisition->accountability; 
                        // })
                        // ->filter()                              
                        // ->sum('amount_used');
                    
                        // // Calculate remaining budget
                        // $remainingBudget = $program->budget - $totalUsed;
                        // $color = $remainingBudget < 0 ? 'red' : 'green';
                        
                        // Format the number as currency
                        // return "<span style='color: {$color};'>" . number_format($remainingBudget, 2) . "</span>";
                    ?>
                        <div class="form-group">
                            <label for="description" class="col-sm-2 control-label">Program Budget</label>
                            <div class="col-sm-4">
                                <input type="text" name="budget" class="form-control" value="{{ $program->budget }}" readonly />
                            </div>
                            {{-- <label for="description" class="col-sm-2 control-label">Remaining amount</label>
                            <div class="col-sm-4">
                                <input type="text" name="budget" class="form-control" value="{{ $remainingBudget }}" readonly />
                            </div> --}}
                        </div>

                        <!-- Outcome Section -->
                        <div id="outcomes">
                        
                            @foreach ($program->adminActivities as $adminActivity)
                                <div class="panel panel-default outcome" id="outcome-{{ $adminActivity->id }}">
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
                                                    <input type="text" name="outcomes[{{ $adminActivity->id }}][name]" class="form-control" value="{{ $adminActivity->name }}" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                            // $totalUsed = $adminActivity->adminBudgetLines()
                                            // ->with(['requisitions.accountability'])
                                            // ->get()
                                            // ->flatMap(function ($output) {
                                            //     return $output->activities;
                                            // })
                                            // ->flatMap(function ($activity) {
                                            //     return $activity->requisitions;
                                            // })
                                            // ->map(function ($requisition) {         
                                            //     return $requisition->accountability; 
                                            // })
                                            // ->filter()                              
                                            // ->sum('amount_used');
                                        
                                            // // Calculate remaining budget
                                            // $outcomeremainingBudget = $adminActivity->budget - $totalUsed;
                                            // $color = $remainingBudget < 0 ? 'red' : 'green';
                                        ?>

                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Outcome Budget</label>
                                            <div class="col-sm-4">
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="fa fa-pencil fa-fw"></i>
                                                    </span>
                                                    <input type="number" name="outcomes[{{ $adminActivity->id }}][budget]" class="form-control" value="{{ $adminActivity->budget }}" readonly>
                                                </div>
                                            </div>
                                            
                                        </div>
                                        
                                        <!-- Outputs Section -->
                                        <div id="outputs-{{ $adminActivity->id }}">
                                            @foreach ($adminActivity->adminBudgetLines as $adminBudgetLine)
                                                <div class="panel panel-default output" id="output-{{ $adminBudgetLine->id }}">
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
                                                                    <input type="text" name="outcomes[{{ $adminBudgetLine->id }}][outputs][{{ $adminBudgetLine->id }}][name]" class="form-control" value="{{ $adminBudgetLine->name }}" readonly>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <?php
                                                           
                                                        ?>

                                                        <div class="form-group">
                                                            <label class="col-sm-2 control-label">Output Budget</label>
                                                            <div class="col-sm-4">
                                                                <div class="input-group">
                                                                    <span class="input-group-addon">
                                                                        <i class="fa fa-pencil fa-fw"></i>
                                                                    </span>
                                                                    <input type="number" name="outcomes[{{ $adminBudgetLine->id }}][outputs][{{ $adminBudgetLine->id }}][budget]" class="form-control" value="{{ $adminBudgetLine->budget }}" readonly>
                                                                </div>
                                                            </div>
                                                            
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
                                                @foreach ($program->adminActivities->where('name', 'M and E') as $MEData)
                                                @foreach ($MEData->adminBudgetLines as $MEbudgetLineData)
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
                                                        <input type="number" name="MEbudget_lines[${MandEIndex}][budget]" value="{{ $MEbudgetLineData->total_cost }}" class="form-control inputx budget-field" readonly>
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
                                                        <input type="number" name="MandEBudget" id="budget-total-input" class="form-control inputx"  value="{{$program->adminActivities->where('name', 'M and E')->first()?->budget}}" readonly>
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
