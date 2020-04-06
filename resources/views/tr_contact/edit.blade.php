@php
    $lang = Session::get('lang');
    \App::setLocale($lang);
@endphp
{{csrf_field()}}

<input type="hidden" name="contact_id" value="{{$contacts->contact_id}}">
<div class="form-group">
    <label class="col-md-2 control-label">{{trans('strings.t_name')}}</label>
        <div class="col-md-10">
            <select id="teacherSelect" class="form-control js-contacts" type="text" name="teacher_id">
                <optgroup  label="{{trans('strings.select_depart_first')}}">
                    @foreach($teachers as $teacher)
                    @if($teacher->teacher_id == $contacts->teacher_id)
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
    <label class="col-md-2 control-label">{{trans('strings.tr-email')}}</label>
    <div class="col-md-10">
       <input type="text" name="email" class="form-control" value="{{$contacts->email}}" placeholder="{{trans('strings.email-input-placeholder')}}" />
    </div>
</div>
<div class="form-group">
    <label class="col-md-2 control-label">{{trans('strings.tr-mobile')}}</label>
    <div class="col-md-10">
       <input type="text" name="mobile_no" class="form-control" value="{{$contacts->mobile_no}}"  placeholder="{{trans('strings.mobile-input-placeholder')}}"/>
    </div>
</div>
<div class="form-group">
    <label class="col-md-2 control-label">{{trans('strings.tr-tel')}}</label>
    <div class="col-md-10">
       <input type="text" name="tel_no" class="form-control" value="{{$contacts->tel_no}}"   placeholder="{{trans('strings.tel-input-placeholder')}}"/>
    </div>
</div>
<div class="form-group">
    <label class="col-md-2 control-label">{{trans('strings.tr-home')}}</label>
    <div class="col-md-10">
       <input type="text" name="home_no" class="form-control" value="{{$contacts->home_no}}"  placeholder="{{trans('strings.tel-input-placeholder')}}"/>
    </div>
</div>
<div class="form-group">
    <label class="col-md-2 control-label">{{trans('strings.tr-web')}}</label>
    <div class="col-md-10">
       <input type="text" name="tr_web" class="form-control" value="{{$contacts->tr_web}}"  placeholder="{{trans('strings.web-input-placeholder')}}" />
    </div>
</div>

<div class="form-group">
    <label class="col-md-2 control-label">{{trans('strings.select_unive')}}</label>
        <div class="col-md-10">
            <select id="univeritySelect"  class="form-control js-contacts" type="text" name="university_id">
                <optgroup  label="{{trans('strings.select_college-label')}}">
                    <option style="color: gray" selected="selected" value="" > {{trans('strings.select_univers-label')}} </option>
                    @foreach($universities as $unive)
                    @if($unive->university_id == $contacts->university_id)
                        <option selected="selected" value="{{$unive->university_id}}">{{$unive->name}}</option>
                    @else
                        <option value="{{$unive->university_id}}">{{$unive->name}}</option>
                    @endif
                    @endforeach
                </optgroup>
            </select>
        </div>
</div>

<div class="form-group">
    <label class="col-md-2 control-label">{{trans('strings.select_college')}}</label>
        <div class="col-md-10">
            <select @if(!$contacts->university_id) disabled @endif id="collegeSelect1" class="form-control js-contacts" type="text" name="college_id">
                <optgroup  label="{{trans('strings.select_college_first')}}">
                    <option selected="selected"  value="">{{trans('strings.select_college_first')}}</option>
                @if($contacts->university_id)
                    @foreach($contacts->universities->colleges as $college)
                    @if($college->college_id == $contacts->college_id)
                        <option selected="selected" value="{{$college->college_id}}">{{$college->name}}</option>
                    @else
                        <option value="{{$college->college_id}}">{{$college->name}}</option>
                    @endif
                    @endforeach
                        @endif
                </optgroup>
            </select>
        </div>
</div>

<div class="form-group">
    <label class="col-md-2 control-label">{{trans('strings.special_depart')}}</label>
        <div class="col-md-10">
            <select @if(!$contacts->college_id) disabled @endif  id="departmentSelect1" class="form-control js-contacts" type="text" name="depart_id">
                <optgroup  label="{{trans('strings.select_depart_first')}}">
                    <option selected="selected"  value="">{{trans('strings.select_depart_first')}}</option>
                    @if($contacts->college_id)
                    @foreach($contacts->colleges->departments as $dept)
                    @if($dept->depart_id == $contacts->depart_id)
                        <option selected="selected" value="{{$dept->depart_id}}">{{$dept->name}}</option>
                    @else
                        <option value="{{$dept->depart_id}}">{{$dept->name}}</option>
                    @endif
                    @endforeach
                    @endif
                </optgroup>
            </select>
        </div>
