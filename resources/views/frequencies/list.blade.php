@extends('layouts.material')

@section('title', trans('messages.frequencies_title'))

@section('content')
<div class="section">
    <div class="container">
    	<div class="row">
    		<div class="col s12 l6">
        		<h5>{{ trans('messages.frequencies_title') }} <small title="{{ trans('messages.frequencies_last_updated_user', ['name' => $frequency->user->name]) }}">
        		<span v-text="someDate | moment 'from'"></span>
        		{{ $frequency->created_at->hour }}:{{ $frequency->created_at->minute }}
        		</small></h5>
    		</div>
    		<div class="col s12 l6">
    		</div>
    	</div>

	    	<div class="card-panel hidden" style="display:none" id="expired">
	    		<h5>Nuevas frecuencias disponibles</h5>
	    		<p>Se han generado nuevas frecuencias, por lo que estas han quedado obsoletas.</p>
	    		<a href="" class="btn blue waves-effect"><i class="material-icons left">refresh</i> Recargar página</a>
	    	</div>


        <div class="card-panel" id="frecuencias">


              <table class="highlight">
		        <thead>
		          <tr>
		              <th data-field="id">{{ trans('messages.frequencies_name') }}</th>
		              <th data-field="name">{{ trans('messages.frequencies_frequency') }}</th>
		          </tr>
		        </thead>

		        <tbody>
	            @foreach($frequencies as $freq)
		          <tr>
		            <td><span class="">{{$freq[0]}}</span></td>
		            <td> <a title="Copiar" ref="#!" style="cursor: pointer;" class="freq-button freq-copy" data-clipboard-text="{{$freq[1]}}"> <i class="tiny left material-icons" style="padding-left: 8px">content_copy</i>
		            </a>

		            <span class="spoiler">{{$freq[1]}}</span></td>
		          </tr>
	            @endforeach
		        </tbody>
		      </table>
				@can('regenerate-frequencies')
				<div class="divider"></div>
				<p><b>{{ trans('messages.frequencies_regenerate_title') }}</b></p>
		      {!! trans('messages.frequencies_regenerate_subtitle') !!}
		      	<form action="{{ route('frequencies_new') }}" method="POST" onsubmit="return confirm('{{ trans('messages.frequencies_regenerate_confirm') }}');">
		      	{{ csrf_field() }}
		      	<button class="btn waves-effect waves-light black">{{ trans('messages.frequencies_regenerate_button') }}</button>
		      	</form>
        		@endcan
		      </div>



				<br>
				<span class="flow-text">{{ trans('messages.frequencies_teamspeak_title') }}</span>
				<div class="card-panel">
					<p>{{ trans('messages.frequencies_teamspeak_body') }}</p>

					<span class="spoiler">{{ Config::get('settings.ts_password') }}</span>
				@can('admin')
				<span class="right">
				<a href="/admin/setting/1/edit" class="btn black white-text waves-effect waves-light"><i class="material-icons left">developer_mode</i> {{ trans('messages.frequencies_teamspeak_admin_edit') }}</a>
				</span>
				<br><br>
				@endcan
				</div>



    </div>
</div>

@endsection

@section('footer')
<script src="https://cdn.jsdelivr.net/clipboard.js/1.6.0/clipboard.min.js"></script>
  <script>
  new Clipboard('.freq-copy');

  var freq_version = {{ $frequency->id }};
  var freq_expired = false;

  function checkExpired() {
  	if(! freq_expired) {
	  $.get('{{ route('api_frequency_check') }}', function(data, status) {
	  	if(data > freq_version) {
	  		$('#freq_warning').hide();
      		$('#frecuencias').hide();
	  		$('#expired').fadeIn();
	  		freq_expired = true;
	  	}
	  });
	}	
  }

	setInterval(checkExpired, 60000);

  </script>
@endsection
