@component('mail::message')

{{ $details['subject'] }}

{{ $details['content'] }}

{{ $details['details'] }}

    Name  : {{ $details['name'] }}
    Email : {{ $details['email'] }}
    Phone : {{ $details['phone'] }}

@component('mail::button', ['url' => config('app.url')])
Login
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
