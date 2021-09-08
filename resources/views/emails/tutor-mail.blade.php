@component('mail::message')
# Introduction

    {{ $details['subject'] }}

    {{ $details['content'] }}

@if($details['login'])
    {{ $details['login'] }}
@endif


@component('mail::button', ['url' => config('app.url')])
Login
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
