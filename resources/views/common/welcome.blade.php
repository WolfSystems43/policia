      
      <br>      
      <div class="container">
        <div class="card-panel blue white-text">
          <h5><i class="material-icons left">person_pin</i> ¡Hola!</h5>
          <p>¡Bienvenido/a! Necesitamos saber un par de cosas.</p>
        </div>
      </div>

      @if (count($errors) > 0)
          <div class="container">
            <div class="card-panel red darken-2 white-text">
              <ul>
              @foreach ($errors->all() as $error)
                      <li>{{ $error }}</li>
                  @endforeach
                  </ul>
            </div>
          </div>
      @endif
      <div class="container">
        <div class="card-panel">
          <h5><i class="material-icons left">contact_mail</i> Añade tu correo</h5>
          <p>{!! trans('messages.mail_subtitle') !!}</p>
          <form method="post" action="{{ route('email-settings') }}">
          {{ csrf_field() }}
              <div class="row">
                <div class="input-field col s12">
                  <input type="email" placeholder="ejemplo@ejemplo.com" name="email" required="required" value="{{ Auth::user()->email }}">
                  <label for="email">{{ trans('messages.mail_label') }}</label>
                </div>
                <div class="input-field col s12">
                  <input type="email" name="email_confirmation" required="required">
                  <label for="email_confirmation">{{ trans('messages.mail_label_confirmation') }}</label>
                </div>
              </div>
              <button class="btn green waves-effect">Enviar correo de verificación</button>
          </form>
        </div>

      </div>