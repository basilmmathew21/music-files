@component('mail::message')
# Introduction

    {{ $details['subject'] }}

    {{ $details['content'] }}



Thanks,<br>
{{ config('app.name') }}
@endcomponent
