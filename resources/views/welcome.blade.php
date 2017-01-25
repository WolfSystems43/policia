<html>

<head>
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.5/css/materialize.min.css">
  <link rel="stylesheet" href="//cdn.materialdesignicons.com/1.8.36/css/materialdesignicons.min.css">
  <style>
    body {
      display: flex;
      min-height: 100vh;
      flex-direction: column;
    }

    main {
      flex: 1 0 auto;
    }

    body {
      background: #fff;
    }

    .input-field input[type=date]:focus + label,
    .input-field input[type=text]:focus + label,
    .input-field input[type=email]:focus + label,
    .input-field input[type=password]:focus + label {
      color: #e91e63;
    }

    .input-field input[type=date]:focus,
    .input-field input[type=text]:focus,
    .input-field input[type=email]:focus,
    .input-field input[type=password]:focus {
      border-bottom: 2px solid #e91e63;
      box-shadow: none;
    }
  </style>
</head>

<body class="blue-grey darken-3">
  <div class="section"></div>
  <main>
    <center>
      <div class="section"></div>

      <h5 class="light-blue-text text-accent-2">Inicio de sesión</h5>
      <span class="white-text">Fuerzas de Seguridad del Estado</span>
      <div class="section"></div>

      @if (session('status'))
      <div class="container">
              <span class="red-text">{{ session('status') }}</span>
              <br><br>
      </div>
      @endif



      <div class="container">
        <div class="z-depth-1 lighten-4 row card-panel blue-grey darken-2 white-text" style="display: inline-block; padding: 32px 48px 0px 48px; background-color: #455a64;">

          <form class="col s12" method="get" action="{{url('login')}}">
          {{ csrf_field() }}
            <div class='row'>
              <div class='col s12'>
              <span> Haz clic para iniciar sesión con tu cuenta de Steam</span>
              </div>
            </div>
            <br />
            <center>
              <div class='row'>
                <button type='submit' name='btn_login' class='waves-effect btn btn-large  green'><i class="mdi mdi-steam left"></i> Iniciar sesión con Steam</button>
              </div>
            </center>
          </form>
        </div>
      </div>
    </center>

    <div class="section"></div>
    <div class="section"></div>
  </main>

  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.1/jquery.min.js"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.5/js/materialize.min.js"></script>

       <script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
        (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

        ga('create', '{{ env('APP_GAPUBLIC') }}', 'auto');
        ga('send', 'pageview');

      </script>

</body>

</html>