@php
    $lang = Session::get('lang');
    \App::setLocale($lang);
@endphp

<style type="text/css">

    #certificat-upload-field-edit {
        display: none;
    }
    .custom-file-upload {
        border: 1px solid #ccc;
        display: inline-block;
        padding: 2px 4px;
        cursor: pointer;
    }

</style>

{{csrf_field()}}
<input type="hidden" name="cert_id" value="{{$certificates->cert_id}}">

<div class="form-group">
    <label class="col-md-2 control-label">{{trans('strings.t_name')}}</label>
        <div class="col-md-10">
            <select id="departmentSelect" class="form-control js-specials" type="text" name="teacher_id">
                <optgroup  label="{{trans('strings.select_depart_first')}}">
                    @foreach($teachers as $tr)
                    @if($tr->teacher_id == $certificates->teacher_id)
                        <option selected="selected" value="{{$tr->teacher_id}}">{{$tr->ar_name}}</option>
                    @else
                        <option value="{{$tr->teacher_id}}">{{$tr->ar_name}}</option>
                    @endif
                    @endforeach
                </optgroup>
            </select>
        </div>
</div>


<div class="form-group">
    <label class="col-md-2 control-label">{{trans('strings.degree')}}</label>
        <div class="col-md-10">
            <select id="departmentSelect" class="form-control js-specials" type="text" name="degree_id">
                <optgroup  label="{{trans('strings.select_depart_first')}}">
                    @foreach($degrees as $deg)
                    @if($deg->degree_id == $certificates->degree_id)
                        <option selected="selected" value="{{$deg->degree_id}}">{{$deg->name}}</option>
                    @else
                        <option value="{{$deg->degree_id}}">{{$deg->name}}</option>
                    @endif
                    @endforeach
                </optgroup>
            </select>
        </div>
</div>
<div class="form-group">
    <label class="col-md-2 control-label">{{trans('strings.ser_qual')}} </label>
        <div class="col-md-10">
                <input type="text" name="cert_name" class="form-control" value="{{$certificates->cert_name}}" />
        </div>
</div>


<div class="form-group">
    <label class="col-md-2 control-label">{{trans('strings.select_university')}}</label>
        <div class="col-md-10">
            <select id="departmentSelect" class="form-control js-specials" type="text" name="university_id">
                <optgroup  label="{{trans('strings.select_depart_first')}}">
                    @foreach($universities as $col)
                    @if($col->university_id == $certificates->university_id)
                        <option selected="selected" value="{{$col->university_id}}">{{$col->name}}</option>
                    @else
                        <option value="{{$col->university_id}}">{{$col->name}}</option>
                    @endif
                    @endforeach
                </optgroup>
            </select>
        </div>
</div>

<div class="form-group">
    <label class="col-md-2 control-label">{{trans('strings.select_college')}}</label>
        <div class="col-md-10">
            <select id="departmentSelect" class="form-control js-specials" type="text" name="college_id">
                <optgroup  label="{{trans('strings.select_depart_first')}}">
                    @foreach($colleges as $col)
                    @if($col->college_id == $certificates->college_id)
                        <option selected="selected" value="{{$col->college_id}}">{{$col->name}}</option>
                    @else
                        <option value="{{$col->college_id}}">{{$col->name}}</option>
                    @endif
                    @endforeach
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
                    @if($dept->depart_id == $certificates->depart_id)
                        <option selected="selected" value="{{$dept->depart_id}}">{{$dept->name}}</option>
                    @else
                        <option value="{{$dept->depart_id}}">{{$dept->name}}</option>
                    @endif
                    @endforeach
                </optgroup>
            </select>
        </div>
</div>
<div class="form-group">
    <label class="col-md-2 control-label">{{trans('strings.special-input-name')}}</label>
        <div class="col-md-10">
            <select id="departmentSelect" class="form-control js-specials" type="text" name="special_id">
                <optgroup  label="{{trans('strings.select_depart_first')}}">
                    @foreach($specials as $special)
                    @if($special->special_id == $certificates->special_id)
                        <option selected="selected" value="{{$special->special_id}}">{{$special->name}}</option>
                    @else
                        <option value="{{$special->special_id}}">{{$special->name}}</option>
                    @endif
                    @endforeach
                </optgroup>
            </select>
        </div>
</div>

<div class="form-group">
    <label class="col-md-2 control-label">{{trans('strings.select_country')}}</label>
        <div class="col-md-10">
            <select id="departmentSelect" class="form-control js-specials" type="text" name="countery_id">
                <optgroup  label="{{trans('strings.select_depart_first')}}">
                    @foreach($countreis as $unive)
                    @if($unive->countery_id == $certificates->countery_id)
                        <option selected="selected" value="{{$unive->countery_id}}">{{$unive->name}}</option>
                    @else
                        <option value="{{$unive->countery_id}}">{{$unive->name}}</option>
                    @endif
                    @endforeach
                </optgroup>
            </select>
        </div>
</div>

<div class="form-group">
    <label class="col-md-2 control-label">{{trans('strings.study')}}</label>
        <div class="col-md-10">
            <select id="departmentSelect" class="form-control js-specials" type="text" name="study_id">
                <optgroup  label="{{trans('strings.select_depart_first')}}">
                    @foreach($studes as $study)
                    @if($study->study_id == $certificates->study_id)
                        <option selected="selected" value="{{$study->study_id}}">{{$study->name}}</option>
                    @else
                        <option value="{{$study->study_id}}">{{$study->name}}</option>
                    @endif
                    @endforeach
                </optgroup>
            </select>
        </div>
</div>
<div class="form-group">
<label class="col-md-2 control-label">{{trans('strings.sert_grad')}}</label>
    <div class="col-md-10">
        <input type="text" name="sert_grade" required="" class="form-control" value="{{$certificates->sert_grade}}"/>
    </div>
</div>
<div class="form-group">
    <label class="col-md-2 control-label">{{trans('strings.certdate')}}</label>
    <div class="col-md-10">
       <input type="text"  name="cert_date" id="from-datepicker" class="form-control datepicker" value="{{$certificates->cert_date}}">
    </div>
</div>
<!-- <div class="form-group">
    <div class="col-md-12">
        <label>{{trans('strings.sert_img')}}</label>
        <input id="college-upload-field" type="file" class="file" data-preview-file-type="any" name="cert_image" />
    </div>
</div> -->
<div class="form-group">
    <label class="col-md-2 control-label">{{trans('strings.sert_img')}}</label>
    <div class="col-md-10">
        <div class="filezone" filezone-input-name="image" filezone-image-path="{{asset($certificates->cert_image)}}"></div>
    </div>
</div>


<script type="text/javascript">
    var filezone = new Filezone();
</script>
