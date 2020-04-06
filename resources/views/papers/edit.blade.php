@php
    $lang = Session::get('lang');
    \App::setLocale($lang);
@endphp
    <script type="text/javascript" src="{{asset('/js/plugins/fileinput/fileinput.min.js')}}"></script>
     {{csrf_field()}}
<input type="hidden" id="paper_id" name="paper_id" value="{{$papers->paper_id}}">

<div class="form-group">
    <label class="col-md-2 control-label">{{trans('strings.t_name')}}</label>
        <div class="col-md-10">
            <select id="departmentSelect" class="form-control js-specials" type="text" name="teacher_id">
                <optgroup  label="{{trans('strings.select_depart_first')}}">
                    @foreach($teachers as $tr)
                    @if($tr->teacher_id == $papers->teacher_id)
                        <option selected="selected" value="{{$tr->teacher_id}}">{{$tr->ar_name}}</option>
                    @else
                        <option value="{{$tr->teacher_id}}">{{$tr->ar_name}}</option>
                    @endif
                    @endforeach
                </optgroup>
            </select>
        </div>
</div>
<body bgcolor="" size="3"></body>
<div class="form-group">
    <label class="col-md-2 control-label">{{trans('strings.paper-input-label')}}</label>
    <div class="col-md-10">
    <input type="text" name="title" required="
                                " class="form-control" value="{{$papers->title}}" />
    </div>
</div>

<div class="form-group">
    <label class="col-md-2 control-label">{{trans('strings.paper-input-place')}}</label>
    <div class="col-md-10">
        <input type="text" name="publish_place" required="" class="form-control" value="{{$papers->publish_place}}" />
    </div>
</div>

<div class="form-group">
    <label class="col-md-2 control-label">{{trans('strings.publis_date')}}</label>
        <div class="col-md-10">
            <input type="text"  name="publis_date" id="from-datepicker" class="form-control datepicker" value="{{$papers->publis_date}}">
        </div>
</div>

<div class="form-group">
    <label class="col-md-2 control-label">{{trans('strings.volume_no-input-place')}}</label>
    <div class="col-md-10">
    <input type="text" name="volume_no" required="
                                " class="form-control" value="{{$papers->volume_no}}" />
    </div>
</div>
<body size=""></body>
<div class="form-group">
    <div class="col-md-12">
        <label>{{trans('strings.paper_file')}}:  <span style="color: red">{{trans('strings.info_p')}} </span></label>
        <input id="certificat-upload-field" type="file" class="file" data-preview-file-type="any" name="file"  />
    </div>
</div>

