
let outcomeCounter = 0;

// Function to add a new Outcome
function addOutcome() {
    outcomeCounter++;
    const outcomesContainer = document.getElementById("outcomes");
    const outcomeId = Date.now();

    const outcomeTemplate = `
        <div class="panel panel-default outcome" id="outcome-${outcomeId}">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <span class="entity-label">Outcome ${outcomeCounter}</span> 
                   
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
                        <input type="text" name="outcomes[${outcomeId}][name]" class="form-control" placeholder="Enter Outcome Name" required>
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
                        <input type="number" name="outcomes[${outcomeId}][budget]" class="form-control" placeholder="Enter Outcome Budget" required>
                        </div>
                    </div>
                </div>

                <!-- Outputs Section -->
                <div id="outputs-${outcomeId}"></div>
               <div class="form-group">
                    <div class="col-sm-8 col-sm-offset-2" style="display: flex; justify-content: space-between; align-items: center;">
                        <button type="button" class="btn btn-info btn-add" onclick="addOutput(${outcomeId})">Add Output</button>
                        
                        <!-- Delete Button with Bin Icon -->
                        <button type="button" class="btn btn-danger btn-delete" onclick="deleteOutcome(${outcomeId})">
                            <i class="fa fa-trash"></i> Delete
                        </button>
                    </div>
                </div>

            </div>
        </div>
    `;

    outcomesContainer.insertAdjacentHTML('beforeend', outcomeTemplate);
}

// Function to add a new Output under an Outcome
function addOutput(outcomeId) {
    const outputsContainer = document.getElementById(`outputs-${outcomeId}`);
    const outputCount = outputsContainer.children.length + 1;
    const outputId = Date.now();

    const outputTemplate = `
        <div class="panel panel-default output" id="output-${outputId}">
            <div class="panel-heading">
                <h5 class="panel-title">
                    <span class="entity-label">Output ${outcomeCounter}.${outputCount}</span> 
                    
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
                        <input type="text" name="outcomes[${outcomeId}][outputs][${outputId}][name]" class="form-control" placeholder="Enter Output Name" required>
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
                        <input type="number" name="outcomes[${outcomeId}][outputs][${outputId}][budget]" class="form-control" placeholder="Enter Output Budget" required>
                    </div>
                    </div>
                </div>

                <!-- Activities Section -->
                <div class="form-group">
                    <div class="col-sm-8 col-sm-offset-2" style="display: flex; justify-content: flex-end; align-items: center;">
                        <!-- Delete Button with Bin Icon -->
                        <button type="button" class="btn btn-danger btn-delete" onclick="deleteOutput(${outputId})">
                            <i class="fa fa-trash"></i> Delete
                        </button>
                    </div>
                </div>
                
                </div>
            </div>
        </div>
    `;

    outputsContainer.insertAdjacentHTML('beforeend', outputTemplate);
}

// Function to add a new Activity under an Output
function addActivity(outputId, outcomeId) {
    const activitiesContainer = document.getElementById(`activities-${outputId}`);
    const activityCount = activitiesContainer.children.length + 1;
    const activityId = Date.now();

    const activityTemplate = `
        <div class="panel panel-default activity" id="activity-${activityId}">
            <div class="panel-heading">
                <h6 class="panel-title">
                    <span class="entity-label">Activity ${outcomeCounter}.${activityCount}</span> 
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
                        <input type="text" name="outcomes[${outcomeId}][outputs][${outputId}][activities][${activityId}][name]" class="form-control" placeholder="Enter Activity Name" required>
                    </div>
                    </div>
                </div>
                   <div class="form-group">
                    <label class="col-sm-2 control-label">Activity Budget</label>
                    <div class="col-sm-8">
                     <div class="input-group">
                      <span class="input-group-addon">
                            <i class="fa fa-pencil fa-fw"></i>
                        </span>
                        <input type="number" name="outcomes[${outcomeId}][outputs][${outputId}][activities][${activityId}][budget]" class="form-control" placeholder="Enter Activity Budget" required>
                    </div>
                    </div>
                </div>

                <!-- Budget Lines Section -->
                <div id="budget-lines-${activityId}"></div>
                <div class="form-group">
                    <div class="col-sm-8 col-sm-offset-2" style="display: flex; justify-content: space-between; align-items: center;">
                   <button type="button" class="btn btn-secondary btn-add" onclick="addBudgetLine(${activityId}, ${outputId}, ${outcomeId})">Add Budget Line</button>

                    <!-- Delete Button with Bin Icon -->
                    <button type="button" class="btn btn-danger btn-delete"  onclick="deleteActivity(${activityId})">
                        <i class="fa fa-trash"></i> Delete
                    </button>
                </div>
                </div>
            </div>
        </div>
    `;

    activitiesContainer.insertAdjacentHTML('beforeend', activityTemplate);
}

