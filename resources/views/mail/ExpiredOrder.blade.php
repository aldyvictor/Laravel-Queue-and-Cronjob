@component('mail::message')
# Introduction
<h1>Halo {{ $name }}, Selamat Datang! di {{ config('app.name') }}</h1>
<p>Pemsanan anda sudah Expired</p> <br>

Thanks,<br>
{{ config('app.name') }}
@endcomponent
