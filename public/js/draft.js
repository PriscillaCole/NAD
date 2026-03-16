// ============================================
// DRAFT FUNCTIONALITY
// ============================================

const DRAFT_KEY = `program_budget_draft_new_${window.location.pathname}`;

function syncValuesToHTML() {
    // Sync all inputs, textareas, selects so innerHTML captures current values
    document.querySelectorAll('#outcomes input, #outcomes textarea, #outcomes select').forEach(input => {
        if (input.type === 'checkbox' || input.type === 'radio') {
            input.setAttribute('checked', input.checked);
        } else {
            input.setAttribute('value', input.value);
        }
    });

    // Sync MandE table too
    document.querySelectorAll('#MandE-table input, #MandE-table textarea, #MandE-table select').forEach(input => {
        input.setAttribute('value', input.value);
    });
}

function saveDraft() {
    // Sync live values to attributes BEFORE capturing innerHTML
    syncValuesToHTML();

    const draftData = {
        outcomes: document.getElementById('outcomes').innerHTML,
        mandETable: document.querySelector('#MandE-table tbody').innerHTML,
        outcomeCounter: outcomeCounter,
        MandEIndex: MandEIndex,
        timestamp: new Date().toISOString()
    };

    localStorage.setItem(DRAFT_KEY, JSON.stringify(draftData));
    showDraftToast('Draft saved!', 'success');
}

function restoreDraft() {
    const draft = localStorage.getItem(DRAFT_KEY);
    if (!draft) return;

    try {
        const draftData = JSON.parse(draft);
        console.log('draft.....', draftData)

        // Restore HTML structure
        if (draftData.outcomes) {
            document.getElementById('outcomes').innerHTML = draftData.outcomes;
        }

        if (draftData.mandETable) {
            document.querySelector('#MandE-table tbody').innerHTML = draftData.mandETable;
        }

        // Restore counters so new additions don't conflict
        if (draftData.outcomeCounter !== undefined) outcomeCounter = draftData.outcomeCounter;
        if (draftData.MandEIndex !== undefined) MandEIndex = draftData.MandEIndex;

        // Re-apply collapsed state to restored panels
        document.querySelectorAll('#outcomes .output, #outcomes .activity, #outcomes .budget-line').forEach(panel => {
            panel.classList.add('collapsed');
        });

        // Re-attach click handlers to restored panel headings
        document.querySelectorAll('#outcomes .outcomes, #outcomes .outputs, #outcomes .activities, #outcomes .budgetlines').forEach(heading => {
            heading.addEventListener('click', function(e) {
                const panel = this.closest('.panel');
                panel.classList.toggle('collapsed');
                if (panel.classList.contains('outcome') && panel.classList.contains('collapsed')) {
                    panel.querySelectorAll('.panel').forEach(childPanel => {
                        childPanel.classList.add('collapsed');
                    });
                }
                e.stopPropagation();
            });
        });

        // Re-attach recalculate listeners to restored budget line inputs
        document.querySelectorAll('#outcomes [id^="unit-cost-"], #outcomes [id^="quantity-"], #outcomes [id^="frequency-"]').forEach(input => {
            const id = input.id.split('-').pop(); // extract budgetLineId
            input.addEventListener('input', function() {
                recalculateBudget(id);
            });
        });

        showDraftToast('Draft restored!', 'info');
    } catch (e) {
        console.error('Failed to restore draft:', e);
        showDraftToast('Failed to restore draft', 'danger');
    }
}

function clearDraft() {
    localStorage.removeItem(DRAFT_KEY);
    showDraftToast('Draft cleared!', 'danger');
}

function showDraftToast(message, type = 'success') {
    const colorMap = {
        success: '#00a65a',
        info: '#00c0ef',
        danger: '#dd4b39',
        warning: '#f39c12',
    };
    const existing = document.getElementById('draft-toast');
    if (existing) existing.remove();

    const toast = document.createElement('div');
    toast.id = 'draft-toast';
    toast.innerText = message;
    toast.style.cssText = `
        position: fixed; bottom: 25px; right: 25px;
        background: ${colorMap[type]}; color: white;
        padding: 10px 20px; border-radius: 4px;
        z-index: 9999; font-size: 14px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.25);
        transition: opacity 0.4s ease;
    `;
    document.body.appendChild(toast);
    setTimeout(() => {
        toast.style.opacity = '0';
        setTimeout(() => toast.remove(), 400);
    }, 2500);
}

// Init draft on page load
document.addEventListener('DOMContentLoaded', function () {
    const draft = localStorage.getItem(DRAFT_KEY);

    // if (draft) {
    //     try {
    //         const draftData = JSON.parse(draft);
    //         const savedAt = new Date(draftData.timestamp).toLocaleString();
    //         if (confirm(`You have an unsaved draft from ${savedAt}. Restore it?`)) {
    //             restoreDraft();
    //         } else {
    //             clearDraft();
    //         }
    //     } catch (e) {
    //         clearDraft();
    //     }
    // }

    // Auto-save every 30 seconds
    // setInterval(saveDraft, 30000);

    // Save on any input change
    document.getElementById('programEditForm')?.addEventListener('change', saveDraft);

    // Clear draft on submit
    document.getElementById('programEditForm')?.addEventListener('submit', function () {
        clearDraft();
    });
});