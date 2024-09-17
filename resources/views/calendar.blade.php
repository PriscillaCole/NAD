<!-- resources/views/calendar.blade.php -->
<style>
    .card {
        border: 1px solid orange;
        border-radius: 5px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        margin-bottom: 30px;
        /* padding around */
        padding: 10px;
        width: 100%;
    }
</style>
<div class="card">
        <div class="card-header">
            <h3 class="card-title">Accepted Leave Requests</h3>
        </div>
        <div class="card-body">
        <div id="calendar"></div>
        </div>
</div>   

<!-- Include FullCalendar CSS and JS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.0/fullcalendar.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.0/fullcalendar.min.js"></script>

<script>
   $(document).ready(function() {
            var calendarEl = document.getElementById('calendar');

            $('#calendar').fullCalendar({
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'month,agendaWeek,agendaDay',
                },
                defaultView: 'month',
                events: @json($accepted_requests),
                eventRender: function(event, element) {
                    element.attr('title', event.description + ' | ' + event.number_of_days + ' days requested');
                }
            });
        });
</script>
</div>

