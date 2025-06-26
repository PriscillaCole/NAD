<!DOCTYPE html>
<html>
<head>

<style>
    .navbar{
        height: 20px;
    }
    .custom-tooltip-container {
        position: relative;
    }

    .custom-tooltip {
        display: none;
        position: absolute;
        top: 100%; 
        left: 0;
        z-index: 09990;
        background-color: white;
        color: black;
        /* padding: 10px; */
        border: 1px solid #ddd;
        border-radius: 6px;
        box-shadow: 0px 2px 8px rgba(0,0,0,0.15);
        width: 163px;
        overflow: visible;
    }

    .custom-tooltip ul {
        list-style-type: none;
        padding: 0;
        margin: 0;
    }

    .custom-tooltip ul li {
        margin: 5px 0;
        font-size: 13px;
    }

    .custom-tooltip-container:hover .custom-tooltip {
        display: block;
    }
</style>


</head>
<body>
    <div class="container-fluid">
        <div class="panel panel-default" style="margin-top: 20px;">
            <div class="panel-heading">
                <h4 class="panel-title bold">Key Performance Indicators</h3>
                
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-2">
                        <div class="kpi-card pink-bg">
                            <div class="kpi-icon">
                                <i class="glyphicon glyphicon-list-alt"></i>
                            </div>
                            <div class="kpi-value">{{ $data['pending_requisitions'] }}</div>
                            <div class="kpi-label">Requisitions pending Finance approval</div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="kpi-card green-bg">
                            <div class="kpi-icon">
                                <i class="glyphicon glyphicon-ok"></i>
                            </div>
                            <div class="kpi-value">{{ $data['director_requisitions'] }}</div>
                            <div class="kpi-label">Requisitions pending Director's approval</div>
                        </div>
                    </div>
                    
                    {{-- <div class="col-md-2">
                        <div class="kpi-card purple-bg" data-toggle="tooltip" data-placement="top"
                           title="{{ implode('&#10;', $data['pending_accountability_names']->toArray() ?? []) }}">
                            <div class="kpi-icon">
                                <i class="glyphicon glyphicon-folder-open"></i>
                            </div>
                            <div class="kpi-value">{{ $data['approved_requisitions'] }}</div>
                            <div class="kpi-label">Pending Accountabilities</div>
                        </div>
                    </div> --}}
                    <div class="col-md-2">
                        <div class="kpi-card purple-bg custom-tooltip-container" style="overflow: visible;">
                            <div class="kpi-icon">
                                <i class="glyphicon glyphicon-folder-open"></i>
                            </div>
                            <div class="kpi-value">{{ $data['approved_requisitions'] }}</div>
                            <div class="kpi-label">Pending Accountabilities</div>

                            @if (!empty($data['pending_accountability_names']))
                                <div class="custom-tooltip">
                                    <ul>
                                        @foreach ($data['pending_accountability_names'] as $name)
                                            <li>{{ $name }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="kpi-card blue-bg">
                            <div class="kpi-icon">
                                <i class="glyphicon glyphicon-folder-close"></i>
                            </div>
                            <div class="kpi-value">{{ $data['closed_accountabilities'] }}</div>
                            <div class="kpi-label">Approved Accountabilities this month</div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="kpi-card cyan-bg">
                            <div class="kpi-icon orang">
                                <i class="glyphicon glyphicon-stats"></i>
                            </div>
                            <div class="kpi-value">{{ $data['accountabilities'] }}</div>
                            <div class="kpi-label">Total Accountabilities this month</div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="kpi-card orange-bg">
                            <div class="kpi-icon">
                                <i class="glyphicon glyphicon-usd"></i>
                            </div>
                            <div class="kpi-value">UGX {{ $data['total_amount_requested'] }}</div>
                            <div class="kpi-label">Total Funds Disbursed this year</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(function () {
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>
</html>