@php 
    $lang = Session::get('lang');
    \App::setLocale($lang);
@endphp
{{csrf_field()}}  

<input type="hidden" name="interest_id" value="{{$interests->interest_id}}">
<div class="form-group">
    <label class="col-md-3 control-label">{{trans('strings.t_name')}}</label>
        <div class="col-md-9">
            <select id="teacherSelect" class="form-control js-teachers" type="text" name="teacher_id">
                <optgroup  label="{{trans('strings.select_tr_name')}}">
                    <option style="color: gray" selected="selected" hidden="hidden"> {{trans('strings.select_tr_name')}} </option>
                    @foreach($teachers as $teacher)
                    @if($teacher->teacher_id == $interests->teacher_id)
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
    <label class="col-md-3 control-label">{{trans('strings.interest-input-label')}}</label>
    <div class="col-md-9">
       <input type="text" name="title" class="form-control" value="{{$interests->title}}" />
    </div>
</div>
<div class="form-group">
    <label class="col-md-3 control-label">{{trans('strings.descrip-input-int')}}</label>
    <div class="col-md-9">
       <input type="text" name="descrip" class="form-control" value="{{$interests->descrip}}" />
    </div>
</div>
