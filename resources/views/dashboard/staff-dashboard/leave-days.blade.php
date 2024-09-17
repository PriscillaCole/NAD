
    <style>
        .card {
            border: 1px solid #ccc;
            border-radius: 10px;
            padding: 20px;
            margin: 10px;
            display: inline-block;
            width: 200px;
            text-align: center;
        }
        .ring {
            position: relative;
            width: 100px;
            height: 100px;
            border-radius: 50%;
            margin: 0 auto; /* Center the ring */
        }
        .ring::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 60%;
            height: 60%;
            background: #fff;
            border-radius: 50%;
        }
    </style>
    @if($leaveDays->isEmpty())
        <p>No leave days data available.</p>
    @endif
    
    @foreach($leaveDays as $leave)
        @php
            $totalDays = $leave->leave_days_used + $leave->leave_days_remaining;
            $usedPercentage = ($leave->leave_days_used / $totalDays) * 100;
            // Generate a random color
            $color = sprintf('#%06X', mt_rand(0, 0xFFFFFF));
        @endphp
        <div class="card">
            <h2>{{ $leave->leave_type_name}}</h2>
            <div class="ring" style="background: conic-gradient({{ $color }} {{ $usedPercentage }}%, #f3f3f3 {{ $usedPercentage }}%);"></div>
            <p>Used: <span>{{ $leave->leave_days_used }} days</span> | Available: {{ $leave->leave_days_remaining }}  days</p>
        </div>
    @endforeach


