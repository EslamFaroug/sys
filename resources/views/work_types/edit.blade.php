@php 
    $lang = Session::get('lang');
    \App::setLocale($lang);
@endphp
{{csrf_field()}}     
<input type="hidden" name="work_id" value="{{$works->work_id}}">
<div class="form-group">
    <label class="col-md-2 control-label">{{trans('strings.work-input-label')}}</label>
    <div class="col-md-10">
       <input type="text" name="name" class="form-control" value="{{$works->name}}" />
    </div>
</div>

