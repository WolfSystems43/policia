@component('mail::message')
# Código de verificación

{{ $user->name }}, este es el código de verificación de tu cuenta:

@component('mail::panel')
{{-- Separate the digits with a space for better readability --}}
<center><b>{{ number_format($user->emailCode() , 0, '.', ' ') }}</b></center>
@endcomponent

<br>Ahora tienes que introducirlo en la página de verificación:

@component('mail::button', ['url' => url('/')])
Acceder a la página
@endcomponent
@endcomponent
