@php
    $lang = Session::get('lang');
    \App::setLocale($lang);
@endphp
<div class="row">
    <div class="form-group row">
        <label class="col-md-2 control-label">{{trans('strings.t_name')}}</label>
        <div class="col-md-10">
            {{$certificate->teachers->ar_name}}
        </div>
    </div>


    <div class="form-group row">
        <label class="col-md-2 control-label">{{trans('strings.degree')}}</label>
        <div class="col-md-10">
            {{$certificate->degrees->name}}
        </div>
    </div>

    <div class="form-group row">
        <label class="col-md-2 control-label">{{trans('strings.ser_qual')}} </label>
        <div class="col-md-10">
            {{$certificate->cert_name}}
        </div>
    </div>


    <div class="form-group row">
        <label class="col-md-2 control-label">{{trans('strings.select_university')}}</label>
        <div class="col-md-10">
            {{$certificate->specials->departments->colleges->universities->name}}

        </div>
    </div>

    <div class="form-group row">
        <label class="col-md-2 control-label">{{trans('strings.select_college')}}</label>
        <div class="col-md-10">
            {{$certificate->specials->departments->colleges->name}}
        </div>
    </div>

    <div class="form-group row">
        <label class="col-md-2 control-label">{{trans('strings.special_depart')}}</label>
        <div class="col-md-10">
            {{$certificate->specials->departments->name}}

        </div>
    </div>
    <div class="form-group row">
        <label class="col-md-2 control-label">{{trans('strings.special-input-name')}}</label>
        <div class="col-md-10">
            {{$certificate->specials->name}}

        </div>
    </div>

    <div class="form-group row">
        <label class="col-md-2 control-label">{{trans('strings.select_country')}}</label>
        <div class="col-md-10">
            {{$certificate->countreis->name}}

        </div>
    </div>

    <div class="form-group row">
        <label class="col-md-2 control-label">{{trans('strings.study')}}</label>
        <div class="col-md-10">
            {{$certificate->studes->name}}

        </div>
    </div>
    <div class="form-group row">
        <label class="col-md-2 control-label">{{trans('strings.sert_grad')}}</label>
        <div class="col-md-10">
            {{$certificate->sert_grade}}
        </div>
    </div>
    <div class="form-group row">
        <label class="col-md-2 control-label">{{trans('strings.certdate')}}</label>
        <div class="col-md-10">
            {{$certificate->cert_date}}
        </div>
    </div>
</div>
