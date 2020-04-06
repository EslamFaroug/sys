@php 
    $lang = Session::get('lang');
    \App::setLocale($lang);
@endphp
{{csrf_field()}}     
<input type="hidden" name="special_id" value="{{$specials->special_id}}">
<div class="form-group">
    <label class="col-md-2 control-label">{{trans('strings.special-input-name')}}</label>
    <div class="col-md-10">
       <input type="text" name="name" class="form-control" value="{{$specials->name}}" />
    </div>
</div>
<div class="form-group">
    <label class="col-md-2 control-label">{{trans('strings.select_specil_type')}}</label>
        <div class="col-md-10">
            <select id="specialTypesSelect" class="form-control js-specials" type="text" name="special_type">
                <optgroup  label="{{trans('strings.select_type_sp-label')}}">
                    <option style="color: gray" selected="selected" hidden="hidden">{{trans('strings.select_type_sp-label')}}</option>
                    <option value="1">{{trans('strings.special_type_s')}}</option>
                    <option value="2">{{trans('strings.special_type_g')}}</option>

                </optgroup>
            </select>
        </div>
</div>
<div class="form-group">
    <label class="col-md-2 control-label">{{trans('strings.special_depart')}}</label>
        <div class="col-md-10">
            <select id="departmentSelect" class="form-control js-specials" type="text" name="depart_id">
                <optgroup  label="{{trans('strings.select_depart_first')}}">
                    @foreach($departments as $dept)
                    @if($dept->depart_id == $specials->depart_id)
                        <option selected="selected" value="{{$dept->depart_id}}">{{$dept->name}}</option>
                    @else
                        <option value="{{$dept->depart_id}}">{{$dept->name}}</option>
                    @endif
                    @endforeach
                </optgroup>
            </select>
        </div>
</div>