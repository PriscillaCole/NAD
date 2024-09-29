<!-- Display programs and their activities in a table -->
 <!-- Bootstrap 5 CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.4/dist/css/bootstrap.min.css" rel="stylesheet">
           <!-- Responsive table for activities -->
           <div class="card">
    <div class="card-header">
        <h3 class="card-title">{{ __('Programs and Activities') }}</h3>
    </div>
    <div class="card-body">
    <div class="panel-group" id="accordion">
    @foreach($programs as $program)
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title">
                <a data-toggle="collapse" data-parent="#accordion" href="#collapse-{{ $program->id }}">
                    {{ $program->name }}
                </a>
            </h4>
        </div>
        <div id="collapse-{{ $program->id }}" class="panel-collapse collapse">
            <div class="panel-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>{{ __('Activity Name') }}</th>
                            <th>{{ __('Budget (UGX)') }}</th>
                            <th>{{ __('Action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($program->activities as $activity)
                            <tr>
                                <td>{{ $activity->name }}</td>
                                <td>{{ number_format($activity->budget, 2) }}</td>
                                <td>
                                    <a href="{{ url('/requisitions/create') }}" class="btn btn-primary">
                                        {{ __('Apply for Requisition') }}
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endforeach
</div>

    </div>
</div>

<!-- Bootstrap 5 JS with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@3.3.4/dist/js/bootstrap.bundle.min.js"></script>


