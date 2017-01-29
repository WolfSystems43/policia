@can('admin-tickets')
<br>
<div class="container">
  <nav class="{{ Auth::user()->getColor() }} white-text">
    <div class="nav-wrapper">
      <a href="{{ route('specialty-view', ['id' => 6]) }}" class="right brand-logo hide-on-med-and-down"><img class="img-responsive" height="60" src="/img/divisas/especialidades/6.png"></a>
      <ul id="nav-mobile" class="left">
        <li><a href="{{ route('tickets') }}" class="waves-effect">Casos abiertos</a></li>
        <li><a href="{{ route('tickets_closed') }}" class="waves-effect">Cerrados</a></li>
      </ul>
    </div>
  </nav>
</div>
@endcan