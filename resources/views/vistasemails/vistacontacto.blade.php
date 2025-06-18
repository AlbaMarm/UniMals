@component('mail::message')
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
