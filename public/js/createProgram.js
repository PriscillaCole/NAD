
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
                                <i class="fa fa-trash"></i> Delete Outcome
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
                        <label class="col-sm-2 control-label">Output Budget</label>
                        <div class="col-sm-8">
                         <div class="input-group">
                        <span class="input-group-addon">
                                <i class="fa fa-pencil fa-fw"></i>
                            </span>
                            <input type="text" name="outcomes[${outcomeId}][outputs][${outputId}][budget]" oninput= "formatNumber(event)" class="form-control formatted-input" placeholder="Enter Output Budget" required>
                        </div>
                        </div>
                    </div>

                    <!-- Activities Section -->
                    <div id="activities-${outputId}"></div>
                    <div class="form-group">
                      <div class="col-sm-8 col-sm-offset-2" style="display: flex; justify-content: space-between; align-items: center;">
                        <button type="button" class="btn btn-warning btn-add" onclick="addActivity(${outputId}, ${outcomeId})">Add Activity</button>
                        <!-- Delete Button with Bin Icon -->
                        <button type="button" class="btn btn-danger btn-delete"  onclick="deleteOutput(${outputId})">
                            <i class="fa fa-trash"></i> Delete Output
                        </button>
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
                <div class="panel-heading activities">
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
                            <input type="text" name="outcomes[${outcomeId}][outputs][${outputId}][activities][${activityId}][budget]" oninput= "formatNumber(event)" class="form-control formatted-input" placeholder="Enter Activity Budget" required>
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
                            <i class="fa fa-trash"></i> Delete Activity
                        </button>
                    </div>
                    <div style="height: 20px; border-bottom: 1px solid #eee; text-align: center;margin-top: 20px;margin-bottom: 20px;">
                        <span style="font-size: 18px; background-color: #ffffff; padding: 0 10%;">
                        Contingency Budget
                        </span>
                    </div>
                    <div id="contingency-${activityId}" style="padding: 0 15px;"></div>
                    <div class="form-group">
                        <div class="col-sm-6 col-sm-offset-2" style="display: flex; justify-content: space-between; align-items: center;">
                            <button type="button" class="btn btn-secondary btn-add" onclick="addContigencyBudget(${activityId}, ${outputId}, ${outcomeId})">Add Contingency Budget</button>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        `;

        activitiesContainer.insertAdjacentHTML('beforeend', activityTemplate);
    }

    // Function to add a new Budget Line under an Activity
    function addBudgetLine(activityId, outputId, outcomeId, recalculateActivityBudget) {
        const budgetLinesContainer = document.getElementById(`budget-lines-${activityId}`);
        const budgetLineCount = budgetLinesContainer.children.length + 1;
        const budgetLineId = Date.now();
    
        const budgetLineTemplate = `
            <div class="panel panel-default budget-line" id="budget-line-${budgetLineId}">
                <div class="panel-heading budgetlines">
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
                                <input type="text" id="unit-cost-${budgetLineId}" name="outcomes[${outcomeId}][outputs][${outputId}][activities][${activityId}][budget_lines][${budgetLineId}][unitcost]" oninput= "formatNumber(event)"  class="form-control unit-cost formatted-input" placeholder="Unit Cost" required>
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
                                <input type="text" id="quantity-${budgetLineId}" name="outcomes[${outcomeId}][outputs][${outputId}][activities][${activityId}][budget_lines][${budgetLineId}][quantity]" oninput= "formatNumber(event)"  class="form-control quantity formatted-input" placeholder="Quantity" required>
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
                                <input type="text" id="frequency-${budgetLineId}" name="outcomes[${outcomeId}][outputs][${outputId}][activities][${activityId}][budget_lines][${budgetLineId}][frequency]" oninput= "formatNumber(event)" class="form-control frequency formatted-input" placeholder="Frequency" required>
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
                                <input type="text" id="budget-${budgetLineId}" name="outcomes[${outcomeId}][outputs][${outputId}][activities][${activityId}][budget_lines][${budgetLineId}][budget]" oninput= "formatNumber(event)" class="form-control budget formatted-input" placeholder="Enter Budget Line Amount" readonly required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-8 col-sm-offset-2" style="display: flex; justify-content: flex-end; align-items: center;">
                            <!-- Delete Button with Bin Icon -->
                            <button type="button" class="btn btn-danger btn-delete" onclick="deleteBudgetLine(${budgetLineId})">
                                <i class="fa fa-trash"></i> Delete Budgetline
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
            const unitCostInput = document.getElementById(`unit-cost-${budgetLineId}`);
            const quantityInput = document.getElementById(`quantity-${budgetLineId}`);
            const frequencyInput = document.getElementById(`frequency-${budgetLineId}`);
            const budgetInput = document.getElementById(`budget-${budgetLineId}`);
        
            let unitCost = parseFloat(unitCostInput.getAttribute("data-raw")) || 0;
            console.log(unitCost);
            let quantity = parseFloat(quantityInput.getAttribute("data-raw")) || 0;
            console.log(quantity);
            let frequency = parseFloat(frequencyInput.getAttribute("data-raw")) || 0;
            console.log(frequency);
        
            // if (validateBudgetLine(budgetLineId, activityId)) {
                const calculatedBudget = unitCost * quantity * frequency;
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

    function recalculateBudget(budgetLineId) {
        const unitCostInput = document.getElementById(`unit-cost-${budgetLineId}`);
        const quantityInput = document.getElementById(`quantity-${budgetLineId}`);
        const frequencyInput = document.getElementById(`frequency-${budgetLineId}`);
        const budgetInput = document.getElementById(`budget-${budgetLineId}`);

        // Remove commas and convert to numbers
        let unitCost = parseFloat(unitCostInput.value.replace(/,/g, '')) || 0;
        let quantity = parseFloat(quantityInput.value.replace(/,/g, '')) || 0;
        let frequency = parseFloat(frequencyInput.value.replace(/,/g, '')) || 0;

        const calculatedBudget = unitCost * quantity * frequency;
        
        // Format the input values
        unitCostInput.value = formatNumberDisplay(unitCost);
        quantityInput.value = formatNumberDisplay(quantity);
        frequencyInput.value = formatNumberDisplay(frequency);
        
        // Format and set the calculated budget
        budgetInput.value = formatNumberDisplay(calculatedBudget);
    }
        function formatNumberDisplay(number) {
            return number.toLocaleString('en-US'); // Format as US currency
        }
    

    // Delete Functions
    function deleteOutcome(outcomeId) {
        if (confirm("Are you sure you want to delete this outcome?")) {
            document.getElementById(`outcome-${outcomeId}`).remove();
        }
    }

    function deleteOutput(outputId) {
        if (confirm("Are you sure you want to delete this outcome?")) {
            document.getElementById(`output-${outputId}`).remove();
        }
    }

    function deleteActivity(activityId) {
        if (confirm("Are you sure you want to delete this activity?")) {
            document.getElementById(`activity-${activityId}`).remove();
        }
    }

    function deleteBudgetLine(budgetLineId) {
        if (confirm("Are you sure you want to delete this outcome?")) {
            document.getElementById(`budget-line-${budgetLineId}`).remove();
        }
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

    // Function to add a new contingecy under a Program
    function addContigencyBudget(activityId, outputId, outcomeId,) {
        const contingencyContainer = document.getElementById(`contingency-${activityId}`);
        // const budgetLineCount = budgetLinesContainer.children.length + 1;
        const contingencyBudget = Date.now();
    
        const contingencyTemplate = `
            <div class="panel panel-default budget-line" id="contingencyBudget-${contingencyBudget}">
                <div class="panel-heading budgetlines">
                    <h6 class="panel-title">
                        <span class="entity-label">Contingency Budget</span>
                    </h6>
                </div>
                <div class="panel-body">
                    <!-- Budget Line Fields -->
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Contingency Name</label>
                        <div class="col-sm-8">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="fa fa-pencil fa-fw"></i>
                                </span>
                                <input type="text" name="outcomes[${outcomeId}][outputs][${outputId}][activities][${activityId}][contingency][${contingencyBudget}][name]" class="form-control" placeholder="Enter Budget Name" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Contingency Budget</label>
                        <div class="col-sm-8">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="fa fa-pencil fa-fw"></i>
                                </span>
                                <input type="text" id="unit-cost-${contingencyBudget}" name="outcomes[${outcomeId}][outputs][${outputId}][activities][${activityId}][contingency][${contingencyBudget}][budget]" oninput= "formatNumber(event)" class="form-control formatted-input" placeholder="Budget" required>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <div class="col-sm-8 col-sm-offset-2" style="display: flex; justify-content: flex-end; align-items: center;">
                            <!-- Delete Button with Bin Icon -->
                            <button type="button" class="btn btn-danger btn-delete" onclick="deleteContingency(${contingencyBudget})">
                                <i class="fa fa-trash"></i> Delete
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        `;
    
        contingencyContainer.insertAdjacentHTML('beforeend', contingencyTemplate);
    
    
    }

    // delete contingency budget
    function deleteContingency(contingencyBudget) {
        document.getElementById(`contingencyBudget-${contingencyBudget}`).remove();
    }


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


    