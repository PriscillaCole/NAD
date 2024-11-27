{{-- <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet"> --}}
    <style>
        .ml-4 {
            margin-left: 1.5rem;
        }
        .ml-5 {
            margin-left: 3rem;
        }
    </style>
<div class="row">
    <div class="col-md-12">
      <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title">Create</h3>
            <div class="box-tools">
              <div class="btn-group pull-right" style="margin-right: 5px;">
                <a href="http://127.0.0.1:8000/requisitions" class="btn btn-sm btn-default" title="List"></a>
              </div>
            </div>
        </div>
        
        <div class="box-body">
            <form action="{{url('programs/create')}}" method="POST" id="programForm" class="form-horizontal model-form-6742cbb112c9d" accept-charset="UTF-8" enctype="multipart/form-data" pjax-container>
                @csrf
            
                <div class="fields-group">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="name" class="col-sm-2 control-label">Program Name</label>
                            <div id="step1" class="col-sm-8">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-pencil fa-fw"></i>
                                    </span>
                                    <input type="text" name="name" class="form-control" placeholder="Enter Program Name" required />
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="description" class="col-sm-2 asterisk control-label">Program Description</label>
                            <div class="col-sm-8">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-pencil fa-fw"></i>
                                    </span>
                                    <textarea type="text" name="name" class="form-control" placeholder="Enter Program Description" required ></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="outcome border rounded p-1 mb-3" id="outcomes">
                            <div class="outcome-template d-none">   
                                <div class="form-group" >
                                    <label for="outcome_name" class="col-sm-2 asterisk control-label">Outcome Name</label>
                                    <div class="col-sm-8" >
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="fa fa-pencil fa-fw"></i>
                                            </span>
                                            <input type="text" name="outcomes[__INDEX__][name]" class="form-control mb-2" placeholder="Enter Outcome Name" required />
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group" >
                                    <label for="outcome_budget" class="col-sm-2 asterisk control-label">Outcome Budget</label>
                                    <div class="col-sm-8" >
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="fa fa-pencil fa-fw"></i>
                                            </span>
                                            <input type="text" name="outcomes[__INDEX__][budget]" class="form-control mb-2" placeholder="Enter Outcome Name" required />
                                        </div>
                                    </div>
                                </div>
                                {{-- <button type="button" class="btn btn-warning btn-sm pull-right" onclick="removeOutcome(this)">Remove</button> --}}
                                <button type="button" class="btn btn-primary" onclick="showOutputSection(this)">Add Output</button>
        
                                <!-- Step 3: Outputs -->
                                <div class="outputs col-md-offset-1" style="display: none;">
                                    <h5>Outputs for this Outcome</h5>
                                    <div class="output-template d-none">
                                        <div class="output border rounded p-2 mb-2">
                                            <div class="row mb-2">
                                                <label for="output_name" class="col-sm-2 asterisk control-label">Output Name</label>
                                                <div class="col-sm-10">
                                                    <input type="text" name="outcomes[__INDEX__][outputs][__SUBINDEX__][name]" class="form-control" placeholder="Enter Output Name" required />
                                                </div>
                                            </div>
                                            <div class="row mb-2">
                                                <label for="output_budget" class="col-sm-2 asterisk control-label">Outcome Budget</label>
                                                <div class="col-sm-10">
                                                    <input type="text" name="outcomes[__INDEX__][outputs][__SUBINDEX__][budget]" class="form-control" placeholder="Enter Outcome Budget" required />
                                                </div>
                                            </div>
                                            <button type="button" class="btn btn-warning btn-sm pull-right" onclick="removeOutput(this)">Remove</button>
                                            <button type="button" class="btn btn-success" onclick="showActivitySection(this)">Add Activity</button>
        
                                            <!-- Step 4: Activities -->
                                            <div class="activities col-md-offset-1" style="display: none;">
                                                <h6>Activities for this Output</h6>
                                                <div class="activity-template d-none">
                                                    <div class="activity border rounded p-2 mb-2">
                                                        <div class="row mb-2">
                                                            <label for="activity_name" class="col-sm-2 asterisk control-label">Activity Name</label>
                                                            <div class="col-sm-10">
                                                                <input type="text" name="outcomes[__INDEX__][outputs][__SUBINDEX__][activities][__ACTIVITYINDEX__][name]" class="form-control mb-2" placeholder="Enter Activity Name" required />
                                                            </div>
                                                        </div>
                                                        <div class="row mb-2">
                                                            <label for="output_budget" class="col-sm-2 asterisk control-label">Activity Budget</label>
                                                            <div class="col-sm-10">
                                                                <input type="text" name="outcomes[__INDEX__][outputs][__SUBINDEX__][activities][__ACTIVITYINDEX__][budget]" class="form-control mb-2" placeholder="Enter Outcome Budget" required />
                                                            </div>
                                                        </div>
                                                        <button type="button" class="btn btn-warning btn-sm pull-right" onclick="removeActivity(this)">Remove</button>
                                                        <button type="button" class="btn btn-success" onclick="showBudgetSection(this)">Add Budget Line</button>
        
                                                        <!-- Step 5: Budget Lines -->
                                                        <div class="budget-lines col-md-offset-1" style="display: none;">
                                                            <h6>Budget Lines for this Activity</h6>
                                                            <div class="budget-line-template d-none">
                                                                <div class="budget-line border rounded p-2 mb-2">
                                                                    <div class="row mb-2">
                                                                        <label for="budget_line_name" class="col-sm-2 asterisk control-label">Budget Line</label>
                                                                        <div class="col-sm-10">
                                                                            <input type="text" name="outcomes[__INDEX__][outputs][__SUBINDEX__][activities][__ACTIVITYINDEX__][budget_lines][__LINEINDEX__][name]" class="form-control mb-2" placeholder="Enter Budget Line Name" required />
                                                                        </div>
                                                                    </div>
                                                                    <div class="row mb-2">
                                                                        <label for="budget_line_amount" class="col-sm-2 asterisk control-label">Amount</label>
                                                                        <div class="col-sm-10">
                                                                            <input type="number" name="outcomes[__INDEX__][outputs][__SUBINDEX__][activities][__ACTIVITYINDEX__][budget_lines][__LINEINDEX__][amount]" class="form-control" placeholder="Enter Amount" required />
                                                                        </div>
                                                                    </div>
                                                                    <div class="row mb-2">
                                                                        <label for="unit_cost" class="col-sm-2 asterisk control-label">Unit Cost</label>
                                                                        <div class="col-sm-10">
                                                                            <input type="number" name="outcomes[__INDEX__][outputs][__SUBINDEX__][activities][__ACTIVITYINDEX__][budget_lines][__LINEINDEX__][unit_cost]" class="form-control" placeholder="Enter Amount" required />
                                                                        </div>
                                                                    </div>
                                                                    <div class="row mb-2">
                                                                        <label for="quantity" class="col-sm-2 asterisk control-label">Quantity</label>
                                                                        <div class="col-sm-10">
                                                                            <input type="number" name="outcomes[__INDEX__][outputs][__SUBINDEX__][activities][__ACTIVITYINDEX__][budget_lines][__LINEINDEX__][quantity]" class="form-control" placeholder="Enter Amount" required />
                                                                        </div>
                                                                    </div>
                                                                    <div class="row mb-2">
                                                                        <label for="frequency" class="col-sm-2 asterisk control-label">Frequency</label>
                                                                        <div class="col-sm-10">
                                                                            <input type="number" name="outcomes[__INDEX__][outputs][__SUBINDEX__][activities][__ACTIVITYINDEX__][budget_lines][__LINEINDEX__][frequency]" class="form-control" placeholder="Enter Amount" required />
                                                                        </div>
                                                                    </div>
                                                                    <button type="button" class="btn btn-danger btn-sm pull-right" onclick="removeBudgetLine(this)">Remove</button>
                                                                </div>
                                                            </div>
                                                            <button type="button" class="btn btn-success btn-sm mb-2" onclick="addBudgetLine(this)">Add Budget Line</button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <button type="button" class="btn btn-success btn-sm mb-3" onclick="addActivity(this)">Add Activity</button>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="button" class="btn btn-success btn-sm mb-3" onclick="addOutput(this)">Add Output</button>
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn btn-success mb-3" onclick="addOutcome()">Add Outcome</button>
                        <button type="submit" class="btn btn-primary">Save Program</button>
                    </div>
                </div>
            </form>
        </div>
            
      </div>
    </div>
</div>

<script>
    function showOutputSection(button) {
        const outputsDiv = button.nextElementSibling;
        outputsDiv.style.display = 'block';
        addOutput(button);
    }

    function showActivitySection(button) {
        const activitiesDiv = button.nextElementSibling;
        activitiesDiv.style.display = 'block';
        addActivity(button);
    }

    function showBudgetSection(button) {
        const budgetDiv = button.nextElementSibling;
        budgetDiv.style.display = 'block';
        addBudgetLine(button);
    }

    function addOutcome() {
        const template = document.querySelector('.outcome-template').cloneNode(true);
        template.classList.remove('d-none', 'outcome-template');
        const index = Date.now();
        
        let content = template.innerHTML;
        content = content.replace(/__INDEX__/g, index);
        content = content.replace(/__SUBINDEX__/g, '0');
        content = content.replace(/__ACTIVITYINDEX__/g, '0');
        content = content.replace(/__LINEINDEX__/g, '0');
        
        template.innerHTML = content;
        document.getElementById('outcomes').appendChild(template);
    }

    function removeOutcome(button) {
        if(confirm('Are you sure you want to remove this outcome?')) {
            button.closest('.outcome').remove();
        }
    }

    function addOutput(button) {
        const outcomeDiv = button.closest('.outcome');
        const outputsDiv = outcomeDiv.querySelector('.outputs');
        const template = outcomeDiv.querySelector('.output-template').cloneNode(true);
        template.classList.remove('d-none', 'output-template');
        const index = Date.now();
        
        const outcomeIndex = outcomeDiv.querySelector('input[name^="outcomes"]')
            .name.match(/outcomes\[(\d+)\]/)[1];
            
        let content = template.innerHTML;
        content = content.replace(/__INDEX__/g, outcomeIndex);
        content = content.replace(/__SUBINDEX__/g, index);
        content = content.replace(/__ACTIVITYINDEX__/g, '0');
        content = content.replace(/__LINEINDEX__/g, '0');
        
        template.innerHTML = content;
        outputsDiv.appendChild(template);
    }

    function removeOutput(button) {
        if(confirm('Are you sure you want to remove this output?')) {
            button.closest('.output').remove();
        }
    }

    function addActivity(button) {
        const outputDiv = button.closest('.output');
        const activitiesDiv = outputDiv.querySelector('.activities');
        const template = outputDiv.querySelector('.activity-template').cloneNode(true);
        template.classList.remove('d-none', 'activity-template');
        const index = Date.now();

        const nameMatch = outputDiv.querySelector('input[name^="outcomes"]')
            .name.match(/outcomes\[(\d+)\]\[outputs\]\[(\d+)\]/);
        const outcomeIndex = nameMatch[1];
        const outputIndex = nameMatch[2];

        let content = template.innerHTML;
        content = content.replace(/__INDEX__/g, outcomeIndex);
        content = content.replace(/__SUBINDEX__/g, outputIndex);
        content = content.replace(/__ACTIVITYINDEX__/g, index);
        content = content.replace(/__LINEINDEX__/g, '0');

        template.innerHTML = content;
        activitiesDiv.appendChild(template);
    }

    function removeActivity(button) {
        if(confirm('Are you sure you want to remove this activity?')) {
            button.closest('.activity').remove();
        }
    }

    function addBudgetLine(button) {
        const activityDiv = button.closest('.activity');
        const budgetLinesDiv = activityDiv.querySelector('.budget-lines');
        const template = activityDiv.querySelector('.budget-line-template').cloneNode(true);
        template.classList.remove('d-none', 'budget-line-template');
        const index = Date.now();

        const nameMatch = activityDiv.querySelector('input[name^="outcomes"]')
            .name.match(/outcomes\[(\d+)\]\[outputs\]\[(\d+)\]\[activities\]\[(\d+)\]/);
        const outcomeIndex = nameMatch[1];
        const outputIndex = nameMatch[2];
        const activityIndex = nameMatch[3];

        let content = template.innerHTML;
        content = content.replace(/__INDEX__/g, outcomeIndex);
        content = content.replace(/__SUBINDEX__/g, outputIndex);
        content = content.replace(/__ACTIVITYINDEX__/g, activityIndex);
        content = content.replace(/__LINEINDEX__/g, index);

        template.innerHTML = content;
        budgetLinesDiv.appendChild(template);
    }

    function removeBudgetLine(button) {
        if(confirm('Are you sure you want to remove this budget line?')) {
            button.closest('.budget-line').remove();
        }
    }
</script>
