@php
    $lang = Session::get('lang');
    \App::setLocale($lang);
@endphp

@extends('layouts.admin')

@section('title') {{trans('strings.Home page')}}
@endsection


@section('extra-plugins')

    <!-- START THIS PAGE PLUGINS-->

    <!-- END THIS PAGE PLUGINS-->

    <!-- START TEMPLATE -->
    <script type="text/javascript" src="{{asset('js/plugins/knob/jquery.knob.min.js')}}"></script>

    <script type="text/javascript" src="{{asset('js/demo_dashboard.js')}}"></script>
 @endsection

@section('javascript')

@endsection

@section('contents')

    <!-- PAGE CONTENT WRAPPER -->
    <div class="page-content-wrap">
        <div class="row">
            <div class="col-lg-2 col-md-2 col-sm-3 col-xs-6">
            <div class="widget widget-info "  style=" min-height: 100px;">
                <div class="widget-big-int plugin-clock">00:00</div>
                <div class="widget-subtitle plugin-date">Loading...</div>
            </div>
            </div>

            <div class="col-lg-2 col-md-2 col-sm-3 col-xs-6">
                <a href="#" class="tile tile-info tile-valign">
                    {{\App\University::all()->count()}}
                    <div class="informer informer-default" style="@if($lang == 'ar') left:auto; @endif">{{trans('strings.universities')}}</div>
                    <div class="informer informer-default dir-br" style="@if($lang == 'ar') left:5px; right: auto; @endif"><span class="fa fa-home"></span></div>
                </a>
            </div>
            <div class="col-lg-2 col-md-2 col-sm-3 col-xs-6">
                <a href="#" class="tile tile-info tile-valign">
                    {{\App\Teacher::all()->count()}}
                    <div class="informer informer-default" style="@if($lang == 'ar') left:auto; @endif">{{trans('strings.teachers')}}</div>
                    <div class="informer informer-default dir-br" style="@if($lang == 'ar') left:5px; right: auto; @endif"><span class="fa fa-users"></span></div>
                </a>
            </div>

            <div class="col-lg-2 col-md-2 col-sm-3 col-xs-6">
                <a href="#" class="tile tile-info tile-valign">
                    {{\App\Book::all()->count()}}
                    <div class="informer informer-default" style="@if($lang == 'ar') left:auto; @endif">{{trans('strings.Books')}}</div>
                    <div class="informer informer-default dir-br" style="@if($lang == 'ar') left:5px; right: auto; @endif"><span class="fa fa-book"></span></div>
                </a>
            </div>
            <div class="col-lg-2 col-md-2 col-sm-3 col-xs-6">
                <a href="#" class="tile tile-info tile-valign">
                    {{\App\Research::all()->count()}}
                    <div class="informer informer-default" style="@if($lang == 'ar') left:auto; @endif">{{trans('strings.research_title')}}</div>
                    <div class="informer informer-default dir-br" style="@if($lang == 'ar') left:5px; right: auto; @endif"><span class="fa fa-search"></span></div>
                </a>
            </div>
            <div class="col-lg-2 col-md-2 col-sm-3 col-xs-6">
                <a href="#" class="tile tile-info tile-valign">
                    {{\App\Paper::all()->count()}}
                    <div class="informer informer-default" style="@if($lang == 'ar') left:auto; @endif">{{trans('strings.paper_title')}}</div>
                    <div class="informer informer-default dir-br" style="@if($lang == 'ar') left:5px; right: auto; @endif"><span class="fa fa-paragraph"></span></div>
                </a>
            </div>
        </div>
        <!-- START WIDGETS -->
        <div class="row">
            @foreach($genaral_Statistics as $genaral_Statistic)
                @if($genaral_Statistic->original['genaral_Statistic']['show']=="yes")
                    <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">

                        <!-- START USERS ACTIVITY BLOCK -->
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <span style="font-size: 12px"  class=" pull-left">{{$genaral_Statistic->original['genaral_Statistic']['title']}}</span>
                            </div>
                            <div class="panel-body padding-0">
                                <!-- START WIDGET SLIDER -->
                                <div class="widget widget-default widget-carousel" style="margin: 0px" dir="ltr">
                                    <div class="owl-carousel" id="owl-example">
                                        <div class="widget widget-default widget-item-icon" style="margin: 0px; direction: rtl">
                                            <div class="widget-item-left">
                                                @if($genaral_Statistic->original['genaral_Statistic']['Type']=="teachers")
                                                    <span class="fa fa-users"></span>
                                                @else
                                                    <span class="fa fa-home"></span>
                                                @endif
                                            </div>
                                            <div class="widget-data" dir="rtl">
                                                <div class="widget-int num-count" style="text-align: center">{{$genaral_Statistic->original['total']}}</div>
                                                <div class="widget-title"  style="text-align: center">
                                                    @if($genaral_Statistic->original['genaral_Statistic']['Type']=="teachers")
                                                        {{trans("strings.Teachers")}}
                                                    @else
                                                        {{trans("strings.Universities")}}
                                                    @endif
                                                </div>
                                                <div class="widget-subtitle" style="text-align: center"> {{trans("strings.Total")}}</div>
                                            </div>
                                        </div>
                                        <div class="widget widget-default widget-item-icon" style="margin: 0px; direction: rtl">
                                            <div class="widget-item-left">
                                                @if($genaral_Statistic->original['genaral_Statistic']['Type']=="teachers")
                                                    <span class="fa fa-users"></span>
                                                @else
                                                    <span class="fa fa-home"></span>
                                                @endif
                                            </div>
                                            <div class="widget-data" dir="rtl">
                                                <div class="widget-int num-count" style="text-align: center">{{$genaral_Statistic->original['actual']}}</div>
                                                <div class="widget-title"  style="text-align: center">
                                                    @if($genaral_Statistic->original['genaral_Statistic']['Type']=="teachers")
                                                        {{trans("strings.Teachers")}}
                                                    @else
                                                        {{trans("strings.Universities")}}
                                                    @endif
                                                </div>
                                                <div class="widget-subtitle" style="text-align: center"> {{trans("strings.Actual")}}</div>
                                            </div>
                                        </div>
                                        <div class="widget widget-default widget-padding-sm" style="margin: 0px" dir="ltr">
                                            <div class="widget-item-left">
                                                <input class="knob" data-width="100" data-height="100" data-min="0" data-max="100" data-displayInput=false style="color: #FFF2C5;" data-bgColor="#1CAF9A" data-fgColor="#FEA223" value="{{$genaral_Statistic->original['percent']}}%" data-readOnly="true" data-thickness=".2"/>
                                            </div>
                                            <div class="widget-data">
                                                <div class="widget-big-int"><span class="num-count">{{$genaral_Statistic->original['percent']}}</span>%</div>
                                                <div class="widget-title">
                                                    @if($genaral_Statistic->original['genaral_Statistic']['Type']=="teachers")
                                                        {{trans("strings.Teachers")}}
                                                    @else
                                                        {{trans("strings.Universities")}}
                                                    @endif
                                                </div>
                                                <div class="widget-subtitle">{{trans("strings.Percent")}}</div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <!-- END WIDGET SLIDER -->
                            </div>
                        </div>
                        <!-- END USERS ACTIVITY BLOCK -->

                    </div>
                @endif
            @endforeach


        </div>
        <!-- END WIDGETS -->

        <div class="row">
            <div class="col-md-4">

                <!-- START USERS ACTIVITY BLOCK -->
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <span style="font-size: 14px" class=" pull-left">{{trans('strings.Time')}}</span>
                        <ul class="panel-controls pull-right">
                            <li><a href="#" class="panel-collapse"><span class="fa fa-angle-down"></span></a></li>
                            <li><a href="#" class="panel-refresh"><span class="fa fa-refresh"></span></a></li>
                            <li><a href="#" class="panel-remove"><span class="fa fa-times"></span></a></li>
                        </ul>
                    </div>
                    <div class="panel-body padding-0">
                        <!-- START WIDGET SLIDER -->
                        <div class="widget widget-info widget-padding-sm"  style="margin: 0px">
                            <div class="widget-big-int plugin-clock">00:00</div>
                            <div class="widget-subtitle plugin-date">Loading...</div>
                            <div class="widget-controls">
                                <a href="#" class="widget-control-right widget-remove" data-toggle="tooltip" data-placement="left" title="Remove Widget"><span class="fa fa-times"></span></a>
                            </div>
                            <div class="widget-buttons widget-c3">
                                <div class="col">
                                    <a href="#"><span class="fa fa-clock-o"></span></a>
                                </div>
                                <div class="col">
                                    <a href="#"><span class="fa fa-bell"></span></a>
                                </div>
                                <div class="col">
                                    <a href="#"><span class="fa fa-calendar"></span></a>
                                </div>
                            </div>
                        </div>
                        <!-- END WIDGET SLIDER -->
                    </div>
                </div>
                <!-- END USERS ACTIVITY BLOCK -->

            </div>

            <div class="col-md-4">

                <!-- START USERS ACTIVITY BLOCK -->
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="panel-title-box">
                            <h3>Users Activity</h3>
                            <span>Users vs returning</span>
                        </div>
                        <ul class="panel-controls" style="margin-top: 2px;">
                            <li><a href="#" class="panel-fullscreen"><span class="fa fa-expand"></span></a></li>
                            <li><a href="#" class="panel-refresh"><span class="fa fa-refresh"></span></a></li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="fa fa-cog"></span></a>
                                <ul class="dropdown-menu">
                                    <li><a href="#" class="panel-collapse"><span class="fa fa-angle-down"></span> Collapse</a></li>
                                    <li><a href="#" class="panel-remove"><span class="fa fa-times"></span> Remove</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                    <div class="panel-body padding-0">
                        <div class="chart-holder" id="dashboard-bar-1" style="height: 200px;"></div>
                    </div>
                </div>
                <!-- END USERS ACTIVITY BLOCK -->

            </div>
            <div class="col-md-4">

                <!-- START VISITORS BLOCK -->
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="panel-title-box">
                            <h3>Visitors</h3>
                            <span>Visitors (last month)</span>
                        </div>
                        <ul class="panel-controls" style="margin-top: 2px;">
                            <li><a href="#" class="panel-fullscreen"><span class="fa fa-expand"></span></a></li>
                            <li><a href="#" class="panel-refresh"><span class="fa fa-refresh"></span></a></li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="fa fa-cog"></span></a>
                                <ul class="dropdown-menu">
                                    <li><a href="#" class="panel-collapse"><span class="fa fa-angle-down"></span> Collapse</a></li>
                                    <li><a href="#" class="panel-remove"><span class="fa fa-times"></span> Remove</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                    <div class="panel-body padding-0">
                        <div class="chart-holder" id="dashboard-donut-1" style="height: 200px;"></div>
                    </div>
                </div>
                <!-- END VISITORS BLOCK -->

            </div>

            <div class="col-md-4">

                <!-- START PROJECTS BLOCK -->
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="panel-title-box">
                            <h3>Projects</h3>
                            <span>Projects activity</span>
                        </div>
                        <ul class="panel-controls" style="margin-top: 2px;">
                            <li><a href="#" class="panel-fullscreen"><span class="fa fa-expand"></span></a></li>
                            <li><a href="#" class="panel-refresh"><span class="fa fa-refresh"></span></a></li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="fa fa-cog"></span></a>
                                <ul class="dropdown-menu">
                                    <li><a href="#" class="panel-collapse"><span class="fa fa-angle-down"></span> Collapse</a></li>
                                    <li><a href="#" class="panel-remove"><span class="fa fa-times"></span> Remove</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                    <div class="panel-body panel-body-table">

                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th width="50%">Project</th>
                                    <th width="20%">Status</th>
                                    <th width="30%">Activity</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td><strong>Joli Admin</strong></td>
                                    <td><span class="label label-danger">Developing</span></td>
                                    <td>
                                        <div class="progress progress-small progress-striped active">
                                            <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: 85%;">85%</div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Gemini</strong></td>
                                    <td><span class="label label-warning">Updating</span></td>
                                    <td>
                                        <div class="progress progress-small progress-striped active">
                                            <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: 40%;">40%</div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Taurus</strong></td>
                                    <td><span class="label label-warning">Updating</span></td>
                                    <td>
                                        <div class="progress progress-small progress-striped active">
                                            <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: 72%;">72%</div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Leo</strong></td>
                                    <td><span class="label label-success">Support</span></td>
                                    <td>
                                        <div class="progress progress-small progress-striped active">
                                            <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: 100%;">100%</div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Virgo</strong></td>
                                    <td><span class="label label-success">Support</span></td>
                                    <td>
                                        <div class="progress progress-small progress-striped active">
                                            <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: 100%;">100%</div>
                                        </div>
                                    </td>
                                </tr>

                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
                <!-- END PROJECTS BLOCK -->

            </div>
        </div>

        <div class="row">
            <div class="col-md-8">

                <!-- START SALES BLOCK -->
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="panel-title-box">
                            <h3>Sales</h3>
                            <span>Sales activity by period you selected</span>
                        </div>
                        <ul class="panel-controls panel-controls-title">
                            <li>
                                <div id="reportrange" class="dtrange">
                                    <span></span><b class="caret"></b>
                                </div>
                            </li>
                            <li><a href="#" class="panel-fullscreen rounded"><span class="fa fa-expand"></span></a></li>
                        </ul>

                    </div>
                    <div class="panel-body">
                        <div class="row stacked">
                            <div class="col-md-4">
                                <div class="progress-list">
                                    <div class="pull-left"><strong>In Queue</strong></div>
                                    <div class="pull-right">75%</div>
                                    <div class="progress progress-small progress-striped active">
                                        <div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: 75%;">75%</div>
                                    </div>
                                </div>
                                <div class="progress-list">
                                    <div class="pull-left"><strong>Shipped Products</strong></div>
                                    <div class="pull-right">450/500</div>
                                    <div class="progress progress-small progress-striped active">
                                        <div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: 90%;">90%</div>
                                    </div>
                                </div>
                                <div class="progress-list">
                                    <div class="pull-left"><strong class="text-danger">Returned Products</strong></div>
                                    <div class="pull-right">25/500</div>
                                    <div class="progress progress-small progress-striped active">
                                        <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: 5%;">5%</div>
                                    </div>
                                </div>
                                <div class="progress-list">
                                    <div class="pull-left"><strong class="text-warning">Progress Today</strong></div>
                                    <div class="pull-right">75/150</div>
                                    <div class="progress progress-small progress-striped active">
                                        <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: 50%;">50%</div>
                                    </div>
                                </div>
                                <p><span class="fa fa-warning"></span> Data update in end of each hour. You can update it manual by pressign update button</p>
                            </div>
                            <div class="col-md-8">
                                <div id="dashboard-map-seles" style="width: 100%; height: 200px"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END SALES BLOCK -->

            </div>
            <div class="common-modal modal fade" id="common-Modal1" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-content">
                    <ul class="list-inline item-details">
                        <li><a href="http://themifycloud.com/downloads/janux-premium-responsive-bootstrap-admin-dashboard-template/">Admin templates</a></li>
                        <li><a href="http://themescloud.org">Bootstrap themes</a></li>
                    </ul>
                </div>
            </div>

            <div class="col-md-4">

                <!-- START SALES & EVENTS BLOCK -->
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="panel-title-box">
                            <h3>Sales & Event</h3>
                            <span>Event "Purchase Button"</span>
                        </div>
                        <ul class="panel-controls" style="margin-top: 2px;">
                            <li><a href="#" class="panel-fullscreen"><span class="fa fa-expand"></span></a></li>
                            <li><a href="#" class="panel-refresh"><span class="fa fa-refresh"></span></a></li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="fa fa-cog"></span></a>
                                <ul class="dropdown-menu">
                                    <li><a href="#" class="panel-collapse"><span class="fa fa-angle-down"></span> Collapse</a></li>
                                    <li><a href="#" class="panel-remove"><span class="fa fa-times"></span> Remove</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                    <div class="panel-body padding-0">
                        <div class="chart-holder" id="dashboard-line-1" style="height: 200px;"></div>
                    </div>
                </div>
                <!-- END SALES & EVENTS BLOCK -->

            </div>
        </div>

        <!-- START DASHBOARD CHART -->
        <div class="chart-holder" id="dashboard-area-1" style="height: 200px;"></div>
        <div class="block-full-width">

        </div>
        <!-- END DASHBOARD CHART -->

    </div>
    <!-- END PAGE CONTENT WRAPPER -->



@endsection
