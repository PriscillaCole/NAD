<!DOCTYPE html>
<html>
<head>
    <style>
        .kpi-card {
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            height: 123px;
        }
        
        .kpi-value {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 5px;
        }
        
        .kpi-label {
            font-size: 14px;
            color: #666;
            padding-top: 10%;
        }
        
        .kpi-icon {
            float: right;
            width: 24px;
            height: 24px;
            background: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .pink-bg {
            background-color: #FFE6E6;
        }
        
        .orange-bg {
            background-color: #FFF3E0;
        }
        
        .green-bg {
            background-color: #E8F5E9;
        }
        
        .purple-bg {
            background-color: #F3E5F5;
        }
        .blue-bg {
            background-color: #b7f7f1;
        }
        .cyan-bg{
            background-color: #baf5bb;
        }

        .dropdown {
            margin-bottom: 20px;
        }

        .panel {
            border: none;
            box-shadow: none;
        }
        .panel-title{
            color: white;
        }

        .panel-heading {
            background-color: white !important;
            border-bottom: none;
            padding-left: 2px 2px;
        }
        .container-fluid {
            background-color: white;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="panel panel-default">
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
                    
                    <div class="col-md-2">
                        <div class="kpi-card purple-bg">
                            <div class="kpi-icon">
                                <i class="glyphicon glyphicon-folder-open"></i>
                            </div>
                            <div class="kpi-value">{{ $data['approved_requisitions'] }}</div>
                            <div class="kpi-label">Pending Accountabilities</div>
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
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>
</html>