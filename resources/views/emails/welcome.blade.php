@component('mail::message')
# Welcome {{ $developerName }}

We are so excited to have you on our team! With your experience, you will be a great addition. Welcome aboard!

Thanks,<br>
{{ config('app.name') }}
@endcomponent
