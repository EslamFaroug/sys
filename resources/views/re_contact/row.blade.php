@php
    $lang = Session::get('lang');
    \App::setLocale($lang);
@endphp
@foreach($contacts as $contact)
    <div class="col-md-3">
        <!-- CONTACT ITEM -->
        <div class="panel panel-default">
            <div class="panel-body profile">
                <div class="profile-image">
                    <img src="/assets/images/users/avatar.jpg" alt="Nadia Ali"/>
                </div>
                <div class="profile-data">
                    <div class="profile-data-name">@if($contact->teacher_ar_name) {{$contact->teacher_ar_name}} @else {{$contact->teachers->ar_name}}  @endif</div>
                    <div class="profile-data-title">@if($contact->teacher_en_name) {{$contact->teacher_en_name}} @else {{$contact->teachers->en_name}}  @endif</div>
                </div>
                @if($lang == 'en')
                    <div class="profile-controls">
                        <a href="{{url('re_contacts/contact/'.$contact->contact_id)}}" class="profile-control-right"><span class="fa fa-info"></span></a>
                        <a href="{{url('re_contacts/contact/print/'.$contact->contact_id)}}" class="profile-control-left"><span class="fa fa-print"></span></a>

                    </div>
                @elseif($lang == 'ar')
                    <div class="profile-controls">
                        <a href="{{url('re_contacts/contact/'.$contact->contact_id)}}" class="profile-control-left"><span class="fa fa-info"></span></a>
                        <a href="{{url('re_contacts/contact/print/'.$contact->contact_id)}}" class="profile-control-right"><span class="fa fa-print"></span></a>
                    </div>
                @endif
            </div>
            <div class="panel-body">
                <div class="contact-info">
                    <p><small>{{trans('strings.tr_countery')}} :</small> @if($contact->countery)  {{$contact->countery}} @else @if($contact->countery_id) {{$contact->countreis->name}} @endif @endif</p>
                    <p><small>{{trans('strings.tr_university')}} :</small>@if($contact->university)  {{$contact->university}} @else @if($contact->university_id) {{$contact->universities->name}} @endif @endif</p>
                    <p><small>{{trans('strings.tr_email')}} :</small>{{$contact->email}}</p>
                    <p><small>{{trans('strings.tr_mobile')}} :</small>@if($contact->mobile_no) {{$contact->mobile_no}} @endif</p>
                    <p><small>{{trans('strings.tr_tel')}} :</small>@if($contact->tel_no) {{$contact->tel_no}} @endif</p>
                    <p><small>{{trans('strings.tr_home')}} :</small>@if($contact->home_no) {{$contact->home_no}} @endif</p>
                    <p><small>{{trans('strings.tr_website')}} :</small>@if($contact->tr_web) {{$contact->tr_web}} @endif</p>
                 </div>
            </div>

        </div>
        <!-- END CONTACT ITEM -->
    </div>
@endforeach
