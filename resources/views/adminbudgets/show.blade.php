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
        .panel-body {
            display: none;
        }

        .outcomes,
        .outputs,
        .activities,
        .budgetlines {
            cursor: pointer;
            position: relative;
            padding-right: 30px;
        }

        /* Add toggle indicators */
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
        }

        .panel.collapsed,
        .outcomes::after,
        /* .outputs::after, */
        /* .activities::after*/ { 
            transform: translateY(-50%) rotate(-90deg);
        }
        /* Show panel body when not collapsed */
        .panel:not(.collapsed) > .panel-body {
            display: block;
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
                                            {{-- <label class="col-sm-2 control-label">Remaining Budget</label>
                                            <div class="col-sm-4">
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="fa fa-pencil fa-fw"></i>
                                                    </span>
                                                    <input type="number" name="outcomes[{{ $outcome->id }}][budget]" class="form-control" value="{{ $outcomeremainingBudget }}" readonly>
                                                </div>
                                            </div> --}}
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
                                                            // $totalUsed = $output->activities()
                                                            // ->with(['requisitions.accountability'])
                                                            // ->get()
                                                            // ->flatMap(function ($activity) {
                                                            //     return $activity->requisitions;
                                                            // })
                                                            // ->map(function ($requisition) {         
                                                            //     return $requisition->accountability; 
                                                            // })
                                                            // ->filter()                              
                                                            // ->sum('amount_used');
                                                        
                                                            // // Calculate remaining budget
                                                            // $outputremainingBudget = $output->budget - $totalUsed;
                                                            // $color = $remainingBudget < 0 ? 'red' : 'green';
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
                                                            {{-- <label class="col-sm-2 control-label">Remaining Budget</label>
                                                            <div class="col-sm-4">
                                                                <div class="input-group">
                                                                    <span class="input-group-addon">
                                                                        <i class="fa fa-pencil fa-fw"></i>
                                                                    </span>
                                                                    <input type="number" name="outcomes[{{ $outcome->id }}][outputs][{{ $output->id }}][budget]" class="form-control" value="{{ $outputremainingBudget }}" readonly>
                                                                </div>
                                                            </div> --}}
                                                        </div>

                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                        
                                        
                                    </div>
                                </div>
                            @endforeach
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
