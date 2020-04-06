@php
    $lang = Session::get('lang');
    \App::setLocale($lang);
@endphp
<div class="row">
    <div class="panel panel-success push-up-20">
        <div class="panel-body panel-body-pricing">
            <h2>{{$genaral_Statistic->title}} <small><i id="viewShow{{$genaral_Statistic->id}}" style="color: #00aa88" class=" fa @if($genaral_Statistic->show=="yes") fa-eye @else fa-eye-slash @endif"></i></small></h2>

            <div class="widget widget-default widget-carousel">
                    <div class="col-md-4 col-sm-4 col-xs-6">
                        <div class="widget-title">{{trans("strings.Total")}}</div>
                        <div class="widget-subtitle">
                            @if($genaral_Statistic->Type=="teachers")
                                {{trans("strings.Teachers")}}
                            @else
                                {{trans("strings.Universities")}}
                            @endif
                        </div>
                        <div class="widget-int"  style="font-size: 18px;">{{$pratical->original['total']}}</div>
                    </div>
                <div class="col-md-4 col-sm-4 col-xs-6">
                    <div class="widget-title">{{trans("strings.Actual")}}</div>
                    <div class="widget-subtitle">
                        @if($genaral_Statistic->Type=="teachers")
                            {{trans("strings.Teachers")}}
                        @else
                            {{trans("strings.Universities")}}
                        @endif
                    </div>
                    <div class="widget-int"  style="font-size: 18px;">{{$pratical->original['actual']}}</div>
                    </div>
                <div class="col-md-4 col-sm-4 col-xs-6">
                    <div class="widget-title">{{trans("strings.Percent")}}</div>
                        <div class="widget-subtitle">
                            @if($genaral_Statistic->Type=="teachers")
                                {{trans("strings.Teachers")}}
                            @else
                                {{trans("strings.Universities")}}
                            @endif
                        </div>
                    <div class="widget-int" style="font-size: 18px;">{{$pratical->original['percent']}} %</div>
                    </div>
            </div>

            <p>
                <span class="fa @if($lang == 'ar') fa-caret-left @elseif($lang =='en') fa-caret-right @endif"></span>
                @if($genaral_Statistic->Type=="teachers")
                    {{trans("strings.Teachers")}}
                @else
                    {{trans("strings.Universities")}}
                @endif
            </p>
            <p>
                <span class="fa @if($lang == 'ar') fa-caret-left @elseif($lang =='en') fa-caret-right @endif"></span>

                @if($genaral_Statistic->countery_id) {{$genaral_Statistic->countery->name}} @else  {{trans("strings.All_Countries")}} @endif
            </p>
            <p>
                <span class="fa @if($lang == 'ar') fa-caret-left @elseif($lang =='en') fa-caret-right @endif"></span>

                @if($genaral_Statistic->type_id) {{$genaral_Statistic->type->name}}  @else  {{trans("strings.All_Universities_type")}} @endif
            </p>

            @if($genaral_Statistic->type_id and $genaral_Statistic->Type=="teachers")
            <p>
                <span class="fa @if($lang == 'ar') fa-caret-left @elseif($lang =='en') fa-caret-right @endif"></span>

                @if($genaral_Statistic->university_id) {{$genaral_Statistic->university->name}}   @else  {{trans("strings.All_Universities")}} @endif
            </p>
            @endif

                @if($genaral_Statistic->university_id and $genaral_Statistic->Type=="teachers")
            <p>
                <span class="fa @if($lang == 'ar') fa-caret-left @elseif($lang =='en') fa-caret-right @endif"></span>

                @if($genaral_Statistic->college_id) {{$genaral_Statistic->college->name}}   @else  {{trans("strings.All_Colleges")}} @endif
            </p>
            @endif


        @if($genaral_Statistic->college_id)
            <p>
                <span class="fa @if($lang == 'ar') fa-caret-left @elseif($lang =='en') fa-caret-right @endif"></span>

                @if($genaral_Statistic->depart_id) {{$genaral_Statistic->department->name}}   @else  {{trans("strings.All_Departments")}} @endif
            </p>
            @endif

        @if($genaral_Statistic->depart_id)
            <p>

                <span class="fa @if($lang == 'ar') fa-caret-left @elseif($lang =='en') fa-caret-right @endif"></span>

                @if($genaral_Statistic->special_id) {{$genaral_Statistic->special->name}}   @else  {{trans("strings.All_Special")}} @endif
            </p>
            @endif

            @if($genaral_Statistic->Type=="teachers")
            <p>
                <span class="fa @if($lang == 'ar') fa-caret-left @elseif($lang =='en') fa-caret-right @endif"></span>

                @if($genaral_Statistic->degree_id) {{$genaral_Statistic->degree->name}}  @else  {{trans("strings.All_Degrees")}} @endif
            </p>
                @endif
        </div>
        <div class="panel-footer">
            <button class="btn btn-success btn-block" onclick="visOP(this.id,showST{{$genaral_Statistic->id}}.value)" id="{{$genaral_Statistic->id}}" ><i id="visOPAreaV{{$genaral_Statistic->id}}" class="fa @if($genaral_Statistic->show=="yes") fa-eye @else fa-eye-slash @endif"></i> {{trans('strings.visibility')}} </button>
        </div>
    </div>


</div>
<script>
    $(document).ready(function(){
        $('.owl-carousel').owlCarousel({})
    });
</script>
