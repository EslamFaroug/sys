@php 
    $lang = Session::get('lang');
    \App::setLocale($lang);
@endphp
{{csrf_field()}}    
<input type="hidden" name="regional_id" value="{{$regionals->regional_id}}">
<div class="form-group">
<label class="col-md-2 control-label">{{trans('strings.regional-input-name')}}</label>
    <div class="col-md-10">
        <input type="text" name="name" required="" class="form-control" value="{{$regionals->name}}"/>
    </div>
</div>
<div class="form-group">
    <label class="col-md-2 control-label">{{trans('strings.select_re_state-label')}}</label>
        <div class="col-md-10">
            <select id="stateSelect" class="form-control js-regionals" type="text" name="state_id">
                <optgroup  label="{{trans('strings.select_re_state-label')}}">
                    
                    @foreach($states as $state)
                    @if($state->state_id == $regionals->state_id)
                        <option selected="selected" value="{{$state->state_id}}">{{$state->name}}</option>
                    @else
                        <option value="{{$state->state_id}}">{{$state->name}}</option>
                    @endif
                    @endforeach
                </optgroup>
            </select>
        </div>
</div>