</div>

<div class="form-group">
    <label class="col-md-2 control-label">{{trans('strings.special-input-name')}}</label>
        <div class="col-md-10">
            <select @if(!$contacts->depart_id) disabled @endif  id="specialSelect1" class="form-control js-contacts" type="text" name="special_id">
                <optgroup  label="{{trans('strings.select_depart_first')}}">
                    <option selected="selected" value="">{{trans('strings.select_special_first')}}</option>
                    @if($contacts->depart_id)
                    @foreach($contacts->departments->specials as $special)
                    @if($special->special_id == $contacts->special_id)
                        <option selected="selected" value="{{$special->special_id}}">{{$special->name}}</option>
                    @else
                        <option value="{{$special->special_id}}">{{$special->name}}</option>
                    @endif
                    @endforeach
                    @endif
                </optgroup>
            </select>
        </div>
</div>

<div class="form-group">
    <label class="col-md-2 control-label">{{trans('strings.select_country')}}</label>
        <div class="col-md-10">
            <select id="countrySelect1" class="form-control js-contacts" type="text" name="countery_id">
                <optgroup  label="{{trans('strings.select_state-label')}}">
                    <option style="color: gray" selected="selected" value=""> {{trans('strings.select_state-label')}} </option>
                    @foreach($countreis as $count)
                    @if($count->countery_id == $contacts->countery_id)
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
    <label class="col-md-2 control-label">{{trans('strings.select_re_state-label')}}</label>
        <div class="col-md-10">
            <select @if(!$contacts->countery_id) disabled @endif id="stateSelect1" class="form-control js-contacts" type="text" name="state_id">
                <optgroup  label="{{trans('strings.select_re_state-label')}}">
                    <option style="color: gray" selected="selected" value=""> {{trans('strings.select_st_first')}} </option>
                    @if($contacts->countery_id)
                    @foreach($contacts->countreis->states as $state)
                    @if($state->state_id == $contacts->state_id)
                        <option selected="selected" value="{{$state->state_id}}">{{$state->name}}</option>
                    @else
                        <option value="{{$state->state_id}}">{{$state->name}}</option>
                    @endif
                    @endforeach
                    @endif
                </optgroup>
            </select>
        </div>
</div>
<div class="form-group">
    <label class="col-md-2 control-label">{{trans('strings.select_un_region-label')}}</label>
        <div class="col-md-10">
            <select @if(!$contacts->state_id) disabled @endif id="regionalSelect1" class="form-control js-contacts" type="text" name="regional_id">

                <optgroup  label="{{trans('strings.select_un_region-label')}}">
                    <option style="color: gray" selected="selected" value=""> {{trans('strings.select_reg_first')}} </option>
                @if($contacts->state_id)
                    @foreach($contacts->states->regionals as $reg)
                    @if($reg->regional_id == $contacts->regional_id)
                        <option selected="selected" value="{{$reg->regional_id}}">{{$reg->name}}</option>
                    @else
                        <option value="{{$reg->regional_id}}">{{$reg->name}}</option>
                    @endif
                    @endforeach
                    @endif

                </optgroup>
            </select>
        </div>
</div>
<div class="form-group">
    <label class="col-md-2 control-label">{{trans('strings.unit-input-name')}}</label>
        <div class="col-md-10">
            <select @if(!$contacts->regional_id) disabled @endif id="unitlSelect1" class="form-control js-contacts" type="text" name="unit_id">
                <optgroup  label="{{trans('strings.select_un_region-label')}}">
                    <option style="color: gray" selected="selected" value=""> {{trans('strings.select_unit_first')}} </option>
                @if($contacts->regional_id)
                    @foreach($contacts->regionals->units as $unit)
                    @if($unit->unit_id == $contacts->unit_id)
                        <option selected="selected" value="{{$unit->unit_id}}">{{$unit->name}}</option>
                    @else
                        <option value="{{$unit->unit_id}}">{{$unit->name}}</option>
                    @endif
                    @endforeach
                    @endif

                </optgroup>
            </select>
        </div>
</div>

