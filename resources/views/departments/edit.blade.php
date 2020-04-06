@php 
    $lang = Session::get('lang');
    \App::setLocale($lang);
@endphp
{{csrf_field()}}    
<input type="hidden" name="depart_id" value="{{$departments->depart_id}}">
<div class="form-group">
<label class="col-md-2 control-label">{{trans('strings.department-input-name')}}</label>
    <div class="col-md-10">
        <input type="text" name="name" required="" class="form-control" value="{{$departments->name}}"/>
    </div>
</div>
<div class="form-group">
    <label class="col-md-2 control-label">{{trans('strings.select_college')}}</label>
        <div class="col-md-10">
            <select id="collegeSelect" class="form-control js-departments" type="text" name="college_id">
                <optgroup  label="{{trans('strings.select_college_first')}}">
                    
                    @foreach($colleges as $college)
                    @if($college->college_id == $departments->college_id)
                        <option selected="selected" value="{{$college->college_id}}">{{$college->name}}</option>
                    @else
                        <option value="{{$college->college_id}}">{{$college->name}}</option>
                    @endif
                    @endforeach
                    
                </optgroup>
            </select>
        </div>
</div>