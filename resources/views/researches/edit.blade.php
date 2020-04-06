@php
    $lang = Session::get('lang');
    \App::setLocale($lang);
@endphp
<script type="text/javascript" src="{{asset('/js/plugins/fileinput/fileinput.min.js')}}"></script>

{{csrf_field()}}
<input type="hidden" id="research_id" name="research_id" value="{{$research->research_id}}">

    <div class="form-group">
        <label class="col-md-3 control-label">{{trans('strings.t_name')}}</label>
        <div class="col-md-9">
            <select id="teacherSelect" class="form-control js-teachers" type="text" name="teacher_id">
                <optgroup  label="{{trans('strings.select_tr_name')}}">
                    <option style="color: gray" value="" selected="selected" hidden="hidden"> {{trans('strings.select_tr_name')}} </option>
                    @foreach($teachers as $teacher)
                        <option value="{{$teacher->teacher_id}}" @if($research->teacher_id==$teacher->teacher_id) selected @endif>{{$teacher->ar_name}}</option>
                    @endforeach
                </optgroup>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-3 control-label">{{trans('strings.research-input-label')}}</label>
        <div class="col-md-9">
            <input type="text" name="title" value="{{$research->title}}"  required="
                                " class="form-control" placeholder="{{trans('strings.research-input-placeholder')}}" />
        </div>
    </div>

    <div class="form-group">
        <label class="col-md-3 control-label">{{trans('teacher.degree')}}</label>
        <div class="col-md-9">
            <select id="degreeSelect" class="form-control js-teachers" type="text" name="degree_id">
                <optgroup  label="{{trans('teacher.select_degree-label')}}">
                    <option style="color: gray" value="" selected="selected" hidden="hidden"> {{trans('teacher.select_degree-label')}} </option>
                    @foreach($degrees as $degree)
                        <option value="{{$degree->degree_id}}" @if($research->degree_id==$degree->degree_id) selected @endif>{{$degree->name}}</option>
                    @endforeach
                </optgroup>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-md-3" for="degree">{{trans('strings.supper')}}</label>
        <div class="col-md-9">
            <select name="sup_id" id="degree" class="form-control" placeholder="الدرجة العلمية" >
                <option disabled="disabled" value="" hidden="hidden" selected="selected">{{trans('strings.tr_supper')}}</option>
                @foreach($teachers as $tech)
                    <option value="{{$tech->teacher_id}}"  @if($research->supervisor_id==$tech->teacher_id) selected @endif> @if($lang == 'ar')
                            {{$tech->ar_name}}
                        @else
                            {{$tech->en_name}}
                        @endif</option>
                @endforeach
            </select>
        </div>
    </div>
    <input type="hidden" value="0" id="other_supervisor" name="other_supervisor">
    <br>
    <div class="form-group">
        <label class="col-md-3 control-label">{{trans('strings.publis_date')}}</label>
        <div class="col-md-9">
            <input type="text"  name="publish_date"  value="{{$research->publish_date}}" id="from-datepicker" class="form-control datepicker">
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-3 control-label">{{trans('strings.paper-input-place')}}</label>
        <div class="col-md-9">
            <input type="text" name="publish_place"  value="{{$research->publish_place}}" required="
                                " class="form-control" placeholder="{{trans('strings.paper-place-placeholder')}}" />
        </div>
    </div>
    <div class="form-group">
        <div class="col-md-12">
            <label>{{trans('strings.paper_file')}} :  <span style="color: red">{{trans('strings.info_p')}} </span></label>
            <input id="certificat-upload-field" type="file" class="file" data-preview-file-type="any" name="file" />
        </div>
    </div>

    <div>
        @foreach ($errors->all() as $error)
            {{ $error }} <br>
        @endforeach
    </div>


