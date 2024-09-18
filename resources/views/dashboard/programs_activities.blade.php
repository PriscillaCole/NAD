<!-- Display programs and their activities in a table -->
            <!-- Responsive table for activities -->
<div class="card">
    <div class="card-header">
        <h3 class="card-title">{{ __('Programs and Activities') }}</h3>
    </div>
    <div class="card-body">
        <div class="table-responsive"> <!-- This makes the table responsive -->
            @foreach($programs as $program)
                <h4>{{ $program->name }}</h4>
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
            @endforeach
        </div>
    </div>
</div>

