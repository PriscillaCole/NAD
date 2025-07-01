<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Program</title>
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
        
        .outcomes,
        .outputs,
        .activities,
        .budgetlines {
            cursor: pointer;
            position: relative;
            padding-right: 30px;
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
                    <form action="{{ url('adminBudget/'. $adminprogram->id.'/edit') }}" method="POST" id="programEditForm" class="form-horizontal" onsubmit="removeFormattingBeforeSubmit()" enctype="multipart/form-data">
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
                                    <input type="text" name="name" class="form-control" readonly value="{{ $adminprogram->name }}" required />
                                </div>
                            </div>
                        </div>

                        <!-- Program Description -->
                        <div class="form-group">
                            <label for="description" class="col-sm-2 control-label">Program Description</label>
                            <div class="col-sm-8">
                                <textarea name="description" class="form-control" readonly required>{{ $adminprogram->description }}</textarea>
                            </div>
                        </div>

                        <!-- Program budget -->
                        {{-- <div class="form-group">
                            <label for="description" class="col-sm-2 control-label">Program Budget</label>
                            <div class="col-sm-8">
                                <textarea name="budget" class="form-control" readonly required>{{ $adminprogram->budget }}</textarea>
                            </div>
                        </div> --}}
                        <div class="form-group">
                            <label for="name" class="col-sm-2 control-label">Program Budget (UGX)</label>
                            <div class="col-sm-8">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-pencil fa-fw"></i>
                                    </span>
                                    <?php
                                        // Get the program's initial budget
                                        if (!is_null($adminprogram->third_budget)) {
                                            $totalBudget = $adminprogram->third_budget;
                                        } elseif (!is_null($adminprogram->second_budget)) {
                                            $totalBudget = $proadminprogramgram->second_budget;
                                        } elseif (!is_null($adminprogram->budget)) {
                                            $totalBudget = $adminprogram->budget;
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
                        
                            @foreach ($adminprogram->adminActivities as $adminActivity)
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
                                                    <input type="text" name="outcomes[{{ $adminActivity->id }}][name]" class="form-control" value="{{ $adminActivity->name }}" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Outcome Budget</label>
                                            <div class="col-sm-8">
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="fa fa-pencil fa-fw"></i>
                                                    </span>
                                                     {{-- <input type="text" name="outcomes[{{ $outcome->id }}][outputs][{{ $output->id }}][activities][{{ $activity->id }}][budget_lines][{{ $budget_line->id }}][budget]" oninput= "formatNumber(event)" class="form-control formatted-input" value=" {{($budget_line->budget) }}" required> --}}
                                                   
                                                    <input type="text" name="outcomes[{{ $adminActivity->id }}][budget]" class="form-control formatted-input" value="{{ $adminActivity->budget }}" required>
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
                                                                    <input type="text" name="outcomes[{{ $adminActivity->id }}][outputs][{{ $adminBudgetLine->id }}][name]" class="form-control" value="{{ $adminBudgetLine->name }}" required>
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
                                                                    <input type="text" name="outcomes[{{ $adminActivity->id }}][outputs][{{ $adminBudgetLine->id }}][unitcost]" class="form-control formatted-input" value="{{ $adminBudgetLine->unit_cost }}" required>
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
                                                                    <input type="text" name="outcomes[{{ $adminActivity->id }}][outputs][{{ $adminBudgetLine->id }}][quantity]" class="form-control" value="{{ $adminBudgetLine->quantity }}" required>
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
                                                                    <input type="text" name="outcomes[{{ $adminActivity->id }}][outputs][{{ $adminBudgetLine->id }}][frequency]" class="form-control" value="{{ $adminBudgetLine->frequency }}" required>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                        <label class="col-sm-2 control-label"> Unit </label>
                                                        <div class="col-sm-8">
                                                            <div class="input-group">
                                                                <span class="input-group-addon">
                                                                    <i class="fa fa-pencil fa-fw"></i>
                                                                </span>
                                                                <input type="text" name="outcomes[{{ $adminActivity->id }}][outputs][{{ $adminBudgetLine->id }}][unit]" class="form-control" value="{{ $adminBudgetLine->units }}" placeholder="Enter Units"  required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                        <div class="form-group">
                                                            <label class="col-sm-2 control-label">Output Budget</label>
                                                            <div class="col-sm-8">
                                                                <div class="input-group">
                                                                    <span class="input-group-addon">
                                                                        <i class="fa fa-pencil fa-fw"></i>
                                                                    </span>
                                                                    <input readonly type="text" name="outcomes[{{ $adminActivity->id }}][outputs][{{ $adminBudgetLine->id }}][budget]" class="form-control formatted-input" value="{{ $adminBudgetLine->total_cost }}" required>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!-- Activities Section -->
                                                        
                                                        <div class="form-group">
                                                            <div class="col-sm-8 col-sm-offset-2" style="display: flex; justify-content: flex-end; align-items: center;">
                    
                                                                <!-- Delete Button with Bin Icon -->
                                                              <button type="button" class="btn btn-danger btn-delete"  onclick="deleteOutput({{$adminBudgetLine->id}})">
                                                                  <i class="fa fa-trash"></i> Delete
                                                              </button>
                                                          </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                        
                                        <div class="form-group">
                                            <div class="col-sm-8 col-sm-offset-2" style="display: flex; justify-content: space-between; align-items: center;">
                                                <button type="button" class="btn btn-info btn-add" onclick="addOutput({{$adminActivity->id}})">Add Output</button>
                                                
                                                <!-- Delete Button with Bin Icon -->
                                                <button type="button" class="btn btn-danger btn-delete" onclick="deleteOutcome({{$adminActivity->id}})">
                                                    <i class="fa fa-trash"></i> Delete
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
