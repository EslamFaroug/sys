@php
    $lang = Session::get('lang');
    \App::setLocale($lang);
@endphp
@foreach($interests as $interest)
    <div class="col-md-3">
        <!-- interest ITEM -->
        <div class="panel panel-default">
            <div class="panel-body profile">
                <div class="profile-data" style="margin-bottom: 10px">
                    <div class="profile-data-name" style="font-size: 12px">{{$interest->title}}</div>
                </div>
                <div class="profile-image">
                    <img src="/assets/images/users/avatar.jpg" alt="Nadia Ali"/>
                </div>
                <div class="profile-data">
                    <div class="profile-data-name">@if($interest->teacher_ar_name) {{$interest->teacher_ar_name}} @else {{$interest->teachers->ar_name}}  @endif</div>
                    <div class="profile-data-title">@if($interest->teacher_en_name) {{$interest->teacher_en_name}} @else {{$interest->teachers->en_name}}  @endif</div>
                </div>
                @if($lang == 'en')
                    <div class="profile-controls">
                        <a href="{{url('re_interests/interest/'.$interest->interest_id)}}" class="profile-control-right"><span class="fa fa-info"></span></a>
                        <a href="{{url('re_interests/interest/print/'.$interest->interest_id)}}" class="profile-control-left"><span class="fa fa-print"></span></a>

                    </div>
                @elseif($lang == 'ar')
                    <div class="profile-controls">
                        <a href="{{url('re_interests/interest/'.$interest->interest_id)}}" class="profile-control-left"><span class="fa fa-info"></span></a>
                        <a href="{{url('re_interests/interest/print/'.$interest->interest_id)}}" class="profile-control-right"><span class="fa fa-print"></span></a>
                    </div>
                @endif
            </div>
            <div class="panel-body">
                <div class="contact-info">
                    <p><small>{{trans('strings.tr_countery')}} :</small> @if($interest->countery)  {{$interest->countery}} @else @if($interest->countery_id) {{$interest->countreis->name}} @endif @endif</p>
                    <p><small>{{trans('strings.tr_university')}} :</small>@if($interest->university)  {{$interest->university}} @else @if($interest->special_id) {{$interest->specials->departments->colleges->universities->name}} @endif @endif</p>
                    <p><small>{{trans('strings.tr_specialization')}} :</small>@if($interest->special)  {{$interest->special}} @else @if($interest->special_id) {{$interest->specials->name}} @endif @endif</p>
                    <hr  style="margin-top: 0px; margin-bottom: 5px">
                    <p><small>{{trans('strings.interest-input-label')}} / {{trans('strings.descrip-input-int')}} :</small>{{$interest->descrip}}</p>

                </div>
            </div>

        </div>
        <!-- END CONTACT ITEM -->
    </div>
@endforeach
