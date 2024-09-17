@component('mail::message')
# Hello

<p>{{$message}}</p>

@component('mail::button', ['url' => $link, 'color' => 'orange', ])
View the request form
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
