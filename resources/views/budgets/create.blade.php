<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Program</title>
    <!-- Bootstrap 3 CSS -->
    <!-- <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet"> -->
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
            background-color: #FFE6E6 !important;
        }

        .outputs {
            background-color: #E8F5E9 !important;
        }

        .activities {
            background-color: #F3E5F5 !important;
        }

        .budgetlines {
            background-color: #b7f7f1 !important;
        }

        /* Add smooth transition */
        .panel-body {
            transition: all 0.3s ease-out;
        }
    </style>
    <!-- add script -->
    <script src="{{asset('js')}}/createProgram.js"></script>
</head>
<body>
<div class="col-md-12">
    <div class="row">
        <div>
            <!-- Program Creation Box -->
            <div class="panel panel-info">
            <div class="panel-heading bg-primary" style="background-color: transparent; display: flex; justify-content: space-between; align-items: center; border-top: 4px solid #87cefa;">
                <h3 class="panel-title" style="margin: 0;">Create Budget</h3>
                <div class="btn-group">
                    <a href="http://127.0.0.1:8000/budgets" class="btn btn-sm btn-default" title="List">
                        <i class="fa fa-list"></i> List
                    </a>
                </div>
            </div>

                <!-- Form Body -->
                <div class="panel-body">
                    <form action="{{ url('programs/create') }}" method="POST" id="programForm" class="form-horizontal" enctype="multipart/form-data">
                        @csrf
                        <!-- Program Name -->
                        <div class="form-group">
                            <label for="name" class="col-sm-2 control-label">Program Name</label>
                            <div class="col-sm-8">
                            <div class="input-group">
                                    <span class="input-group-addon">
                                        {{-- <i class="fa fa-pencil fa-fw"></i> --}}
                                    </span>
                                    <select id="adminprogram_id" name="program_id" class="form-control custom-select" required>
                                        <option value="" disabled selected>Select a program</option>
                                        @foreach($programs as $program)
                                            <option value="{{ $program->id }}">{{ $program->name }}</option>
                                        @endforeach
                                    </select>
                                    {{-- <input type="select" name="name" class="form-control" placeholder="Enter Program Name" required /> --}}
                                </div>
                            </div>
                        </div>
                

                        <!-- Program Description -->
                        {{-- <div class="form-group">
                            <label for="description" class="col-sm-2 control-label">Program Description</label>
                            <div class="col-sm-8">
                                <textarea name="description" class="form-control" placeholder="Enter Program Description" required></textarea>
                            </div>
                        </div> --}}

                        <!-- Outcome Section -->
                        <div id="outcomes">
                            <script></script>
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
                                <button type="submit" class="btn btn-primary">Save Program</button>
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
