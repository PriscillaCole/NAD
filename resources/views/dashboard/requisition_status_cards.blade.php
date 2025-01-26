<!DOCTYPE html>
<html>
<head>
    <style>
        .kpi-card {
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        
        .kpi-value {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 5px;
        }
        
        .kpi-label {
            font-size: 14px;
            color: #666;
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

        .dropdown {
            margin-bottom: 20px;
        }

        .panel {
            border: none;
            box-shadow: none;
        }

        .panel-heading {
            background-color: white !important;
            border-bottom: none;
            padding-left: 2px 2px;
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
                    <div class="col-md-3">
                        <div class="kpi-card pink-bg">
                            <div class="kpi-icon">
                                <i class="glyphicon glyphicon-list-alt"></i>
                            </div>
                            <div class="kpi-value">{{ $data['total_requisitions'] }}</div>
                            <div class="kpi-label">Requisitions</div>
                        </div>
                    </div>
                    <div class=" col-lg-3 col-md-3">
                        <div class="kpi-card orange-bg">
                            <div class="kpi-icon">
                                <i class="glyphicon glyphicon-usd"></i>
                            </div>
                            <div class="kpi-value">${{ $data['total_amount_requested'] }}</div>
                            <div class="kpi-label">Total Funds Disbursed</div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="kpi-card green-bg">
                            <div class="kpi-icon">
                                <i class="glyphicon glyphicon-ok"></i>
                            </div>
                            <div class="kpi-value">{{ $data['approved_requisitions'] }}</div>
                            <div class="kpi-label">Requisitions Approved</div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="kpi-card purple-bg">
                            <div class="kpi-icon">
                                <i class="glyphicon glyphicon-file"></i>
                            </div>
                            <div class="kpi-value">{{ $data['accountabilities'] }}</div>
                            <div class="kpi-label">Accountabilities</div>
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