
    {{csrf_field()}}
    <input type="hidden" name="exp_id" value="{{$experience->exp_id}}">

    <div class="form-group">
        <label class="col-md-3 control-label">{{trans('strings.t_name')}}</label>
        <div class="col-md-9">
            <select id="teacherSelect" required class="form-control js-teachers" type="text" name="teacher_id">
                <optgroup  label="{{trans('strings.select_tr_name')}}">
                    <option style="color: gray"  value="" hidden="hidden"> {{trans('strings.select_tr_name')}} </option>
                    @foreach($teachers as $teacher)
                        <option value="{{$teacher->teacher_id}}" @if($experience->teacher_id==$teacher->teacher_id) selected @endif>{{$teacher->ar_name}}</option>
                    @endforeach
                </optgroup>
            </select>
        </div>
    </div>

    <div class="form-group">
        <label class="col-md-3 control-label">{{trans('strings.job_type')}}</label>
        <div class="col-md-9">
            <div class="form-group">
                <div class="col-lg-4 col-md-4 col-sm-4">
                    <label class="check"><input type="radio" disabled @if($experience->degree_id) checked="" @endif required value="job_teach" class="iradio" name="iradio"/> {{trans('strings.teach')}}</label>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4">
                    <label class="check"><input type="radio" disabled  @if($experience->mangejob_id) checked="" @endif  required value="job_mange" class="iradio" name="iradio" /> {{trans('strings.mange')}}</label>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4">
                    <label class="check"><input type="radio" disabled @if($experience->exp_name) checked="" @endif  required value="exp" class="iradio" name="iradio" /> {{trans('strings.exp')}}</label>
                </div>
            </div>
        </div>
    </div>


    @if($experience->degree_id)
        <!-- job_teach-->
        <div id="job_teach" style=" margin-bottom: 15px;">
            <div class="form-group">
                <label class="col-md-3 control-label">{{trans('strings.job_teach')}}</label>
                <div class="col-md-9">
                    <select id="degreeSelect" class="form-control js-teachers" type="text" name="degree_id">
                        <optgroup  label="{{trans('strings.select_degree-label')}}">
                            <option style="color: gray"  selected hidden="hidden" value=""> {{trans('strings.select_degree-label')}} </option>
                            @foreach($degrees as $degree)
                                <option value="{{$degree->degree_id}}" @if($experience->degree_id==$degree->degree_id) selected @endif>{{$degree->name}}</option>
                            @endforeach
                        </optgroup>
                    </select>
                </div>
            </div>
        </div>
    @elseif($experience->mangejob_id)
        <!-- job_mange-->
        <div id="job_mange" style=" margin-bottom: 15px;">
            <div class="form-group">
                <label class="col-md-3 control-label">{{trans('strings.job_mange')}}</label>
                <div class="col-md-9">
                    <select id="mangeSelect" class="form-control js-teachers" type="text" name="mangejob_id">
                        <optgroup  label="{{trans('strings.select_mange_label')}}">
                            <option value="na"> لا يوجد </option>
                            <option style="color: gray" selected  hidden="hidden" value="">{{trans('strings.select_mange_label')}} </option>
                            @foreach($mangejobs as $mange)
                                <option value="{{$mange->mangejob_id}}" @if($experience->mangejob_id==$mange->mangejob_id) selected @endif>{{$mange->name}}</option>
                            @endforeach
                        </optgroup>
                    </select>
                </div>
            </div>
        </div>

    @elseif($experience->exp_name!="")
        <!-- exp-->
        <div id="exp" style="  margin-bottom: 15px;">
            <div class="form-group">
                <label class="col-md-3 control-label">{{trans('strings.exp_name')}}</label>
                <div class="col-md-9">
                    <input type="text" value="{{$experience->exp_name}}" name="exp_name" class="form-control" placeholder="{{trans('strings.exp_name_placeholder')}}" />
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-3 control-label">{{trans('strings.exp_institute')}}</label>
                <div class="col-md-9">
                    <input type="text" value="{{$experience->institute}}" name="institute" class="form-control" placeholder="{{trans('strings.institute_placeholder')}}" />
                </div>
            </div>
        </div>
    @endif

    @if($experience->degree_id or $experience->mangejob_id)

    <div id="uni" style="  margin-bottom: 15px;">
        <div class="form-group">
            <label class="col-md-3 control-label">{{trans('strings.select_university')}}</label>
            <div class="col-md-9">
                <select onchange="getColleges(this.value())" id="universitySelect" class="form-control js-specials" type="text" name="university_id">
                    <optgroup  label="{{trans('strings.select_univers-label')}}">
                        <option style="color: gray" selected  hidden="hidden" value=""> {{trans('strings.select_univers-label')}} </option>
                        @foreach($universities as $unive)
                            <option value="{{$unive->university_id}}" @if($experience->university_id==$unive->university_id) selected @endif>{{$unive->name}}</option>
                        @endforeach
                    </optgroup>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label">{{trans('strings.select_college')}}</label>
            <div class="col-md-9">
                <select id="collegeSelect" class="form-control js-specials" name="college_id">
                    <option selected="selected" value="">{{trans('strings.select_college_first')}}</option>
                    @foreach($experience->universities->colleges as $college)
                        <option value="{{$college->college_id}}" @if($experience->college_id==$college->college_id) selected @endif>{{$college->name}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label">{{trans('strings.special_depart')}}</label>
            <div class="col-md-9">
                <select id="departmentSelect" class="form-control js-specials" name="depart_id">
                    <option selected="selected" value="">{{trans('strings.select_depart_first')}}</option>
                    @foreach($experience->colleges->departments as $department)
                        <option value="{{$department->depart_id}}" @if($experience->depart_id==$department->depart_id) selected @endif>{{$department->name}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label">{{trans('strings.special-input-name')}}</label>
            <div class="col-md-9">
                <select   id="specialSelect" class="form-control js-specials" name="special_id">
                    <option selected="selected" value="">{{trans('strings.select_special_first')}}</option>
                    @foreach($experience->departments->specials as $special)
                        <option value="{{$special->special_id}}" @if($experience->special_id==$special->special_id) selected @endif>{{$special->name}}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

@endif



    <!-- Address Information-->
    <div class="form-group">
        <label class="col-md-3 control-label">{{trans('strings.work_type')}}</label>
        <div class="col-md-9">
            <select id="degreeSelect" class="form-control js-teachers" type="text" name="work_id">
                <optgroup  label="{{trans('strings.work_type_label')}}">
                    <option style="color: gray" selected="selected" hidden="hidden"> {{trans('strings.work_type_label')}} </option>
                    @foreach($work_types as $work_ty)
                        <option value="{{$work_ty->work_id}}"  @if($experience->work_id==$work_ty->work_id) selected @endif>{{$work_ty->name}}</option>
                    @endforeach
                </optgroup>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-3 control-label">{{trans('strings.type_domain')}}</label>
        <div class="col-md-9">
            <select id="degreeSelect" class="form-control js-teachers" type="text" name="type_id">
                <optgroup  label="{{trans('strings.type_domain_label')}}">
                    <option style="color: gray" selected="selected" hidden="hidden"> {{trans('strings.type_domain_label')}} </option>
                    @foreach($types as $w_ty)
                        <option value="{{$w_ty->type_id}}" @if($experience->type_id==$w_ty->type_id) selected @endif>{{$w_ty->name}}</option>
                    @endforeach
                </optgroup>
            </select>
        </div>
    </div>
    <!-- Country -->

    <div class="form-group">
        <label class="col-md-3 control-label">{{trans('strings.place_country')}}</label>
        <div class="col-md-9">
            <select onchange="getStates(this.value())" id="countrySelect" class="form-control js-regionals" type="text" name="countery_id">
                <optgroup  label="{{trans('strings.select_state-label')}}">
                    <option style="color: gray" selected="selected" hidden="hidden"> {{trans('strings.select_state-label')}} </option>
                    @foreach($countreis as $count)
                        <option value="{{$count->countery_id}}" @if($experience->countery_id==$count->countery_id) selected @endif>{{$count->name}}</option>
                    @endforeach
                </optgroup>
            </select>
        </div>
    </div>

    <div class="form-group">
        <label class="col-md-3 control-label">{{trans('strings.work_place_2')}}</label>
        <div class="col-md-9">
            <input type="text" name="work_place_2" value="{{$experience->work_place_2}}" class="form-control" placeholder="{{trans('strings.work_place_2_placeholder')}}" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-3 control-label">{{trans('strings.st_date')}}</label>
        <div class="col-md-9">
            <input type="text"  name="start_date" id="from-datepicker" class="form-control datepicker" value="{{$experience->start_date}}">
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-3 control-label">{{trans('strings.end_date')}}</label>
        <div class="col-md-9">
            <input type="text"  name="end_date" id="from-datepicker" class="form-control datepicker" value="{{$experience->end_date}}">
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-3 control-label">{{trans('strings.work_decrip')}}</label>
        <div class="col-md-9">
            <input type="text" name="decrip" class="form-control" placeholder="{{trans('strings.decrip_placeholder')}}" value="{{$experience->decrip}}" />
        </div>
    </div>


