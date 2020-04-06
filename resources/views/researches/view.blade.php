@php
    $lang = Session::get('lang');
    \App::setLocale($lang);
@endphp
<input type="hidden" id="research_id" name="research_id" value="{{$research->research_id}}">

    <div class="row">
        <label class="col-md-3 control-label">{{trans('strings.t_name')}}</label>
        <div class="col-md-9">
            @if($lang == 'ar')
                {{$research->teachers->ar_name}}
            @else
                {{$research->teachers->en_name}}
            @endif
        </div>
    </div>
    <div class="row">
        <label class="col-md-3 control-label">{{trans('strings.research-input-label')}}</label>
        <div class="col-md-9">
            {{$research->title}}
           </div>
    </div>

    <div class="row">
        <label class="col-md-3 control-label">{{trans('teacher.degree')}}</label>
        <div class="col-md-9">

            {{$research->degrees->name}}
        </div>
    </div>
@if($research->supervisor_id)
    <div class="row">
        <label class="control-label col-md-3" for="degree">{{trans('strings.supper')}}</label>
        <div class="col-md-9">
            @if($lang == 'ar')
                {{$research->supervisor->ar_name}}
            @else
                {{$research->supervisor->en_name}}
            @endif
        </div>
    </div>
    @endif
    <div class="row">
        <label class="col-md-3 control-label">{{trans('strings.publis_date')}}</label>
        <div class="col-md-9">
            {{$research->publish_date}}
        </div>
    </div>
    <div class="row">
        <label class="col-md-3 control-label">{{trans('strings.paper-input-place')}}</label>
        <div class="col-md-9">
            {{$research->publish_place}}
        </div>
    </div>


<div class="row">
    <label class="col-md-2 col-lg-2 col-sm-2 col-xs-2 control-label">{{trans('strings.paper_file')}}</label>
    <div class="col-lg-10 col-md-10 col-sm-10 col-xs-10">
        <a target="_blank" class="btn btn-link" href="{{asset($research->research_file)}}"><i class="fa fa-link"></i> {{$research->title}}</a>
    </div>
</div>


