@php
    $lang = Session::get('lang');
    \App::setLocale($lang);
@endphp
@foreach($experiences as $experience)
    <div class="col-md-3">
        <!-- experience ITEM -->
        <div class="panel panel-default">
            <div class="panel-body profile">
                <div class="profile-data" style="margin-bottom: 10px">
                    <div class="profile-data-name" style="font-size: 12px">
                        @if($experience->degree_id)
                            @if($experience->degree)  {{$experience->degree}} @else @if($experience->degree_id) {{$experience->degrees->name}} @endif @endif
                        @elseif($experience->mangejob_id)
                            @if($experience->mangejob)  {{$experience->mangejob}} @else @if($experience->mangejob_id) {{$experience->mangejobs->name}} @endif @endif
                         @elseif($experience->exp_name)
                            {{$experience->exp_name}}
                        @endif
                    </div>
                </div>
                <div class="profile-image">
                    <img src="/assets/images/users/avatar.jpg" alt="Nadia Ali"/>
                </div>
                <div class="profile-data">
                    <div class="profile-data-name">@if($experience->teacher_ar_name) {{$experience->teacher_ar_name}} @else {{$experience->teachers->ar_name}}  @endif</div>
                    <div class="profile-data-title">@if($experience->teacher_en_name) {{$experience->teacher_en_name}} @else {{$experience->teachers->en_name}}  @endif</div>
                </div>
                @if($lang == 'en')
                    <div class="profile-controls">
                        <a href="{{url('re_experiences/experience/'.$experience->exp_id)}}" class="profile-control-right"><span class="fa fa-info"></span></a>
                        <a href="{{url('re_experiences/experience/print/'.$experience->exp_id)}}" class="profile-control-left"><span class="fa fa-print"></span></a>

                    </div>
                @elseif($lang == 'ar')
                    <div class="profile-controls">
                        <a href="{{url('re_experiences/experience/'.$experience->exp_id)}}" class="profile-control-left"><span class="fa fa-info"></span></a>
                        <a href="{{url('re_experiences/experience/print/'.$experience->exp_id)}}" class="profile-control-right"><span class="fa fa-print"></span></a>
                    </div>
                @endif
            </div>
            <div class="panel-body">
                <div class="contact-info" style="font-size: 10px;">
                    <p>
                        <small>{{trans('strings.tr_exp_institute')}} :</small>
                        @if($experience->degree_id)
                            @if($experience->university)  {{$experience->university}} @else @if($experience->special_id) {{$experience->specials->departments->colleges->universities->name}} @endif @endif
                        @elseif($experience->mangejob_id)
                            @if($experience->university)  {{$experience->university}} @else @if($experience->special_id) {{$experience->specials->departments->colleges->universities->name}} @endif @endif
                        @elseif($experience->exp_name)
                            {{$experience->institute}}
                        @endif
                    </p>
                    <p><small>{{trans('strings.tr_countery')}} :</small>@if($experience->countery)  {{$experience->countery}} @else @if($experience->countery_id) {{$experience->countreis->name}} @endif @endif</p>
                    <p><small>{{trans('strings.work_type')}} :</small>@if($experience->work)  {{$experience->work}} @else @if($experience->work_id) {{$experience->work_types->name}} @endif @endif</p>
                    <p><small>{{trans('strings.st_date')}} :</small> {{$experience->start_date}}</p>
                    <p><small>{{trans('strings.end_date')}} :</small> {{$experience->end_date}}</p>

                </div>
            </div>

        </div>
        <!-- END CONTACT ITEM -->
    </div>
@endforeach
