@component('mail::message')
{!! $header !!}
<h1>Hallo {{ $name }}, Welcome to {{config('app.name')}}</h1>
{!! $content !!}

Thank you for order in<br>
<h3>{{ config('app.name') }}</h3>
@endcomponent
