@php
    $lang = Session::get('lang');
    \App::setLocale($lang);
@endphp
@foreach($teachers as $teacher)
    <div class="col-md-3">
        <!-- CONTACT ITEM -->
        <div class="panel panel-default">
            <div class="panel-body profile">
                <div class="profile-image">
                    <img src="/assets/images/users/avatar.jpg" alt="Nadia Ali"/>
                </div>
                <div class="profile-data">
                    <div class="profile-data-name">{{$teacher->ar_name}}</div>
                    <div class="profile-data-title">{{$teacher->en_name}}</div>
                </div>
                @if($lang == 'en')
                    <div class="profile-controls">
                        <a href="{{url('re_teachers/tr_data/'.$teacher->teacher_id)}}" class="profile-control-right"><span class="fa fa-info"></span></a>
                        <a href="{{url('re_teachers/print/teacher/'.$teacher->teacher_id)}}" class="profile-control-left"><span class="fa fa-print"></span></a>

                    </div>
                @elseif($lang == 'ar')
                    <div class="profile-controls">
                        <a href="{{url('re_teachers/tr_data/'.$teacher->teacher_id)}}" class="profile-control-left"><span class="fa fa-info"></span></a>
                        <a href="{{url('re_teachers/print/teacher/'.$teacher->teacher_id)}}" class="profile-control-right"><span class="fa fa-print"></span></a>
                    </div>
                @endif
            </div>
            <div class="panel-body">
                <div class="contact-info">
                    <p><small>{{trans('teacher.national_id')}} :</small> @if($teacher->countery) {{$teacher->countery}} @else {{$teacher->countreis->name}} @endif</p>
                    <p><small>{{trans('teacher.tr_degree')}} :</small> @if($teacher->degree) {{$teacher->degree}} @else {{$teacher->degrees->name}} @endif</p>
                    <p><small>{{trans('teacher.gender')}} :</small> {{$genders[$teacher->gender]}}</p>
                    <p><small>{{trans('teacher.status')}} :</small> {{$status[$teacher->status]}}</p>
                    <p><small>{{trans('teacher.dob')}} :</small> {{$teacher->dob}}</p>
                </div>
            </div>

        </div>
        <!-- END CONTACT ITEM -->
    </div>
@endforeach
