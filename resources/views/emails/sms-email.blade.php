@component('mail::message')
{{ $details['content'] }}

{{ $details['message'] }}

Thanks,<br>
{{ config('app.name') }}
@endcomponent
