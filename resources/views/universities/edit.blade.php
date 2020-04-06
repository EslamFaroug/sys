@php 
    $lang = Session::get('lang');
    \App::setLocale($lang);
@endphp
{{csrf_field()}}    
<input type="hidden" name="university_id" value="{{$universities->university_id}}">
<div class="form-group">
<label class="col-md-2 control-label">{{trans('strings.university-input-name')}}</label>
    <div class="col-md-10">
        <input type="text" name="name" required="" class="form-control" value="{{$universities->name}}"/>
    </div>
</div>

<div class="form-group">
    <label class="col-md-2 control-label">{{trans('strings.select type_un')}}</label>
        <div class="col-md-10">
            <select id="typeSelect" class="form-control js-universities" type="text" name="type_id">
                <optgroup  label="{{trans('strings.select type')}}">
                    
                    @foreach($types as $type)
                    @if($type->type_id == $universities->type_id)
                        <option selected="selected" value="{{$type->type_id}}">{{$type->name}}</option>
                    @else
                        <option value="{{$type->type_id}}">{{$type->name}}</option>
                    @endif
                    @endforeach
                </optgroup>
            </select>
        </div>
</div>

<div class="form-group">
    <label class="col-md-2 control-label">{{trans('strings.select_country')}}</label>
        <div class="col-md-10">
            <select id="countrySelect" class="form-control js-universities" type="text" name="countery_id">
                <optgroup  label="{{trans('strings.select_state-label')}}">
                    
                    @foreach($countreis as $count)
                    @if($count->countery_id == $universities->countery_id)
                        <option selected="selected" value="{{$count->countery_id}}">{{$count->name}}</option>
                    @else
                        <option value="{{$count->countery_id}}">{{$count->name}}</option>
                    @endif
                    @endforeach
                </optgroup>
            </select>
        </div>
</div>