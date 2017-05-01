  <!DOCTYPE html>
  <html>
    <head>
      <!--Import Google Icon Font-->
      <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
      <!--Import materialize.css-->
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.8/css/materialize.min.css">
      
      <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />

      <link rel="stylesheet" href="/css/material.css">
      @if(session('dark', false))
        <link rel="stylesheet" href="/css/material-dark.css">
      @endif

      <title>@yield('title') - Policía POPLife</title>

      <link rel="apple-touch-icon" sizes="57x57" href="/img/icon/apple-icon-57x57.png">
      <link rel="apple-touch-icon" sizes="60x60" href="/img/icon/apple-icon-60x60.png">
      <link rel="apple-touch-icon" sizes="72x72" href="/img/icon/apple-icon-72x72.png">
      <link rel="apple-touch-icon" sizes="76x76" href="/img/icon/apple-icon-76x76.png">
      <link rel="apple-touch-icon" sizes="114x114" href="/img/icon/apple-icon-114x114.png">
      <link rel="apple-touch-icon" sizes="120x120" href="/img/icon/apple-icon-120x120.png">
      <link rel="apple-touch-icon" sizes="144x144" href="/img/icon/apple-icon-144x144.png">
      <link rel="apple-touch-icon" sizes="152x152" href="/img/icon/apple-icon-152x152.png">
      <link rel="apple-touch-icon" sizes="180x180" href="/img/icon/apple-icon-180x180.png">
      <link rel="icon" type="image/png" sizes="192x192"  href="/img/icon/android-icon-192x192.png">
      <link rel="icon" type="image/png" sizes="32x32" href="/img/icon/favicon-32x32.png">
      <link rel="icon" type="image/png" sizes="96x96" href="/img/icon/favicon-96x96.png">
      <link rel="icon" type="image/png" sizes="16x16" href="/img/icon/favicon-16x16.png">
      <link rel="manifest" href="/img/icon//manifest.json">
      <meta name="msapplication-TileColor" content="#ffffff">
      <meta name="msapplication-TileImage" content="/img/icon//ms-icon-144x144.png">
      <meta name="theme-color" content="#ffffff">
      <meta name="csrf-token" content="{{ csrf_token() }}">

      <!--Let browser know website is optimized for mobile-->
      <meta name="viewport" content="width=device-width, initial-scale=1.0"/>


      <style>
        .list-img {
          padding-right: 8px;
        }
      </style>
    </head>

    <body>
  
    @yield('variables')

    <div class="navbar-fixed">
      <nav class="{{ Auth::user()->getColor() }}">
      <div class="container">
        <div class="nav-wrapper">
          
          {{-- <a href="#" data-activates="mobile-demo" class="button-collapse"><i class="material-icons">menu</i></a> --}}
          <ul class="left hide-on-med-and-down">
          <li><a class="waves-effect" href="{{ route('home') }}" class=""> <img style="vertical-align:middle; padding-right: 8px" height="30px" src="{{ Auth::user()->getCorpImage() }}"> <span style="vertical-align:middle"> {!! trans('messages.menu_title', ['corp' => Auth::user()->getCorpName()]) !!}</span></a></li>
         </ul>
          <ul class="right hide-on-large">
          @if(env('APP_DEBUG'))
            <li><a title="Modo de desarrollador"><i class="yellow-text text-accent-1 material-icons">bug_report</i></a></li>
          @endif
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
      <li><a href="{{ route('user_profile', Auth::user()->id) }}" class="waves-effect">{{ trans('messages.menu_profile') }}</a></li>
      <li><a href="{{ route('my_tickets') }}" class="waves-effect">{{ trans('messages.menu_tickets') }}</a></li>
      <li><a href="{{ route('settings') }}" class="waves-effect">{{ trans('messages.menu_settings') }}</a></li>
      <li><a href="{{ route('about') }}" class="waves-effect">{{ trans('messages.menu_about') }}</a></li>
      @can('admin-tickets')
      <li class="divider"></li>
      <li><a href="{{ route('tickets') }}" class="waves-effect">{{ trans('messages.menu_iatickets') }}</a></li>
      @endcan
      @if(Auth::user()->isAdmin())
      <li class="divider"></li>
      <li><a class="waves-effect" href="{{ url('/admin') }}"><i class="material-icons left">developer_mode</i> {{ trans('messages.menu_admin') }}</a></li>
      @endif
      <li class="divider"></li>
      <li><a href="{{ route('logout') }}" class="waves-effect">{{ trans('messages.menu_logout') }}</a></li>
    </ul>
  
  
    <div class="hide-on-large-only">
      <a href="{{ route('home') }}" class="btn btn-block {{ Auth::user()->getColor() }} ">{{ trans('messages.menu_mobile_home') }}</a>
    </div>
    
      @if(!is_null(Config::get('settings.message')) && Config::get('settings.message') != "")
      <div class="container">
      <p><i class="material-icons left">warning</i> Mensaje del sistema</p>
        <div class="card-panel">
          {{ Config::get('settings.message') }}
        </div>
      </div>
      @endif

      
      {{-- If the user doesn't have a valid email --}}
      @if(! Auth::user()->hasMail() && ! isset($unlock_page)) 
        {{-- TODO show welcome screen --}}
        @include('common.welcome')
      @else {{-- If the user HAS an email set --}}
        {{-- Check if is verified --}}
        @if(! Auth::user()->isVerified())
          {{-- If NOT verified, show options --}}
          @include('common.verify')
        @else
          {{-- User is good to go, verified --}}
          @yield('content')
        @endif
        {{-- Include the content --}}
      @endif
      {{-- END mail --}}


      {{-- <div class="container">
        <span class="right"><a class="grey-rext" href="{{ route('about') }}">Por Manolo Pérez</a></span>
      </div> --}}
      <!--Import jQuery before materialize.js-->
      <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
       <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.8/js/materialize.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
       <script src="/js/spoiler.js"></script>
       <script>
        $(document).ready(function() {
          $('select').material_select();
          $(".button-collapse").sideNav();
          $('.modal').modal();
        });
        spoilerAlert('spoiler, .spoiler');
       </script>
       <script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
        (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

        ga('create', '{{ env('APP_GA') }}', 'auto');
        ga('send', 'pageview');

      </script>
      @if (session('status'))
        <script>
            Materialize.toast('{{ session('status') }}', 4000)
        </script>
      @endif



      @yield('footer')
    </body>
  </html>