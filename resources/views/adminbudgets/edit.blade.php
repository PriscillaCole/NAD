<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Program</title>
    <style>
        .ml-4 { margin-left: 1.5rem; }
        .ml-5 { margin-left: 3rem; }
        .btn-add { margin-top: 10px; margin-bottom: 10px; }
        .delete-btn { color: red; cursor: pointer; margin-left: 10px; }
        .panel-body { padding: 15px; }
        .entity-label { font-weight: bold; margin-right: 10px; }
        .text-right { text-align: right; }
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
                        <a href="http://127.0.0.1:8000/adminBudget" class="btn btn-sm btn-default" title="List">
                            <i class="fa fa-list"></i> List
                        </a>
                    </div>
                </div>

                <!-- Form Body -->
                <div class="panel-body">
                    <form action="{{ url('adminBudget/'. $adminprogram->id.'/edit') }}" method="POST" id="programEditForm" class="form-horizontal" enctype="multipart/form-data">
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
                        <div class="form-group">
                            <label for="description" class="col-sm-2 control-label">Program Budget</label>
                            <div class="col-sm-8">
                                <textarea name="budget" class="form-control" readonly required>{{ $adminprogram->budget }}</textarea>
                            </div>
                        </div>

                        <!-- Outcome Section -->
                        <div id="outcomes">
                        
                            @foreach ($adminprogram->adminActivities as $adminActivity)
                                <div class="panel panel-default outcome" id="outcome-{{ $adminActivity->id }}">
                                    <div class="panel-heading">
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
                                                    <input type="number" name="outcomes[{{ $adminActivity->id }}][budget]" class="form-control" value="{{ $adminActivity->budget }}" required>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!-- Outputs Section -->
                                        <div id="outputs-{{ $adminActivity->id }}">
                                            @foreach ($adminActivity->adminBudgetLines as $adminBudgetLine)
                                                <div class="panel panel-default output" id="output-{{ $adminBudgetLine->id }}">
                                                    <div class="panel-heading">
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
                                                            <label class="col-sm-2 control-label">Output Budget</label>
                                                            <div class="col-sm-8">
                                                                <div class="input-group">
                                                                    <span class="input-group-addon">
                                                                        <i class="fa fa-pencil fa-fw"></i>
                                                                    </span>
                                                                    <input type="number" name="outcomes[{{ $adminActivity->id }}][outputs][{{ $adminBudgetLine->id }}][budget]" class="form-control" value="{{ $adminBudgetLine->total_cost }}" required>
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
</body>
</html>
