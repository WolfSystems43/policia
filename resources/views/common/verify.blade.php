      
      <br>      

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
          <form method="post" action="{{ route('email-verify') }}">
          <h5>Código de verificación</h5>
          <p>Te hemos mandado un código a {{ Auth::user()->email }}. <small><a href="">¿No llega?</a></small></p>
          <br>
          {{ csrf_field() }}
              <div class="row">
                <div class="input-field col s12">
                  <input type="text" name="email_code" placeholder="XXXXXXX">
                  <label for="email_code">Código de verificación</label>
                </div>
              </div>
              <button class="btn green waves-effect">Comprobar</button>
          </form>
        </div>

      </div>