@php 
    $lang = Session::get('lang');
    \App::setLocale($lang);
@endphp
{{csrf_field()}}     
<input type="hidden" name="count_id" value="{{$count->countery_id}}">
<div class="form-group">
    <label class="col-md-3 control-label">{{trans('strings.countery-input-name')}}</label>
    <div class="col-md-9">
       <input type="text" name="name" class="form-control" value="{{$count->name}}" />
    </div>
</div>
<div class="form-group">
    <label class="col-md-3 control-label">{{trans('strings.country-input-symbol')}}</label>
    <div class="col-md-9">
        <input type="text" name="symbole" class="form-control" value="{{$count->symbole}}" />
    </div>
</div>
<!-- <div class="form-group">
    <label class="col-md-2 control-label">{{trans('strings.country-input-national')}}</label>
    <div class="col-md-10">
        <input type="text" name="nationality" class="form-control" value="{{$count->nationality}}" />
    </div>
</div> -->