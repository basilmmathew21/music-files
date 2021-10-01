@component('mail::message')

{{ $details['subject'] }}

{{ $details['content'] }}

    Name     : {{ $details['name'] }}
    Email    : {{ $details['email'] }}
    Password : {{ $details['password'] }}

@component('mail::button', ['url' => config('app.url')])
Login
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
