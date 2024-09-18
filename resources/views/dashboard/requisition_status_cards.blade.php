<style>
    .chart-container {
    width: 100%; /* Ensure container uses full width of its parent */
    max-width: 400px; /* Set a max width to control size */
    margin: 0 auto; /* Center the container */
}

    .card {
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
        margin-bottom: 30px;
        padding: 20px;
        transition: all 0.3s ease-in-out;
        background-color: #fff;
    }

    .card:hover {
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
        transform: translateY(-5px);
    }

    .card-header {
        border-bottom: 1px solid #e0e0e0;
        padding-bottom: 10px;
        margin-bottom: 10px;
    }

    .card-title {
        font-size: 1.2rem;
        font-weight: 600;
        color: #333;
    }

    .card-body h4 {
        font-size: 1.5rem;
        font-weight: 700;
        color: #007bff;
    }

    .text-muted {
        color: #6c757d !important;
    }

    .text-danger {
        color: #dc3545 !important;
    }

    .text-success {
        color: #28a745 !important;
    }

    .card p a {
        color: #007bff;
        font-weight: 500;
        text-decoration: none;
    }

    .card p a:hover {
        text-decoration: underline;
    }

    .icon {
        font-size: 1.5rem;
        vertical-align: middle;
        margin-right: 8px;
    }

    .me-1 {
        margin-right: 0.25rem !important;
    }

    .me-2 {
        margin-right: 0.5rem !important;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .col-lg-3 {
            width: 100%;
            margin-bottom: 20px;
        }
    }
</style>

<!-- ============================================================== -->
<!-- Start right Content here -->
<!-- ============================================================== -->
<div class="row">
    <div class="col-lg-3 col-md-6 col-sm-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{__('Requisitions Submitted')}}</h3>
            </div>
            <div class="card-body">
                <h4 class="mb-2">{{ $data['total_requisitions'] }}</h4>
                <p class="text-muted mb-0">
                    <span class="text-danger fw-bold font-size-12 me-2">
                        <i class="glyphicon glyphicon-pencil icon"></i>
                    </span>
                    <a href="{{ admin_url('/requisitions')}}">{{__('View Details')}}</a>
                </p>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 col-sm-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{__('Accepted Requisitions')}}</h3>
            </div>
            <div class="card-body">
                <h4 class="mb-2">{{ $data['approved_requisitions'] }}</h4>
                <p class="text-muted mb-0">
                    <span class="text-success fw-bold font-size-12 me-2">
                        <i class="glyphicon glyphicon-check icon"></i>
                    </span>
                    <a href="{{ admin_url('/requisitions')}}">{{__('View Details')}}</a>
                </p>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 col-sm-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{__('Rejected Requisitions')}}</h3>
            </div>
            <div class="card-body">
                <h4 class="mb-2">{{ $data['rejected_requisitions'] }}</h4>
                <p class="text-muted mb-0">
                    <span class="text-danger fw-bold font-size-12 me-2">
                        <i class="glyphicon glyphicon-remove-circle icon"></i>
                    </span>
                    <a href="{{ admin_url('/requisitions')}}">{{__('View Details')}}</a>
                </p>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 col-sm-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{__('Total Amount from Requisitions')}}</h3>
            </div>
            <div class="card-body">
                <h4 class="mb-2">{{ $data['total_amount_requested'] }} Ugx</h4>
                <p class="text-muted mb-0">
                    <span class="text-success fw-bold font-size-12 me-2">
                        <i class="glyphicon glyphicon-pushpin icon"></i>
                    </span>
                    <a href="{{ admin_url('/requisitions')}}">{{__('View Details')}}</a>
                </p>
            </div>
        </div>
    </div>
</div>
