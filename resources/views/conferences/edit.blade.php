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

<input type="hidden" name="conf_id" value="{{$conferences->conf_id}}">
<div class="form-group">
    <label class="col-md-3 control-label">{{trans('strings.t_name')}}</label>
        <div class="col-md-9">
            <select id="teacherSelect" class="form-control js-conferences" type="text" name="teacher_id">
                <optgroup  label="{{trans('strings.select_tr_name')}}">
                    <option style="color: gray" selected="selected" hidden="hidden"> {{trans('strings.select_tr_name')}} </option>
                    @foreach($teachers as $teacher)
                    @if($teacher->teacher_id == $conferences->teacher_id)
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
<label class="col-md-3 control-label">{{trans('strings.conf-input-name')}}</label>
    <div class="col-md-9">
        <input type="text" name="name" required="" class="form-control" value="{{$conferences->name}}"/>
    </div>
</div>
<div class="form-group">
    <label class="col-md-3 control-label">{{trans('strings.select_country')}}</label>
        <div class="col-md-9">
            <select id="countrySelect" class="form-control js-conferences" type="text" name="countery_id">
                <optgroup  label="{{trans('strings.select_state-label')}}">

                    @foreach($countreis as $count)
                    @if($count->countery_id == $conferences->countery_id)
                        <option selected="selected" value="{{$count->countery_id}}">{{$count->name}}</option>
                    @else
                        <option value="{{$count->countery_id}}">{{$count->name}}</option>
                    @endif
                    @endforeach
                </optgroup>
            </select>
        </div>
</div>
<div class="form-group">
    <label class="col-md-3 control-label">{{trans('strings.select_state')}}</label>
        <div class="col-md-9">
            <select id="stateSelect" class="form-control js-conferences" type="text" name="state_id">
                <optgroup  label="{{trans('strings.select_re_state-label')}}">

                    @foreach($states as $state)
                    @if($state->state_id == $conferences->state_id)
                        <option selected="selected" value="{{$state->state_id}}">{{$state->name}}</option>
                    @else
                        <option value="{{$state->state_id}}">{{$state->name}}</option>
                    @endif
                    @endforeach
                </optgroup>
            </select>
        </div>
</div>

<div class="form-group">
    <label class="col-md-3 control-label">{{trans('strings.participant_type')}}</label>
        <div class="col-md-4">
            <label class="check"><input type="radio" id="participants" class="iradio" name="participant" value="2" @if($conferences->participant==2) checked @endif />  {{trans('strings.participants')}}</label>
        </div>
        <div class="col-md-4">
            <label class="check"><input type="radio" id="member" class="iradio" name="participant" value="1" @if($conferences->participant==1) checked @endif/>  {{trans('strings.member')}} </label>
        </div>
</div>

<div class="form-group">
<label class="col-md-3 control-label">{{trans('strings.conf_date')}}</label>
    <div class="col-md-9">
        <input type="text" name="conf_date" id="from-datepicker" required="" class="form-control datepicker" value="{{$conferences->conf_date}}"/>
    </div>
</div>
