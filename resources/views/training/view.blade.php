@php
    $lang = Session::get('lang');
    \App::setLocale($lang);
@endphp

<div class="form-group">
    <label class="col-md-2 control-label">{{trans('strings.t_name')}}</label>
    <div class="col-md-10">
        @if($lang == 'ar')
    {{$train->teachers->ar_name}}
            @else
            {{$train->teachers->en_name}}
        @endif
    </div>
</div>
<div class="form-group">
    <label class="col-md-2 control-label">{{trans('strings.title-input-label')}}</label>
    <div class="col-md-10">
        {{$train->title}}
    </div>
</div>
<div class="form-group">
    <label class="col-md-2 control-label">{{trans('strings.institute-input-label')}}</label>
        <div class="col-md-10">
            {{$train->institute}}
</div>
            </div>

            <div class="form-group">
                <label class="col-md-2 control-label">{{trans('strings.training place')}}</label>
    <div class="col-md-10">
        {{$train->countreis->name}}
    </div>
</div>
<div class="form-group">
    <label class="col-md-2 control-label">{{trans('strings.track of training')}}</label>
        <div class="col-md-10">
            {{$train->specials->name}}
        </div>
</div>
<div class="form-group">
    <label class="col-md-2 control-label">{{trans('strings.st_date')}}</label>
        <div class="col-md-10">
            {{$train->st_date}}
        </div>
</div>
<div class="form-group">
    <label class="col-md-2 control-label">{{trans('strings.end_date')}}</label>
        <div class="col-md-10">
            {{$train->end_date}}
        </div>
</div>
<div class="form-group">
    <label class="col-md-2 control-label">{{trans('strings.train_file')}}</label>
    <div class="col-md-10">
        <div class="img-responsive">
            <img class="img img-thumbnail" src="{{asset($train->path)}}" style="max-height: 400px; width: 100%">
        </div>
    </div>
</div>

<script type="text/javascript">
    var filezone = new Filezone();
</script>
