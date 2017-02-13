@extends('layouts.material')

@section('title', trans('messages.newticket_page_title'))

@section('content')


<div class="container">
<br>
	<h5>{{ trans('messages.newticket_title') }}</h5>

  @if (count($errors) > 0)
    <div class="card-panel">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
  @endif

	<div class="card-panel">
 <div class="row">

    @if(!is_null($user))
    <form class="col s12" method="POST" action="{{ route('ticket_new', ['id' => $user->id]) }}">
    @else
    <form class="col s12" method="POST" action="{{ route('ticket_new') }}">
    @endif
	{{ csrf_field() }}
       <div class="row">
        <div class="input-field col s12">
          <p>{{ trans('messages.newticket_persons_label') }} <span class="red-text">*</span></p>
			<select style="width: 100%" name="implicated[]" class="js-example-basic-single browser-default" multiple="multiple" required="required">
        @if(!is_null(old('implicated')))
          @foreach(old('implicated') as $id)
            <option value="{{ $id }}" selected="selected">{{ \App\User::findOrFail($id)->name }}</option>
          @endforeach
        @else
          @if(!is_null($user))
				  <option value="{{ $user->id }}" selected="selected">{{ $user->name }}</option>
          @endif
        @endif
			</select>
        </div>
      </div>

      <div class="row">
        <div class="input-field col s12">
          <input id="title" name="title" type="text" class="validate" placeholder="{{ trans('messages.newticket_subject_placeholder') }}" length="100" value="{{ old('title') }}">
          <label for="text">{{ trans('messages.newticket_subject_label') }} <span class="red-text">*</span></label>
        </div>
      </div>

      <div class="row">
        <div class="input-field col s12">
          <textarea name="body" id="textarea1" class="materialize-textarea" placeholder="{{ trans('messages.newticket_body_placeholder') }}" length="1000">{{ old('body') }}</textarea>
          <label for="textarea1">{{ trans('messages.newticket_body_label') }} <span class="red-text">*</span></label>
        </div>
      </div>
			{!! trans('messages.newticket_tips') !!}


      <div class="row">
        <div class="input-field col s12">
          <input type="checkbox" name="anonymous" class="filled-in" id="filled-in-box" @if(!is_null(old('anonymous'))) checked="checked" @endif />
      		<label for="filled-in-box">{!! trans('messages.newticket_anonymous_toggle', ['tag' => 'modal_anonymous_mode']) !!}</label>
        </div>
      </div>

  </div>
	<button class="btn green white-text waves-effect">{{ trans('messages.newticket_send_button') }}</button>

    </form>
	</div>
</div>


  <!-- Modal Structure -->
  <div id="modal_anonymous_mode" class="modal">
    <div class="modal-content">
      <h4>{{ trans('messages.newticket_anonymous_modal_title') }}</h4>
			{!! trans('messages.newticket_anonymous_modal_body') !!}

			<div class="card-panel deep-orange darken-4 white-text">
      	<p>{!! trans('messages.newticket_anonymous_modal_warning') !!}
      </div>
    </div>
    <div class="modal-footer">
      <a href="#!" class="modal-action modal-close waves-effect btn-flat">{{ trans('messages.newticket_anonymous_modal_close_button') }}</a>
    </div>
  </div>

@endsection

@section('footer')
<script type="text/javascript">
$(document).ready(function() {
$('.js-example-basic-single').select2({
            placeholder: '{{ trans('messages.newticket_user_select_placeholder') }}',
            language: "es",
            templateResult: formatUser,
      			minimumInputLength: 3,
      			maximumSelectionLength: 30,
            ajax: {
                dataType: 'json',
                url: '{{ route("api_user_search_input") }}',
                delay: 250,
                data: function(params) {
                    return {
                        q: params.term
                    }
                },
                processResults: function (data, page) {
                    return {
                        results: data
                    };
                },
            }
        });
});

function formatUser (state) {
  if (!state.id) { return state.text; }
  var $state = $(
    '<span><img height="16" src="/img/divisas/' + state.corp + '.png" class="img-flag" /> ' + state.text + ' (' + state.rank + ')</span>'
  );
  return $state;
};
</script>
@endsection
