@php 
    $lang = Session::get('lang');
    \App::setLocale($lang);
@endphp
{{csrf_field()}}     
<input type="hidden" name="mangejob_id" value="{{$mange->mangejob_id}}">
<div class="form-group">
    <label class="col-md-2 control-label">{{trans('strings.mange-input-label')}}</label>
    <div class="col-md-10">
       <input type="text" name="name" class="form-control" value="{{$mange->name}}" />
    </div>
</div>

