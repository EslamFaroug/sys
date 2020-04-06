@php
    $lang = Session::get('lang');
    \App::setLocale($lang);
@endphp
@foreach($papers as $paper)
    <div class="col-md-3">
        <!-- CONTACT ITEM -->
        <div class="panel panel-default">
            <div class="panel-body profile">
                <div class="profile-data" style="margin-bottom: 10px">
                    <div class="profile-data-name" style="font-size: 12px">{{$paper->title}}</div>
                </div>
                <div class="profile-image">
                     <img src="/assets/images/paper.png" alt="Nadia Ali"/>
                </div>
                <div class="profile-data">
                    <div class="profile-data-name">{{$paper->ar_name}}</div>
                    <div class="profile-data-title">{{$paper->en_name}}</div>
                </div>
                @if($lang == 'en')
                    <div class="profile-controls">
                        <a href="{{url('re_papers/paper/'.$paper->paper_id)}}" class="profile-control-right"><span class="fa fa-info"></span></a>
                        <a href="{{url('re_papers/paper/print/'.$paper->paper_id)}}" class="profile-control-left"><span class="fa fa-print"></span></a>

                    </div>
                @elseif($lang == 'ar')
                    <div class="profile-controls">
                        <a href="{{url('re_papers/paper/'.$paper->paper_id)}}" class="profile-control-left"><span class="fa fa-info"></span></a>
                        <a href="{{url('re_papers/paper/print/'.$paper->paper_id)}}" class="profile-control-right"><span class="fa fa-print"></span></a>
                    </div>
                @endif
            </div>
            <div class="panel-body">
                <div class="contact-info" style="font-size: 10px">
                    <p><small>{{trans('strings.degree-select-label')}} :</small> {{$paper->degree}} </p>

                    <hr  style="margin-top: 0px; margin-bottom: 5px">

                    <p><small>{{trans('strings.publish_place')}} :</small> {{$paper->publish_place}}</p>
                    <p><small>{{trans('strings.publis_date')}} :</small> {{$paper->publis_date}}</p>
                </div>
            </div>

        </div>
        <!-- END CONTACT ITEM -->
    </div>
@endforeach
