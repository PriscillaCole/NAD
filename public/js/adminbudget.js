
let outcomeCounter = 0;

// Function to add a new Outcome
function addOutcome() {
    outcomeCounter++;
    const outcomesContainer = document.getElementById("outcomes");
    const outcomeId = Date.now();

    const outcomeTemplate = `
        <div class="panel panel-default outcome" id="outcome-${outcomeId}">
            <div class="panel-heading outcomes">
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
                        <input type="text" name="outcomes[${outcomeId}][name]"  class="form-control" placeholder="Enter Outcome Name" required>
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
                        <input type="text" name="outcomes[${outcomeId}][budget]" oninput="formatNumber(event)" class="form-control formatted-input" placeholder="Enter Outcome Budget" required>
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
function addOutput(outcomeId, recalculateActivityBudget) {
    const outputsContainer = document.getElementById(`outputs-${outcomeId}`);
    const outputCount = outputsContainer.children.length + 1;
    const outputId = Date.now();

    const outputTemplate = `
        <div class="panel panel-default output" id="output-${outputId}">
            <div class="panel-heading outputs">
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
                    <label class="col-sm-2 control-label"> Unit Cost</label>
                    <div class="col-sm-8">
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="fa fa-pencil fa-fw"></i>
                            </span>
                            <input type="text" id="unitcost-${outputId}" name="outcomes[${outcomeId}][outputs][${outputId}][unitcost]" oninput="formatNumber(event)" class="form-control formatted-input" placeholder="Enter Output Unitcost" required>
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
                            <input type="text" id="quantity-${outputId}" name="outcomes[${outcomeId}][outputs][${outputId}][quantity]" oninput="formatNumber(event)" class="form-control formatted-input" placeholder="Enter Quantity" required>
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
                            <input type="text" id="frequency-${outputId}" name="outcomes[${outcomeId}][outputs][${outputId}][frequency]" oninput="formatNumber(event)" class="form-control formatted-input" class="form-control" placeholder="Enter Frequency" required>
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
                            <input type="text" name="outcomes[${outcomeId}][outputs][${outputId}][unit]" class="form-control" placeholder="Enter Units"  required>
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
                        <input readonly type="text" id="budget-${outputId}" name="outcomes[${outcomeId}][outputs][${outputId}][budget]" oninput="formatNumber(event)" class="form-control formatted-input" placeholder="Enter Output Budget" required>
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

    // Attach event listeners to recalculate budget
    const unitCostInput = document.getElementById(`unitcost-${outputId}`);
    const quantityInput = document.getElementById(`quantity-${outputId}`);
    const frequencyInput = document.getElementById(`frequency-${outputId}`);
    const budgetInput = document.getElementById(`budget-${outputId}`);
    
    function recalculateBudget() {
        const unitCostInput = document.getElementById(`unitcost-${outputId}`);
        const quantityInput = document.getElementById(`quantity-${outputId}`);
        const frequencyInput = document.getElementById(`frequency-${outputId}`);
        const budgetInput = document.getElementById(`budget-${outputId}`);
    
        let unitCost = parseFloat(unitCostInput.getAttribute("data-raw")) || 0;
        console.log('unitCost', unitCostInput.getAttribute("data-raw"));
        let quantity = parseFloat(quantityInput.getAttribute("data-raw")) || 1;
        console.log('quantity', quantityInput.getAttribute("data-raw"));
        let frequency = parseFloat(frequencyInput.getAttribute("data-raw")) || 1;
        console.log('frequency', frequency);
        
    
        // if (validateBudgetLine(outcomeId, activityId)) {
            const calculatedBudget = unitCost * quantity * frequency;
            console.log('calculatedBudget', calculatedBudget);
            budgetInput.value = formatNumberDisplay(calculatedBudget); //format for display
            budgetInput.setAttribute("data-raw", calculatedBudget); //store raw number.
        // }
    }
    
    function formatNumberDisplay(number) {
        return number.toLocaleString('en-US'); // Format as US currency
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

document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".formatted-input").forEach(input => {
        input.addEventListener("input", formatNumber);
    });
});

