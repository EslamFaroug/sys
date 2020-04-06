@php 
    $lang = Session::get('lang');
    \App::setLocale($lang);
@endphp
{{csrf_field()}}     
<input type="hidden" name="study_id" value="{{$studes->study_id}}">
<div class="form-group">
    <label class="col-md-2 control-label">{{trans('strings.study-input-label')}}</label>
    <div class="col-md-10">
       <input type="text" name="name" class="form-control" value="{{$studes->name}}" />
    </div>
</div>