// function addActivity(outputId, outcomeId) {
//     const activitiesContainer = document.getElementById(`activities-${outputId}`);
//     const activityCount = activitiesContainer.children.length + 1;
//     const activityId = Date.now();

//     const activityTemplate = `
//         <div class="panel panel-default activity" id="activity-${activityId}">
//             <div class="panel-heading">
//                 <h6 class="panel-title">
//                     <span class="entity-label">Activity ${outcomeCounter}.${activityCount}</span> 
//                 </h6>
//             </div>
//             <div class="panel-body">
//                 <!-- Activity Fields -->
//                 <div class="form-group">
//                     <label class="col-sm-2 control-label">Activity Name</label>
//                     <div class="col-sm-8">
//                         <div class="input-group">
//                             <span class="input-group-addon">
//                                 <i class="fa fa-pencil fa-fw"></i>
//                             </span>
//                             <input type="text" name="outcomes[${outcomeId}][outputs][${outputId}][activities][${activityId}][name]" class="form-control" placeholder="Enter Activity Name" required>
//                         </div>
//                     </div>
//                 </div>
//                 <div class="form-group">
//                     <label class="col-sm-2 control-label">Activity Budget</label>
//                     <div class="col-sm-8">
//                         <div class="input-group">
//                             <span class="input-group-addon">
//                                 <i class="fa fa-pencil fa-fw"></i>
//                             </span>
//                             <input type="number" id="activity-budget-${activityId}" name="outcomes[${outcomeId}][outputs][${outputId}][activities][${activityId}][budget]" class="form-control activity-budget" placeholder="Activity Budget" readonly required>
//                         </div>
//                     </div>
//                 </div>

//                 <!-- Budget Lines Section -->
//                 <div id="budget-lines-${activityId}"></div>
//                 <div class="form-group">
//                     <div class="col-sm-8 col-sm-offset-2" style="display: flex; justify-content: space-between; align-items: center;">
//                         <button type="button" class="btn btn-secondary btn-add" onclick="addBudgetLine(${activityId}, ${outputId}, ${outcomeId})">Add Budget Line</button>

//                         <!-- Delete Button with Bin Icon -->
//                         <button type="button" class="btn btn-danger btn-delete" onclick="deleteActivity(${activityId})">
//                             <i class="fa fa-trash"></i> Delete
//                         </button>
//                     </div>
//                 </div>
//             </div>
//         </div>
//     `;

//     activitiesContainer.insertAdjacentHTML('beforeend', activityTemplate);

//     // Function to recalculate the Activity Budget
//     function recalculateActivityBudget() {
//         const budgetLinesContainer = document.getElementById(`budget-lines-${activityId}`);
//         const budgetInputs = budgetLinesContainer.querySelectorAll('.budget');
//         let totalBudget = 0;

//         budgetInputs.forEach((input) => {
//             totalBudget += parseFloat(input.value) || 0;
//         });

//         const activityBudgetInput = document.getElementById(`activity-budget-${activityId}`);
//         activityBudgetInput.value = totalBudget;
//     }

//     // Create a MutationObserver for the budget-lines container
//     const budgetLinesContainer = document.getElementById(`budget-lines-${activityId}`);
//     const observer = new MutationObserver(() => recalculateActivityBudget());
//     observer.observe(budgetLinesContainer, { childList: true, subtree: true });

//     // Add initial budget lines
//     addBudgetLine(activityId, outputId, outcomeId, recalculateActivityBudget);
// }