function formatNumber(event) {
        let input = event.target;
        let value = input.value.replace(/[^0-9.]/g, ''); // Remove non-numeric characters except dot
        let parts = value.split('.');
    
        parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ','); // Add commas for readability
        input.value = parts.join('.'); // Display formatted value
    
        // Store raw numeric value in a data attribute
        input.setAttribute("data-raw", value);
    }
    
function removeFormattingBeforeSubmit() {
    document.querySelectorAll(".formatted-input").forEach(input => {
        input.value = input.getAttribute("data-raw"); // Restore raw value before submission
    });
}

document.addEventListener('DOMContentLoaded', function() {
    // Add collapsed class to all panels initially
    document.querySelectorAll(' .output, .activity, .budgetlines').forEach(panel => {
        panel.classList.add('collapsed');
    });

    // Add click handlers to all panel headings
    document.querySelectorAll(' .outcomes, .outputs, .activities, .budgetlines').forEach(heading => {
        heading.addEventListener('click', function(e) {
            // Get the parent panel
            const panel = this.closest('.panel');
            
            // Toggle the collapsed class
            panel.classList.toggle('collapsed');
            
            // If this is an outcome panel
            if (panel.classList.contains('outcome')) {
                // Collapse all child panels when closing
                if (panel.classList.contains('collapsed')) {
                    panel.querySelectorAll('.panel').forEach(childPanel => {
                        childPanel.classList.add('collapsed');
                    });
                }
            }
            
            // Stop event from bubbling to parent panels
            e.stopPropagation();
        });
    });
});

let MandEIndex = 0; // set this dynamically with PHP like {$crops->count()}

function addMandERow() {
    let row = `
        <tr>
            <td class="pd">
                <input type="text" name="MEbudget_lines[${MandEIndex}][name]" class="form-control inputx">
            </td>
            <td class="pd">
                <input type="text" name="MEbudget_lines[${MandEIndex}][units]" class="form-control inputx">
            </td>
            <td class="pd">
                <input type="number" name="MEbudget_lines[${MandEIndex}][unitcost]" class="form-control inputx calc-field">
            </td>
            <td class="pd">
                <input type="number" name="MEbudget_lines[${MandEIndex}][quantity]" class="form-control inputx calc-field">
            </td>
            <td class="pd">
                <input type="number" name="MEbudget_lines[${MandEIndex}][frequency]" class="form-control inputx calc-field">
            </td>
            <td class="pd">
                <input type="number" name="MEbudget_lines[${MandEIndex}][budget]" class="form-control inputx budget-field" readonly>
            </td>
            <td class="pd">
                <input type="number" name="MEbudget_lines[${MandEIndex}][dev_org]" class="form-control inputx">
            </td>
            <td>
                <button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)">Remove</button>
            </td>
        </tr>`;
    
    document.querySelector('#MandE-table tbody').insertAdjacentHTML('beforeend', row);
    MandEIndex++;
}

function removeRow(btn) {
    btn.closest('tr').remove();
    calculateTotalBudget(); // re-calc total when a row is removed
}

// 🔹 Calculate budget per row
function calculateRowBudget(row) {
    let unitcost = parseFloat(row.querySelector('[name*="[unitcost]"]').value) || 0;
    let quantity = parseFloat(row.querySelector('[name*="[quantity]"]').value) || 0;
    let frequency = parseFloat(row.querySelector('[name*="[frequency]"]').value) || 0;

    let budget = unitcost * quantity * frequency;
    row.querySelector('[name*="[budget]"]').value = budget.toFixed(2);

    calculateTotalBudget();
}


function calculateTotalBudget() {
    let total = 0;
    document.querySelectorAll('#MandE-table tbody tr').forEach(row => {
        let budgetInput = row.querySelector('[name*="[budget]"]');
        if (budgetInput) {
            let value = parseFloat(budgetInput.value) || 0;
            total += value;
        }
    });

    // Update display
    // document.getElementById('budget-total-display').innerHTML = `<strong>${total.toFixed(2)}</strong>`;

    // Update hidden input so it's submitted to backend
    document.getElementById('budget-total-input').value = total.toFixed(2);
}


// 🔹 Listen for changes in unitcost, quantity, frequency
document.addEventListener('input', function(e) {
    if (e.target.closest('#MandE-table') && e.target.classList.contains('calc-field')) {
        let row = e.target.closest('tr');
        calculateRowBudget(row);
    }
});
