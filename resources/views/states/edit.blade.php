@php 
    $lang = Session::get('lang');
    \App::setLocale($lang);
@endphp
{{csrf_field()}}    
<input type="hidden" name="state_id" value="{{$states->state_id}}">
<div class="form-group">
<label class="col-md-2 control-label">{{trans('strings.state-input-name')}}</label>
    <div class="col-md-10">
        <input type="text" name="name" required="" class="form-control" value="{{$states->name}}"/>
    </div>
</div>
<div class="form-group">
    <label class="col-md-2 control-label">{{trans('strings.select_country')}}</label>
        <div class="col-md-10">
            <select id="countrySelect" class="form-control js-states" type="text" name="countery_id">
                <optgroup  label="{{trans('strings.select_state-label')}}">
                    
                    @foreach($countreis as $count)
                    @if($count->countery_id == $states->countery_id)
                        <option selected="selected" value="{{$count->countery_id}}">{{$count->name}}</option>
                    @else
                        <option value="{{$count->countery_id}}">{{$count->name}}</option>
                    @endif
                    @endforeach
                </optgroup>
            </select>
        </div>
</div>