// // Function to recalculate the Activity Budget
// function recalculateActivityBudget() {
//     const budgetLinesContainer = document.getElementById(`budget-lines-${activityId}`);
//     const budgetInputs = budgetLinesContainer.querySelectorAll('.budget');
//     let totalBudget = 0;

//     budgetInputs.forEach((input) => {
//         totalBudget += parseFloat(input.value) || 0;
//     });

//     const activityBudgetInput = document.getElementById(`activity-budget-${activityId}`);
//     activityBudgetInput.value = totalBudget;
// }


// Function to add a new Budget Line under an Activity
function addBudgetLine(activityId, outputId, outcomeId, recalculateActivityBudget) {
    const budgetLinesContainer = document.getElementById(`budget-lines-${activityId}`);
    const budgetLineCount = budgetLinesContainer.children.length + 1;
    const budgetLineId = Date.now();

    const budgetLineTemplate = `
        <div class="panel panel-default budget-line" id="budget-line-${budgetLineId}">
            <div class="panel-heading">
                <h6 class="panel-title">
                    <span class="entity-label">Budget Line ${outcomeCounter}.${budgetLineCount}</span>
                </h6>
            </div>
            <div class="panel-body">
                <!-- Budget Line Fields -->
                <div class="form-group">
                    <label class="col-sm-2 control-label">Budget Line Name</label>
                    <div class="col-sm-8">
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="fa fa-pencil fa-fw"></i>
                            </span>
                            <input type="text" name="outcomes[${outcomeId}][outputs][${outputId}][activities][${activityId}][budget_lines][${budgetLineId}][name]" class="form-control" placeholder="Enter Budget Line Name" required>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Unit Cost</label>
                    <div class="col-sm-8">
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="fa fa-pencil fa-fw"></i>
                            </span>
                            <input type="number" id="unit-cost-${budgetLineId}" name="outcomes[${outcomeId}][outputs][${outputId}][activities][${activityId}][budget_lines][${budgetLineId}][unitcost]"  class="form-control unit-cost" placeholder="Unit Cost" required>
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
                            <input type="number" id="quantity-${budgetLineId}" name="outcomes[${outcomeId}][outputs][${outputId}][activities][${activityId}][budget_lines][${budgetLineId}][quantity]"  class="form-control quantity" placeholder="Quantity" required>
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
                            <input type="number" id="frequency-${budgetLineId}" name="outcomes[${outcomeId}][outputs][${outputId}][activities][${activityId}][budget_lines][${budgetLineId}][frequency]" class="form-control frequency" placeholder="Frequency" required>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Budget Line Amount</label>
                    <div class="col-sm-8">
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="fa fa-pencil fa-fw"></i>
                            </span>
                            <input type="number" id="budget-${budgetLineId}" name="outcomes[${outcomeId}][outputs][${outputId}][activities][${activityId}][budget_lines][${budgetLineId}][budget]" class="form-control budget" placeholder="Enter Budget Line Amount" readonly required>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-8 col-sm-offset-2" style="display: flex; justify-content: flex-end; align-items: center;">
                        <!-- Delete Button with Bin Icon -->
                        <button type="button" class="btn btn-danger btn-delete" onclick="deleteBudgetLine(${budgetLineId})">
                            <i class="fa fa-trash"></i> Delete
                        </button>
                    </div>
                </div>
            </div>
        </div>
    `;

    budgetLinesContainer.insertAdjacentHTML('beforeend', budgetLineTemplate);

    // Attach event listeners to recalculate budget
    const unitCostInput = document.getElementById(`unit-cost-${budgetLineId}`);
    const quantityInput = document.getElementById(`quantity-${budgetLineId}`);
    const frequencyInput = document.getElementById(`frequency-${budgetLineId}`);
    const budgetInput = document.getElementById(`budget-${budgetLineId}`);

    function recalculateBudget() {
        const unitCost = parseFloat(unitCostInput.value) || 0;
        const quantity = parseFloat(quantityInput.value) || 0;
        const frequency = parseFloat(frequencyInput.value) || 0;
        if (validateBudgetLine(budgetLineId, activityId)) {
             budgetInput.value = unitCost * quantity * frequency;
        }
        
        // if (validateBudgetLine(budgetLineId, activityId)) {
        //     validateActivityBudget(activityId, outputId);
        //     validateOutputBudget(outputId, outcomeId);
        // }
    }

    unitCostInput.addEventListener('input', recalculateBudget);
    quantityInput.addEventListener('input', recalculateBudget);
    frequencyInput.addEventListener('input', recalculateBudget);
    // Attach event listener to recalculate budget
    budgetInput.addEventListener('input', recalculateActivityBudget);
}


