@php
    $lang = Session::get('lang');
    \App::setLocale($lang);
@endphp
@foreach($trainings as $training)
    <div class="col-md-3">
        <!-- training ITEM -->
        <div class="panel panel-default">
            <div class="panel-body profile">
                <div class="profile-data" style="margin-bottom: 10px">
                    <div class="profile-data-name" style="font-size: 12px">
                       {{$training->title}}
                    </div>
                </div>
                <div class="profile-image">
                    <img src="/assets/images/users/avatar.jpg" alt="Nadia Ali"/>
                </div>
                <div class="profile-data">
                    <div class="profile-data-name">@if($training->teacher_ar_name) {{$training->teacher_ar_name}} @else {{$training->teachers->ar_name}}  @endif</div>
                    <div class="profile-data-title">@if($training->teacher_en_name) {{$training->teacher_en_name}} @else {{$training->teachers->en_name}}  @endif</div>
                </div>
                @if($lang == 'en')
                    <div class="profile-controls">
                        <a href="{{url('re_training/training/'.$training->train_id)}}" class="profile-control-right"><span class="fa fa-info"></span></a>
                        <a href="{{url('re_training/training/print/'.$training->train_id)}}" class="profile-control-left"><span class="fa fa-print"></span></a>

                    </div>
                @elseif($lang == 'ar')
                    <div class="profile-controls">
                        <a href="{{url('re_training/training/'.$training->train_id)}}" class="profile-control-left"><span class="fa fa-info"></span></a>
                        <a href="{{url('re_training/training/print/'.$training->train_id)}}" class="profile-control-right"><span class="fa fa-print"></span></a>
                    </div>
                @endif
            </div>
            <div class="panel-body">
                <div class="contact-info">
                    <p><small>{{trans('strings.training place')}} :</small>@if($training->countery)  {{$training->countery}} @else @if($training->countery_id) {{$training->countreis->name}} @endif @endif</p>
                    <p><small>{{trans('strings.institute-input-label')}} :</small>{{$training->institute}}</p>
                    <p><small>{{trans('strings.track of training')}} :</small>@if($training->special)  {{$training->special}} @else @if($training->special_id) {{$training->specials->name}} @endif @endif</p>
                    <p><small>{{trans('strings.st_date')}} :</small> {{$training->st_date}}</p>
                    <p><small>{{trans('strings.end_date')}} :</small> {{$training->end_date}}</p>

                </div>
            </div>

        </div>
        <!-- END CONTACT ITEM -->
    </div>
@endforeach
