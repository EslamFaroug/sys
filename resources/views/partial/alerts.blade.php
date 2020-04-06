@php 
    $lang = Session::get('lang');
    \App::setLocale($lang);
@endphp
@if(session('Success'))
<div class="alert alert-info">
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	{{session('Success')}}
</div>
@endif
@if (count($errors) > 0)
<div class="alert alert-danger">
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	<strong>{{trans('strings.errors')}}</strong>
	
	@foreach($errors->all() as $error)
	<li>{{$error}}</li>
	@endforeach
	
</div>
@endif