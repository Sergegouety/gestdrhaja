@component('mail::message')
# {{ $sujet}}

{{ $message }}


Cordialement,<br>
{{ config('app.name') }}
@endcomponent
