@component('mail::message')

    {{ $details['subject'] }}

    {{ $details['content'] }}

@if(isset($details['login']) && $details['login'])
    {{ $details['login'] }}
@endif


@component('mail::button', ['url' => config('app.url')])
Login
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
