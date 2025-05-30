<li class="dropdown notifications-menu">
<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
  <i class="fa fa-bell-o"></i>
  @if (count($notifications) > 0)
  <span class="label label-danger" style="padding-bottom: 3px;  ">{{ count($notifications) }}</span>
  @endif
</a>
<ul class="dropdown-menu">
  <li class="header">You have {{ count($notifications) }} pending tasks.</li>
  <li>
    <!-- inner menu: contains the actual data -->
    <ul class="menu">
       
      @foreach ($notifications as $notification) 
      <li >
        <a id="notify" href="{{ $notification->form_link }}" title="{{ $notification->message }}"  onclick="markAsReadAndRedirect(event, {{ $notification->id }}, `{{ $notification->form_link }}`)">
   
          @if ($notification->receiver_id == null)
          <i class="fa fa-users text-success"></i> 
          @else
          <i class="fa fa-user text-success"></i> 
          @endif
          {{ $notification->message }}
        </a>
      </li>
      @endforeach
    </ul>
  </li>
</ul>
</li>
<script>
  
  function markAsReadAndRedirect(event, notificationId, redirectUrl) {
      event.preventDefault(); // Prevent default link action
      fetch(`notifications/mark-as-read/${notificationId}`, {
          method: 'POST',
          headers: {
              'X-CSRF-TOKEN': '{{ csrf_token() }}',
              'Content-Type': 'application/json',
          },
      })
      .then(response => response.json())
      .then(data => {
          // Redirect after marking as read
          window.location.href = redirectUrl;
      })
      .catch(error => console.error('Error:', error));
  }
</script>
