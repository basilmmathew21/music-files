@component('mail::message')
# Introduction

    {{ $details['subject'] }}

    {{ $details['content'] }}


    @if($details['login']) {{ $details['login'] }}  @endif

Thanks,<br>
{{ config('app.name') }}
@endcomponent
