@php 
    $lang = Session::get('lang');
    \App::setLocale($lang);
@endphp
{{csrf_field()}}  

<input type="hidden" name="skill_id" value="{{$skills->skill_id}}">
<div class="form-group">
    <label class="col-md-2 control-label">{{trans('strings.t_name')}}</label>
        <div class="col-md-10">
            <select id="teacherSelect" class="form-control js-skills" type="text" name="teacher_id">
                <optgroup  label="{{trans('strings.select_depart_first')}}">
                    @foreach($teachers as $teacher)
                    @if($teacher->teacher_id == $skills->teacher_id)
                        <option selected="selected" value="{{$teacher->teacher_id}}">{{$teacher->ar_name}}</option>
                    @else
                        <option value="{{$teacher->teacher_id}}">{{$teacher->ar_name}}</option>
                    @endif
                    @endforeach
                </optgroup>
            </select>
        </div>
</div>
<div class="form-group">
    <label class="col-md-2 control-label">{{trans('strings.skill-input-label')}}</label>
    <div class="col-md-10">
       <input type="text" name="name" class="form-control" value="{{$skills->name}}" />
    </div>
</div>
<div class="form-group">
    <label class="col-md-2 control-label">{{trans('strings.decription-input-label')}}</label>
    <div class="col-md-10">
       <input type="text" name="decription" class="form-control" value="{{$skills->decription}}" />
    </div>
</div>