// Delete Functions
function deleteOutcome(outcomeId) {
    document.getElementById(`outcome-${outcomeId}`).remove();
}

function deleteOutput(outputId) {
    document.getElementById(`output-${outputId}`).remove();
}

function deleteActivity(activityId) {
    document.getElementById(`activity-${activityId}`).remove();
}

function deleteBudgetLine(budgetLineId) {
    document.getElementById(`budget-line-${budgetLineId}`).remove();
}

function calculateActivityTotal(activityId) {
    const budgetLinesContainer = document.getElementById(`budget-lines-${activityId}`);
    const budgetInputs = budgetLinesContainer.querySelectorAll('.budget');
    let total = 0;
    budgetInputs.forEach(input => {
        total += parseFloat(input.value) || 0;
    });
    return total;
}

// Function to calculate total budget for activities in an output
function calculateOutputTotal(outputId) {
    const activitiesContainer = document.getElementById(`activities-${outputId}`);
    const budgetInputs = activitiesContainer.querySelectorAll('input[type="number"][name*="[budget]"]');
    let total = 0;
    budgetInputs.forEach(input => {
        total += parseFloat(input.value) || 0;
    });
    return total;
}

// Function to calculate total budget for outputs in an outcome
function calculateOutcomeTotal(outcomeId) {
    const outputsContainer = document.getElementById(`outputs-${outcomeId}`);
    const budgetInputs = outputsContainer.querySelectorAll('input[type="number"][name*="[budget]"]');
    let total = 0;
    budgetInputs.forEach(input => {
        total += parseFloat(input.value) || 0;
    });
    return total;
}

// Validation function for budget line
function validateBudgetLine(budgetLineId, activityId) {
const budgetLineInput = document.getElementById(`budget-${budgetLineId}`);
const activityBudgetInput = document.querySelector(`input[name*="[activities][${activityId}][budget]"]`);
const budgetLineValue = parseFloat(budgetLineInput.value) || 0;
const activityBudgetValue = parseFloat(activityBudgetInput.value) || 0;

if (budgetLineValue > activityBudgetValue) {
    alert('Budget line amount cannot exceed activity budget');
    budgetLineInput.value = activityBudgetValue;
    return false;
}
return true;
}

// Validation function for activity
function validateActivityBudget(activityId, outputId) {
const activityBudgetInput = document.querySelector(`input[name*="[activities][${activityId}][budget]"]`);
const outputBudgetInput = document.querySelector(`input[name*="[outputs][${outputId}][budget]"]`);
const activityTotal = calculateActivityTotal(activityId);
const outputBudgetValue = parseFloat(outputBudgetInput.value) || 0;

if (activityTotal > outputBudgetValue) {
    alert('Activity budget cannot exceed output budget');
    activityBudgetInput.value = outputBudgetValue;
    return false;
}
activityBudgetInput.value = activityTotal;
return true;
}

// Validation function for output
function validateOutputBudget(outputId, outcomeId) {
const outputBudgetInput = document.querySelector(`input[name*="[outputs][${outputId}][budget]"]`);
const outcomeBudgetInput = document.querySelector(`input[name*="outcomes[${outcomeId}][budget]"]`);
const outputTotal = calculateOutputTotal(outputId);
const outcomeBudgetValue = parseFloat(outcomeBudgetInput.value) || 0;

if (outputTotal > outcomeBudgetValue) {
    alert('Output budget cannot exceed outcome budget');
    outputBudgetInput.value = outcomeBudgetValue;
    return false;
}
outputBudgetInput.value = outputTotal;
return true;
}
