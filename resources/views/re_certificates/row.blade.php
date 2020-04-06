@php
    $lang = Session::get('lang');
    \App::setLocale($lang);
@endphp
@foreach($certificates as $certificate)
    <div class="col-md-3">
        <!-- certificate ITEM -->
        <div class="panel panel-default">
            <div class="panel-body profile">
                <div class="profile-data" style="margin-bottom: 10px">
                    <div class="profile-data-name" style="font-size: 12px">{{$certificate->cert_name}}</div>
                </div>
                <div class="profile-image">
                    <img src="/assets/images/users/avatar.jpg" alt="Nadia Ali"/>
                </div>
                <div class="profile-data">
                    <div class="profile-data-name">@if($certificate->teacher_ar_name) {{$certificate->teacher_ar_name}} @else {{$certificate->teachers->ar_name}}  @endif</div>
                    <div class="profile-data-title">@if($certificate->teacher_en_name) {{$certificate->teacher_en_name}} @else {{$certificate->teachers->en_name}}  @endif</div>
                </div>
                @if($lang == 'en')
                    <div class="profile-controls">
                        <a href="{{url('re_certificates/certificate/'.$certificate->cert_id)}}" class="profile-control-right"><span class="fa fa-info"></span></a>
                        <a href="{{url('re_certificates/certificate/print/'.$certificate->cert_id)}}" class="profile-control-left"><span class="fa fa-print"></span></a>

                    </div>
                @elseif($lang == 'ar')
                    <div class="profile-controls">
                        <a href="{{url('re_certificates/certificate/'.$certificate->cert_id)}}" class="profile-control-left"><span class="fa fa-info"></span></a>
                        <a href="{{url('re_certificates/certificate/print/'.$certificate->cert_id)}}" class="profile-control-right"><span class="fa fa-print"></span></a>
                    </div>
                @endif
            </div>
            <div class="panel-body">
                <div class="contact-info">
                    <p><small>{{trans('strings.tr_countery')}} :</small> @if($certificate->countery)  {{$certificate->countery}} @else @if($certificate->countery_id) {{$certificate->countreis->name}} @endif @endif</p>
                    <p><small>{{trans('strings.tr_university')}} :</small>@if($certificate->university)  {{$certificate->university}} @else @if($certificate->special_id) {{$certificate->specials->departments->colleges->universities->name}} @endif @endif</p>
                    <p><small>{{trans('strings.tr_college')}} :</small>@if($certificate->college)  {{$certificate->college}} @else @if($certificate->special_id) {{$certificate->specials->departments->colleges->name}} @endif @endif</p>
                    <p><small>{{trans('strings.tr_specialization')}} :</small>@if($certificate->special)  {{$certificate->special}} @else @if($certificate->special_id) {{$certificate->specials->name}} @endif @endif</p>
                    <p><small>{{trans('strings.study_type')}} :</small>@if($certificate->study)  {{$certificate->study}} @else @if($certificate->study_id) {{$certificate->studes->name}} @endif @endif</p>
                    <p><small>{{trans('strings.sert_grad')}} :</small>{{$certificate->sert_grade}}</p>
                    <p><small>{{trans('strings.sert_date')}} :</small>{{$certificate->cert_date}}</p>

                </div>
            </div>

        </div>
        <!-- END CONTACT ITEM -->
    </div>
@endforeach
