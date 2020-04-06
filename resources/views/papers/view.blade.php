@php
    $lang = Session::get('lang');
    \App::setLocale($lang);
@endphp

<input type="hidden" id="paper_id" name="paper_id" value="{{$paper->paper_id}}">

<div class="form-group">
    <label class="col-md-2 control-label">{{trans('strings.t_name')}}</label>
        <div class="col-md-10">
            @if($lang == 'ar')
                {{$paper->teachers->ar_name}}
            @else
                {{$paper->teachers->en_name}}
            @endif
        </div>
</div>
<div class="form-group">
    <label class="col-md-2 control-label">{{trans('strings.paper-input-label')}}</label>
    <div class="col-md-10">
        {{$paper->title}}
    </div>
</div>

<div class="form-group">
    <label class="col-md-2 control-label">{{trans('strings.paper-input-place')}}</label>
    <div class="col-md-10">
        {{$paper->publish_place}}
    </div>
</div>

<div class="form-group">
    <label class="col-md-2 control-label">{{trans('strings.publis_date')}}</label>
        <div class="col-md-10">
            {{$paper->publis_date}}
        </div>
</div>

<div class="form-group">
    <label class="col-md-2 control-label">{{trans('strings.volume_no-input-place')}}</label>
    <div class="col-md-10">
        {{$paper->volume_no}}
    </div>
</div>


<div class="form-group row">
    <label class="col-md-2 col-lg-2 col-sm-2 col-xs-2 control-label">{{trans('strings.paper_file')}}</label>
    <div class="col-lg-10 col-md-10 col-sm-10 col-xs-10">
        <a target="_blank" class="btn btn-link" href="{{asset($paper->peper_file)}}"><i class="fa fa-link"></i> {{$paper->title}}</a>
    </div>
</div>

