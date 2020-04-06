@php
    $lang = Session::get('lang');
    \App::setLocale($lang);
@endphp
  <script type="text/javascript" src="{{asset('/js/plugins/fileinput/fileinput.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('/js/plugins/filetree/jqueryFileTree.js')}}"></script>
    <script type='text/javascript' src="{{('/js/plugins/icheck/icheck.min.js')}}"></script>
    <script type="text/javascript" src="{{('/js/plugins/mcustomscrollbar/jquery.mCustomScrollbar.min.js')}}"></script>
    <script type="text/javascript" src="{{('/js/plugins/datatables/jquery.dataTables.min.js')}}"></script>
    <script type='text/javascript' src="{{('/js/plugins/bootstrap/bootstrap-datepicker.js')}}"></script>
{{csrf_field()}}
<input type="hidden" name="train_id" value="{{$trains->train_id}}">

<div class="form-group">
    <label class="col-md-2 control-label">{{trans('strings.t_name')}}</label>
    <div class="col-md-10">
    <select id="teacherSelect" class="form-control js-teachers" type="text" name="teacher_id">
        <optgroup  label="{{trans('strings.select_tr_name')}}">
            @foreach($teachers as $teacher)
            @if($teacher->teacher_id == $trains->teacher_id)
            <option value="{{$teacher->teacher_id}}">{{$teacher->ar_name}}</option>
            @else
            <option value="{{$teacher->teacher_id}}">{{$teacher->ar_name}}</option>
            @endif
            @endforeach
        </optgroup>
    </select>
    </div>
</div>
<div class="form-group">
    <label class="col-md-2 control-label">{{trans('strings.title-input-label')}}</label>
    <div class="col-md-10">
    <input type="text" name="title" class="form-control" value="{{$trains->title}}" />
    </div>
</div>
<div class="form-group">
    <label class="col-md-2 control-label">{{trans('strings.institute-input-label')}}</label>
        <div class="col-md-10">
            <input type="text" name="institute" class="form-control" value="{{$trains->institute}}"/>
        </div>
</div>

<div class="form-group">
    <label class="col-md-2 control-label">{{trans('strings.training place')}}</label>
    <div class="col-md-10">
    <select id="teacherSelect" class="form-control js-teachers" type="text" name="countery_id">
        <optgroup  label="{{trans('strings.select_tr_name')}}">
            @foreach($countreis as $count)
             @if($count->countery_id == $trains->countery_id)
            <option value="{{$count->countery_id}}">{{$count->name}}</option>
            @else
            <option value="{{$count->countery_id}}">{{$count->name}}</option>
            @endif
            @endforeach
        </optgroup>
    </select>
    </div>
</div>
<div class="form-group">
    <label class="col-md-2 control-label">{{trans('strings.track of training')}}</label>
        <div class="col-md-10">
            <select id="specialSelect" class="form-control js-teachers" type="text" name="special_id">
            <optgroup  label="{{trans('strings.select_special_track')}}">
                @foreach($specials as $special)
                @if($special->special_id == $trains->special_id)
                <option value="{{$special->special_id}}">{{$special->name}}</option>
                @else
                <option value="{{$special->special_id}}">{{$special->name}}</option>
                @endif
                @endforeach
            </optgroup>
            </select>
        </div>
</div>
<div class="form-group">
    <label class="col-md-2 control-label">{{trans('strings.st_date')}}</label>
        <div class="col-md-10">
            <input type="text"  name="st_date" id="from-datepicker" class="form-control datepicker" value="{{$trains->st_date}}">
        </div>
</div>
<div class="form-group">
    <label class="col-md-2 control-label">{{trans('strings.end_date')}}</label>
        <div class="col-md-10">
            <input type="text"  name="end_date" id="from-datepicker" class="form-control datepicker" value="{{$trains->end_date}}">
        </div>
</div>
<div class="form-group">
    <label class="col-md-2 control-label">{{trans('strings.train_file')}}</label>
    <div class="col-md-10">
        <div class="filezone" filezone-input-name="image" filezone-image-path="{{asset($trains->path)}}"></div>
    </div>
</div>

<script type="text/javascript">
    var filezone = new Filezone();
</script>
