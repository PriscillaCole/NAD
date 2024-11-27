<div class="form-group">
    <label>Program Name</label>
    <input type="text" class="form-control" name="name" value="{{ old('name', $program->name) }}">
</div>

<div class="form-group">
    <label>Outcomes</label>
    <div class="nested-forms">
        @foreach ($program->outcomes as $outcome)
            <div class="nested-form">
                <input type="text" class="form-control" name="outcomes[{{ $outcome->id }}][name]" value="{{ old('outcomes.' . $outcome->id . '.name', $outcome->name) }}">
                <div class="nested-forms">
                    @foreach ($outcome->outputs as $output)
                        <div class="nested-form">
                            <input type="text" class="form-control" name="outcomes[{{ $outcome->id }}][outputs][{{ $output->id }}][name]" value="{{ old('outcomes.' . $outcome->id . '.outputs.' . $output->id . '.name', $output->name) }}">
                            <div class="nested-forms">
                                @foreach ($output->activities as $activity)
                                    <div class="nested-form">
                                        <input type="text" class="form-control" name="outcomes[{{ $outcome->id }}][outputs][{{ $output->id }}][activities][{{ $activity->id }}][name]" value="{{ old('outcomes.' . $outcome->id . '.outputs.' . $output->id . '.activities.' . $activity->id . '.name', $activity->name) }}">
                                        <div class="nested-forms">
                                            @foreach ($activity->budgetLines as $budgetLine)
                                                <div class="nested-form">
                                                    <input type="text" class="form-control" name="outcomes[{{ $outcome->id }}][outputs][{{ $output->id }}][activities][{{ $activity->id }}][budget_lines][{{ $budgetLine->id }}][amount]" value="{{ old('outcomes.' . $outcome->id . '.outputs.' . $output->id . '.activities.' . $activity->id . '.budget_lines.' . $budgetLine->id . '.amount', $budgetLine->amount) }}">
                                                    <input type="text" class="form-control" name="outcomes[{{ $outcome->id }}][outputs][{{ $output->id }}][activities][{{ $activity->id }}][budget_lines][{{ $budgetLine->id }}][description]" value="{{ old('outcomes.' . $outcome->id . '.outputs.' . $output->id . '.activities.' . $activity->id . '.budget_lines.' . $budgetLine->id . '.description', $budgetLine->description) }}">
                                                </div>
                                            @endforeach
                                            <button type="button" class="btn btn-primary add-budget-line">Add Budget Line</button>
                                        </div>
                                    </div>
                                @endforeach
                                <button type="button" class="btn btn-primary add-activity">Add Activity</button>
                            </div>
                        </div>
                    @endforeach
                    <button type="button" class="btn btn-primary add-output">Add Output</button>
                </div>
            </div>
        @endforeach
        <button type="button" class="btn btn-primary add-outcome">Add Outcome</button>
    </div>
</div>

