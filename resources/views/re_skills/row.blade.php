@php
    $lang = Session::get('lang');
    \App::setLocale($lang);
@endphp
@foreach($skills as $skill)
    <div class="col-md-3">
        <!-- skill ITEM -->
        <div class="panel panel-default">
            <div class="panel-body profile">
                <div class="profile-data" style="margin-bottom: 10px">
                    <div class="profile-data-name" style="font-size: 12px">
                       {{$skill->name}}
                    </div>
                </div>
                <div class="profile-image">
                    <img src="/assets/images/users/avatar.jpg" alt="Nadia Ali"/>
                </div>
                <div class="profile-data">
                    <div class="profile-data-name">@if($skill->teacher_ar_name) {{$skill->teacher_ar_name}} @else {{$skill->teachers->ar_name}}  @endif</div>
                    <div class="profile-data-title">@if($skill->teacher_en_name) {{$skill->teacher_en_name}} @else {{$skill->teachers->en_name}}  @endif</div>
                </div>
                @if($lang == 'en')
                    <div class="profile-controls">
                        <a href="{{url('re_skills/skill/'.$skill->skill_id)}}" class="profile-control-right"><span class="fa fa-info"></span></a>
                        <a href="{{url('re_skills/skill/print/'.$skill->skill_id)}}" class="profile-control-left"><span class="fa fa-print"></span></a>

                    </div>
                @elseif($lang == 'ar')
                    <div class="profile-controls">
                        <a href="{{url('re_skills/skill/'.$skill->skill_id)}}" class="profile-control-left"><span class="fa fa-info"></span></a>
                        <a href="{{url('re_skills/skill/print/'.$skill->skill_id)}}" class="profile-control-right"><span class="fa fa-print"></span></a>
                    </div>
                @endif
            </div>
            <div class="panel-body">
                <div class="contact-info" style="font-size: 10px;">
                    <p><small>{{trans('strings.tr_countery')}} :</small> {{$skill->countery}}</p>
                    <p><small>{{trans('strings.tr_university')}} :</small> {{$skill->university}}</p>
                    <p><small>{{trans('strings.tr_college')}} :</small> {{$skill->college}}</p>
                    <p><small>{{trans('strings.skill_desc')}} / {{trans("strings.skill-input-label")}} :</small> {{$skill->decription}}</p>
                </div>
            </div>

        </div>
        <!-- END CONTACT ITEM -->
    </div>
@endforeach
