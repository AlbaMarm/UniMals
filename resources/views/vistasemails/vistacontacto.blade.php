@component('mail::message')
{{-- Logo de la app --}}
<img src="{{ asset('images/appicon.svg') }}" alt="{{ config('app.name') }}" width="80" class="mx-auto mb-4">

{{-- Panel verde de encabezado --}}
@component('mail::panel', ['color' => 'success'])
# You have received feedback!
@endcomponent

{{-- Quién lo envió --}}
**From:** {{ $nombre }}

{{-- Cuerpo del mensaje --}}
**Message:**  
{{ $body }}

{{-- Pie de página --}}
Thanks for playing,<br>
{{ config('app.name') }}
@endcomponent
