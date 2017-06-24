@component('mail::message')
# Tu dimisión ha sido aceptada

Hola, {{ explode(' ', $user->name, 2)[0] }}:

Hemos revisado tu situación y **aceptado tu dimisión**.
<br>Ahora ya eres un civil normal.

Muchas gracias por tu tiempo como policía.

*Asuntos Internos*
@endcomponent