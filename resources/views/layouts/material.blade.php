  <!DOCTYPE html>
  <html>
    <head>
      <!--Import Google Icon Font-->
      <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
      <!--Import materialize.css-->
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.8/css/materialize.min.css">

      <link rel="stylesheet" href="/css/material.css">
    
      <title>@yield('title') - Policía POPLife</title>

      <!--Let browser know website is optimized for mobile-->
      <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    </head>

    <body>

    <div class="navbar-fixed">
      <nav class="{{ Auth::user()->getColor() }}">
      <div class="container">
        <div class="nav-wrapper">
          
          {{-- <a href="#" data-activates="mobile-demo" class="button-collapse"><i class="material-icons">menu</i></a> --}}
          <ul class="left hide-on-med-and-down">
          <li><a class="waves-effect" href="{{ route('home') }}" class="">{{ Auth::user()->getCorpName() }} - <b>intranet</b></a></li>
         </ul>
          <ul class="right hide-on-large">

           <li><a class="dropdown-button" href="#!" class="" data-activates="dropdown1">{{ Auth::user()->name }}<i class="material-icons right">arrow_drop_down</i></a></li>
          </ul>
          <ul class="side-nav" id="mobile-demo">
            <li><a href="sass.html">Inicio</a></li>
            <li><a href="{{ url('/logout') }}">Cerrar sesión</a></li>
          </ul>
        </div>
      </div>
      </nav>
    </div>

        
    <!-- Dropdown Structure -->
    <ul id="dropdown1" class="dropdown-content">
      <li><a href="{{ route('user_profile', Auth::user()->id) }}" class="waves-effect">Mi perfil</a></li>
      <li><a href="{{ url('about') }}" class="waves-effect">Acerca de</a></li>
      @if(Auth::user()->isAdmin())
      <li class="divider"></li>
      <li><a class="waves-effect" href="{{ url('/admin') }}"><i class="material-icons left">developer_mode</i> Admin</a></li>
      @endif
      <li class="divider"></li>
      <li><a href="{{ route('logout') }}" class="waves-effect">Cerrar sesión</a></li>
    </ul>
  
  
    <div class="hide-on-med-and-up">
      <a href="{{ route('home') }}" class="btn btn-block {{ Auth::user()->getColor() }} ">Página de inicio</a>
      <a href="{{ route('logout') }}" class="btn btn-block {{ Auth::user()->getColor() }} ">Cerrar sesión</a>
    </div>

      @yield('content')

      {{-- <div class="container">
        <span class="right"><a class="grey-rext" href="{{ route('about') }}">Por Manolo Pérez</a></span>
      </div> --}}
      <!--Import jQuery before materialize.js-->
      <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
       <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.8/js/materialize.min.js"></script>
       <script src="/js/spoiler.js"></script>
       <script>
        $(document).ready(function() {
          $('select').material_select();
          $(".button-collapse").sideNav();
          $('.modal').modal();
        });
        spoilerAlert('spoiler, .spoiler');
       </script>
    </body>
  </html>