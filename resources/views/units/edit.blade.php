@php 
    $lang = Session::get('lang');
    \App::setLocale($lang);
@endphp
{{csrf_field()}}    
<input type="hidden" name="unit_id" value="{{$units->unit_id}}">
<div class="form-group">
<label class="col-md-2 control-label">{{trans('strings.unit-input-name')}}</label>
    <div class="col-md-10">
        <input type="text" name="name" required="" class="form-control" value="{{$units->name}}"/>
    </div>
</div>
<div class="form-group">
    <label class="col-md-2 control-label">{{trans('strings.select_un_region-label')}}</label>
        <div class="col-md-10">
            <select id="stateSelect" class="form-control js-units" type="text" name="regional_id">
                <optgroup  label="{{trans('strings.select_un_region-label')}}">
                    
                    @foreach($regionals as $reg)
                    @if($reg->regional_id == $units->regional_id)
                        <option selected="selected" value="{{$reg->regional_id}}">{{$reg->name}}</option>
                    @else
                        <option value="{{$reg->regional_id}}">{{$reg->name}}</option>
                    @endif
                    @endforeach
                </optgroup>
            </select>
        </div>
</div>