<script>

    // Education Information:=>
    $(document).ready(function(){

        $('#univeritySelect').on('change',function(){

            let id = $(this).val();
            if(id) {
                $.ajax({
                    url: '{{url("universities/getColleges")}}',
                    type: 'post',
                    data: '_token={{csrf_token()}}&uid=' + id,
                    success: function (response) {
                        $('#collegeSelect1').html(response);
                        $('#collegeSelect1').removeAttr('disabled');
                        $('#departmentSelect1').attr('disabled', 'disabled');
                        $("#departmentSelect1").val("");
                        $('#specialSelect1').attr('disabled', 'disabled');
                        $("#specialSelect1").val("");
                    }
                });
            }else{
                $('#collegeSelect1').attr('disabled', 'disabled');
                $("#collegeSelect1").val("");
                $('#departmentSelect1').attr('disabled', 'disabled');
                $("#departmentSelect1").val("");
                $('#specialSelect1').attr('disabled', 'disabled');
                $("#specialSelect1").val("");
            }
        });
    })

    $(document).ready(function(){
        $('#collegeSelect1').on('change',function(){
            let id = $(this).val();
            if(id) {
                $.ajax({
                    url: '{{url("colleges/getDepartments")}}',
                    type: 'post',
                    data: '_token={{csrf_token()}}&cid=' + id,
                    success: function (response) {
                        $('#departmentSelect1').html(response);
                        $('#departmentSelect1').removeAttr('disabled');
                        $('#specialSelect1').attr('disabled', 'disabled');
                        $("#specialSelect1").val("");
                    }
                });
            }else{
                $('#departmentSelect1').attr('disabled', 'disabled');
                $("#departmentSelect1").val("");
                $('#specialSelect1').attr('disabled', 'disabled');
                $("#specialSelect1").val("");
            }
        });
    })

    $(document).ready(function(){
        $('#departmentSelect1').on('change',function(){
            let id = $(this).val();
            if(id){
                $.ajax({
                    url: '{{url("specials/getSpecials")}}',
                    type: 'post',
                    data: '_token={{csrf_token()}}&sid='+id,
                    success: function(response) {
                        $('#specialSelect1').html(response);
                        $('#specialSelect1').removeAttr('disabled');
                    }
                });

            }else{
                $('#specialSelect1').attr('disabled', 'disabled');
                $("#specialSelect1").val("");
            }
        });
    })

    // Address Information:=>

    $(document).ready(function(){
        $('#countrySelect1').on('change',function(){
            let id = $(this).val();
            if(id) {
                $.ajax({
                    url: '{{url("countries/getStates")}}',
                    type: 'post',
                    data: '_token={{csrf_token()}}&cid=' + id,
                    success: function (response) {
                        $('#stateSelect1').html(response);
                        $('#stateSelect1').removeAttr('disabled');
                        $('#regionalSelect1').attr('disabled', 'disabled');
                        $("#regionalSelect1").val("");
                        $('#unitlSelect1').attr('disabled', 'disabled');
                        $("#unitlSelect1").val("");
                    }
                });
            }else{
                $('#stateSelect1').attr('disabled', 'disabled');
                $("#stateSelect1").val("");
                $('#regionalSelect1').attr('disabled', 'disabled');
                $("#regionalSelect1").val("");
                $('#unitlSelect1').attr('disabled', 'disabled');
                $("#unitlSelect1").val("");
            }
        });
    })


    $(document).ready(function(){
        $('#stateSelect1').on('change',function(){
            let id = $(this).val();
            if(id) {
                $.ajax({
                    url: '{{url("states/getRegional")}}',
                    type: 'post',
                    data: '_token={{csrf_token()}}&sid=' + id,
                    success: function (response) {
                        $('#regionalSelect1').html(response);
                        $('#regionalSelect1').removeAttr('disabled');
                        $('#unitlSelect1').attr('disabled', 'disabled');
                        $("#unitlSelect1").val("");
                    }
                });
            }else{
                $('#regionalSelect1').attr('disabled', 'disabled');
                $("#regionalSelect1").val("");
                $('#unitlSelect1').attr('disabled', 'disabled');
                $("#unitlSelect1").val("");
            }
        });

    })


    $(document).ready(function(){
        $('#regionalSelect1').on('change',function(){
            let id = $(this).val();
            if(id) {

                $.ajax({
                    url: '{{url("units/getUnits")}}',
                    type: 'post',
                    data: '_token={{csrf_token()}}&uid=' + id,
                    success: function (response) {
                        $('#unitlSelect1').html(response);
                        $('#unitlSelect1').removeAttr('disabled');
                    }
                });
            }else{
                $('#unitlSelect1').attr('disabled', 'disabled');
                $("#unitlSelect1").val("");
            }
        });
    })

</script>
