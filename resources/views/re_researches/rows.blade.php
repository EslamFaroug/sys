@php
    $lang = Session::get('lang');
    \App::setLocale($lang);
@endphp
@foreach($researches as $researche)
    <div class="col-md-3">
        <!-- CONTACT ITEM -->
        <div class="panel panel-default">
            <div class="panel-body profile">
                <div class="profile-data" style="margin-bottom: 10px">
                    <div class="profile-data-name" style="font-size: 12px">{{$researche->title}}</div>
                </div>
                <div class="profile-image">
                    <img src="/assets/images/paper.png" alt="Nadia Ali"/>
                </div>
                <div class="profile-data">
                    <div class="profile-data-name">{{$researche->ar_name}}</div>
                    <div class="profile-data-title">{{$researche->en_name}}</div>
                </div>
                @if($lang == 'en')
                    <div class="profile-controls">
                        <a href="{{url('re_researches/researche/'.$researche->research_id)}}" class="profile-control-right"><span class="fa fa-info"></span></a>
                        <a href="{{url('re_researches/researche/print/'.$researche->research_id)}}" class="profile-control-left"><span class="fa fa-print"></span></a>

                    </div>
                @elseif($lang == 'ar')
                    <div class="profile-controls">
                        <a href="{{url('re_researches/researche/'.$researche->research_id)}}" class="profile-control-left"><span class="fa fa-info"></span></a>
                        <a href="{{url('re_researches/researche/print/'.$researche->research_id)}}" class="profile-control-right"><span class="fa fa-print"></span></a>
                    </div>
                @endif
            </div>
            <div class="panel-body">
                <div class="contact-info" style="font-size: 10px">
                    <p><small>{{trans('strings.degree-select-label')}} :</small> {{$researche->degree}} </p>

                    <hr  style="margin-top: 0px; margin-bottom: 5px">

                    <p><small>{{trans('strings.supper')}} :</small>  @if($researche->supervisor_id)  {{\App\Teacher::find($researche->supervisor_id)->ar_name}} @endif</p>
                    <p><small>{{trans('strings.publish_place')}} :</small> {{$researche->publish_place}}</p>
                    <p><small>{{trans('strings.publis_date')}} :</small> {{$researche->publish_date}}</p>
                </div>
            </div>

        </div>
        <!-- END CONTACT ITEM -->
    </div>
@endforeach