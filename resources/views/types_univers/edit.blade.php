@php 
    $lang = Session::get('lang');
    \App::setLocale($lang);
@endphp
{{csrf_field()}}     
<input type="hidden" name="type_id" value="{{$type->type_id}}">
<div class="form-group">
    <label class="col-md-2 control-label">{{trans('strings.type-input-name')}}</label>
    <div class="col-md-10">
       <input type="text" name="name" class="form-control" value="{{$type->name}}" />
    </div>
</div>