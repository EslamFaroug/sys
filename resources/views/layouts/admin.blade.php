@php
    $lang = Session::get('lang');
    \App::setLocale($lang);
@endphp
<!DOCTYPE html>
<html lang="en">
    <head>
        <!-- META SECTION -->
        <title> @yield('title') | {{trans('strings.applicationName')}}  </title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />

        <link rel="icon" href="/img/logos/neelain-ico.gif" type="image/x-icon" />
        <!-- END META SECTION -->

        <!-- CSS INCLUDE -->
        @if($lang == 'en')
            <link rel="stylesheet" type="text/css" id="theme" href="{{asset('/css/theme-default.css')}}"/>
        @elseif($lang == 'ar')
            <link rel="stylesheet" type="text/css" id="theme" href="{{asset('/css/theme-default-ar.css')}}"/>
        @endif
        <!-- Ionicons -->
        <link rel="stylesheet" href="{{asset('Ionicons/css/ionicons.min.css')}}">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="{{asset('font-awesome/css/font-awesome.min.css')}}">

        <!-- EOF CSS INCLUDE -->
        @yield("Style_css")

        <style type="text/css">

            @yield('style')
        </style>

        <style type="text/css">
            @font-face{
                font-family: Noto Kufi Arabic;
                src: url(/fonts/NotoKufiArabic-Regular.ttf);
            }
            body{
                font-family: 'Noto Kufi Arabic', 'Ruda', sans-serif;
                font-size:11px;
            }
        </style>
    </head>
    <body>

        <!-- MESSAGE BOX-->
        <div class="message-box animated fadeIn" data-sound="alert" id="mb-signout">
            <div class="mb-container">
                @if($lang == 'ar')
                <div class="mb-middle pull-right">
                    <div class="mb-title"><span class="fa fa-sign-out">{!!trans('strings.logout_question')!!}</div>
                    <div class="mb-content">
                        {!!trans('strings.logout_message')!!}
                    </div>
                    <div class="mb-footer">
                        <div class="pull-right">
                            <a href="logout" class="btn btn-success btn-lg" onclick="event.preventDefault();$('#logout_form').submit();">{{trans('strings.yes')}}</a>
                            <button class="btn btn-default btn-lg mb-control-close">{{trans('strings.no')}}</button>
                        </div>
                    </div>
                </div>
                 @elseif($lang == 'en')
                 <div class="mb-middle">
                    <div class="mb-title"><span class="fa fa-sign-out">{!!trans('strings.logout_question')!!}</div>
                    <div class="mb-content">
                        {!!trans('strings.logout_message')!!}
                    </div>
                    <div class="mb-footer">
                        <div class="pull-right">
                            <a href="logout" class="btn btn-success btn-lg" onclick="event.preventDefault();$('#logout_form').submit();">{{trans('strings.yes')}}</a>
                            <button class="btn btn-default btn-lg mb-control-close">{{trans('strings.no')}}</button>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
        <form id="logout_form" action="/logout" method="post">
            @csrf
        </form>
        <!-- END MESSAGE BOX-->

        <!-- START PAGE CONTAINER -->
        @if($lang == 'ar')
            <div class="page-container page-mode-rtl">
        @elseif($lang == 'en')
            <div class="page-container">
        @endif

            <!-- START PAGE SIDEBAR -->
            <div class="page-sidebar ">
                <!-- START X-NAVIGATION -->
                <ul class="x-navigation">
                    <li class="navbar-brand">
                        <a href="/admin" style="font-size:16px"> {{trans('strings.applicationName')}} </a>
                        <a href="#" class="x-navigation-control"></a>
                    </li>
                    <li class="xn-profile">
                        <a href="#" class="profile-mini">
                            <img src="/assets/images/users/avatar.jpg" />
                        </a>
                        <div class="profile">
                            <div class="profile-image">
                                    <img src="/img/users/default.png" />
                            </div>
                            <div class="profile-data">
                                <div class="profile-data-name">@auth {{ Auth::user()->name }}@endauth</div>
                                <div class="profile-data-title">@auth {{ Auth::user()->email }}@endauth
                                </div>
                            </div>
                            <div class="profile-controls">
                                <a href="/lang" class="profile-control-left"><span class="fa fa-cogs"></span></a>
                                <a href="logout" data-box="#mb-signout" class="profile-control-right mb-control"><span class="fa fa-sign-out"></span></a>
                            </div>
                        </div>
                    </li>
                    <li class="xn-title">{{trans('strings.navigation')}}</li>
                    <li >
                        <a href="/home/index"><span class="fa fa-home"></span> <span class="xn-text">{{trans('strings.Home page')}}</span></a>
                    </li>
                        <!-- <Control Panel>-->
                    <li class="xn-openable"><a href="#">
                        <span class="fa fa-cogs"></span>
                        <span class="xn-text">{{trans('strings.Control Panel')}}</span></a>
                        <ul>
                            <li><a href="#"><span class="fa fa-edit"></span>{{trans('strings.Account management')}}</a></li>
                            <li><a href="/users/index"><span class="fa fa-users"></span>{{trans('strings.Users Mangement')}}</a></li>
                            <li class="xn-openable">
                                <a href="#"><span class="fa fa-envelope"></span> {{trans('strings.Mailbox')}}</a>
                                <ul>
                                    <li><a href="pages-mailbox-inbox.html"><span class="fa fa-inbox"></span> {{trans('strings.Inbox')}}</a></li>
                                    <li><a href="pages-mailbox-message.html"><span class="fa fa-file-text"></span> {{trans('strings.Message')}}</a></li>
                                    <li><a href="pages-mailbox-compose.html"><span class="fa fa-pencil"></span> {{trans('strings.Compose')}}</a></li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                     <!-- <Data Control> -->
                    <li class="xn-openable">
                        <a href="#"><span class="fa fa-check-square-o"></span>
                        <span class="xn-text">{{trans('strings.Data control')}}</span></a>
                        <ul>
                               <!-- <Spatial Data> -->
                            <li class="xn-openable">
                                <a href="#"><span class="fa fa-map-marker"></span>{{trans('strings.Spatial data')}}</a>
                                <ul>
                                    <li><a href="/countries/index"><span class="fa fa-life-ring"></span> {{trans('strings.Countries')}} </a></li>
                                    <li><a href="/states/index"><span class="fa fa-location-arrow"></span>{{trans('strings.States')}}</a></li>
                                    <li><a href="/regionals/index"><span class="fa fa-map-signs"></span> {{trans('strings.Regionals')}}</a></li>
                                    <li><a href="/units/index"><span class="fa fa-map-pin"></span>{{trans('strings.Units/Block')}}</a></li>
                                </ul>
                            </li>
                            <!-- <Universiteis> -->
                            <li class="xn-openable"><a href="#">
                                <span class="fa fa-flag-checkered"></span>{{trans('strings.University institutions')}}</a>
                                <ul>
                                    <li><a href="/types_univers/index"><span class="fa fa-tree "></span> {{trans('strings.type_univers')}} </a></li>
                                    <li><a href="/universities/index"><span class="fa fa-magnet "></span> {{trans('strings.Universites')}} </a></li>
                                    <li><a href="/colleges/index"><span class="fa  fa-building"></span>{{trans('strings.Colleges')}}</a></li>
                                    <li><a href="/departments/index"><span class="fa  fa-umbrella"></span> {{trans('strings.Departments')}}</a>
                                    </li>
                                    <li><a href="/specials/index"><span class="fa  fa-graduation-cap"></span>{{trans('strings.Specializations')}}</a></li>
                                </ul>
                            </li>
                                <!-- <Works and studes> -->
                            <li class="xn-openable"><a href="#">
                                <span class="fa fa-search-plus"></span>{{trans('strings.Data of Work & Study')}}</a>
                                <ul>
                                    <li><a href="/qualifications/index"><span class="fa fa-shirtsinbulk"></span> {{trans('strings.Qualifications')}} </a></li>
                                    <li><a href="/degrees/index"><span class="fa fa-database"></span> {{trans('strings.Degree / Level')}} </a></li>
                                    <li><a href="/work_types/index"><span class="fa  fa-ra"></span>{{trans('strings.Work Data')}}</a></li>
                                    <li><a href="/study_types/index"><span class="fa  fa- fa-skype"></span> {{trans('strings.Study Data')}}</a></li>
                                    <li><a href="/mangejobs/index"><span class="fa fa-stack-overflow"></span> {{trans('strings.management jobs')}}</a></li>
                                </ul>
                            </li>
                        </ul>
                    </li>

                    <!-- <teachers> -->
                    <li class="xn-openable"><a href="#">
                        <span class="fa fa-pencil"></span><span class="xn-text">{{trans('strings.Professors Data')}}</span></a>
                        <ul>
                            <li><a href="/teachers/index"><span class="fa fa-user-plus"></span>{{trans('strings.Baisc Information')}}</a></li>
                            <li><a href="/tr_contact/index"><span class="fa fa-phone-square"></span>{{trans('strings.contact information')}}</a></li>
                            <li><a href="/certificates/index"><span class="fa fa-certificate"></span>{{trans('strings.Qualifications & certificates')}}</a></li>
                            <li><a href="/experiences/index"><span class="fa fa-shirtsinbulk"></span>{{trans('strings.Experiences and Jobs')}}</a></li>
                            <li><a href="/skills/index"><span class="fa fa-recycle"></span>{{trans('strings.Skills and activities')}}</a></li>
                            <li><a href="/training/index"><span class="fa fa-gg"></span>{{trans('strings.Training and courses')}}</a></li>
                            <li><a href="/papers/index"><span class="fa fa-copy"></span>{{trans('strings.Scientific Papers')}}</a></li>
                            <li><a href="/researches/index"><span class="fa  fa-search-plus"></span>{{trans('strings.Scientific Research')}}</a></li>
                            <li><a href="/books/index"><span class="fa fa-book"></span>{{trans('strings.Books')}}</a></li><li><a href="/interests/index"><span class="fa fa-thumbs-up"></span>{{trans('strings.Interests')}}</a></li>
                            <li><a href="/conferences/index"><span class="fa fa-microphone"></span>{{trans('strings.Conferences and meetings')}}</a></li>
                        </ul>
                    </li>

                    <!-- <reports> -->

                    <li class="xn-openable">
                        <a href="form-layouts-two-column.html">
                            <span class="fa fa-file-text"></span><span class="xn-text">{{trans('strings.Reports')}}</span></a>
                            <ul>
                                <li><a href="/re_teachers/all_teachers"><span class="fa fa-user"></span>{{trans('strings.genaral_info')}}</a></li>
                                <li><a href="/re_contacts/index"><span class="fa fa-phone-square"></span>{{trans('strings.contact information')}}</a></li>
                                <li><a href="/re_certificates/index"><span class="fa fa-certificate"></span>{{trans('strings.Qualifications & certificates')}}</a></li>
                                <li><a href="/re_experiences/index"><span class="fa fa-shirtsinbulk"></span>{{trans('strings.Experiences and Jobs')}}</a></li>
                                <li><a href="/re_skills/index"><span class="fa fa-recycle"></span>{{trans('strings.Skills and activities')}}</a></li>
                                <li><a href="/re_training/index"><span class="fa fa-gg"></span>{{trans('strings.Training and courses')}}</a></li>
                                <li><a href="/re_papers/index"><span class="fa fa-file-text"></span> {{trans('strings.Scientific Papers')}}</a></li>
                                <li><a href="/re_researches/index"><span class="fa  fa-search-plus"></span>{{trans('strings.Scientific Research')}}</a></li>
                                <li><a href="/re_books/index"><span class="fa fa-book"></span>{{trans('strings.Books')}}</a></li>
                                <li><a href="/re_interests/index"><span class="fa fa-thumbs-up"></span>{{trans('strings.Interests')}}</a></li>
                                <li><a href="/re_conferences/index"><span class="fa fa-microphone"></span>{{trans('strings.Conferences and meetings')}}</a></li>
                            </ul>
                        </li>
                    <!-- <end rports> -->

                    <!-- <Statistics> -->
                         <li class="xn-openable">
                            <a href="#"><span class="fa fa-bar-chart-o"> </span><span class="xn-text"> {{trans('strings.Statistics')}} </span></a>
                            <ul>
                                <li><a href="/GenaralStatistics/index"><span class="fa fa-pie-chart"></span> {{trans('strings.Genaral_Statistics')}}</a></li>


                                <li class="xn-openable">
                                    <a href="#"><span class="fa fa-line-chart"></span>  {{trans('strings.Detailed_Statistics')}}</a>
                                    <ul>
                                        <li><a href="pages-mailbox-inbox.html"><span class="fa fa-inbox"></span> {{trans('strings.Inbox')}}</a></li>
                                        <li><a href="pages-mailbox-message.html"><span class="fa fa-file-text"></span> {{trans('strings.Message')}}</a></li>
                                        <li><a href="pages-mailbox-compose.html"><span class="fa fa-pencil"></span> {{trans('strings.Compose')}}</a></li>
                                    </ul>
                                </li>
                            </ul>


                </ul>
                <!-- END X-NAVIGATION -->
            </div>
            <!-- END PAGE SIDEBAR -->

            <!-- PAGE CONTENT -->
            <div class="page-content">

                <!-- START X-NAVIGATION VERTICAL -->
                <ul class="x-navigation x-navigation-horizontal x-navigation-panel">
                    <!-- TOGGLE NAVIGATION -->
                    <li class="xn-icon-button">
                        <a href="#" class="x-navigation-minimize"><span class="fa fa-dedent"></span></a>
                    </li>
                    <!-- END TOGGLE NAVIGATION -->
                    <!-- SEARCH -->
                    <li class="xn-search">
                        <form role="form">
                            <input type="text" name="search" placeholder="{{trans('strings.search')}}"/>
                        </form>
                    </li>
                    <!-- END SEARCH -->
                    <!-- SIGN OUT -->
                    <li class="xn-icon-button pull-left">
                        <a href="#" class="mb-control" data-box="#mb-signout"><span class="fa fa-sign-out"></span></a>
                    </li>
                    <!-- END SIGN OUT -->
                    @auth
                    <li class="xn-icon-button pull-left">
                        <a href="#"><span class="fa fa-comments"></span></a>
                        <div class="informer informer-danger">4</div>
                        @if($lang == 'ar')
                            <div class="panel panel-primary animated zoomIn xn-drop-left xn-panel-dragging">
                        @elseif($lang == 'en')
                            <div class="panel panel-primary animated zoomIn xn-drop-left xn-panel-dragging">
                        @endif
                            <div class="panel-heading">
                                <h3 class="panel-title pull-left"><span class="fa fa-comments"></span> {{trans('strings.message')}}</h3>
                            </div>
                            <div class="panel-body list-group list-group-contacts scroll" style="height: 200px;">
                                 <a href="#" class="list-group-item">
                                    <div class="list-group-status status-online"></div>
                                    <img src="/assets/images/users/user2.jpg" class="pull-right" alt="John Doe"/>
                                    <span class="contacts-title">John Doe</span>
                                    <p>Praesent placerat tellus id augue condimentum</p>
                                </a>
                                <a href="#" class="list-group-item">
                                    <div class="list-group-status status-away"></div>
                                    <img src="/assets/images/users/user.jpg" class="pull-right" alt="Dmitry Ivaniuk"/>
                                    <span class="contacts-title">Dmitry Ivaniuk</span>
                                    <p>Donec risus sapien, sagittis et magna quis</p>
                                </a>

                            </div>
                            <div class="panel-footer text-center">
                                <a href="pages-messages.html">{{trans('strings.Show all messages')}}</a>
                            </div>
                        </div>
                    </li>
                    <li class="xn-icon-button pull-left">
                        <a href="#"><span class="fa fa-tasks"></span></a>
                        <div class="informer informer-danger">5</div>
                        @if($lang == 'ar')
                            <div class="panel panel-primary animated zoomIn xn-drop-left xn-panel-dragging">
                        @elseif($lang == 'en')
                            <div class="panel panel-primary animated zoomIn xn-drop-left xn-panel-dragging">
                        @endif
                            <div class="panel-heading">
                                <h3 class="panel-title pull-left"><span class="fa fa-tasks"></span> {{trans('strings.Tasks')}}</h3>
                            </div>
                            <div class="panel-body list-group list-group-contacts scroll" style="height: 200px;">
                                 <a href="#" class="list-group-item">
                                    <div class="list-group-status status-online"></div>
                                    <img src="/assets/images/users/user2.jpg" class="pull-right" alt="John Doe"/>
                                    <span class="contacts-title">John Doe</span>
                                    <p>Praesent placerat tellus id augue condimentum</p>
                                </a>
                                <a href="#" class="list-group-item">
                                    <div class="list-group-status status-away"></div>
                                    <img src="/assets/images/users/user.jpg" class="pull-right" alt="Dmitry Ivaniuk"/>
                                    <span class="contacts-title">Dmitry Ivaniuk</span>
                                    <p>Donec risus sapien, sagittis et magna quis</p>
                                </a>

                            </div>
                            <div class="panel-footer text-center">
                                <a href="pages-messages.html">{{trans('strings.Show all tasks')}}</a>
                            </div>
                        </div>
                    </li>
                    @endauth
                    <li class="xn-icon-button pull-left">
                        <a href="/lang"><span class="text-center fa fa-globe">&nbsp;&nbsp;{{trans('strings.language')}}</a>
                    </li>
                </ul>
                <!-- END X-NAVIGATION VERTICAL -->

                <!-- START BREADCRUMB -->
                    @yield('breadcrumb')
                <!-- END BREADCRUMB -->


                    @if($lang == 'en')
                    <div class="page-title">
                     @section('inner-title')<h2><span class="fa fa-arrow-circle-o-left"></span> </h2> @endsection
                    </div>
                    @elseif($lang == 'ar')
                    <div class="page-title" dir="rtl" style="position: relative;right: 0px">
                        @section('inner-title')<h2><span class="fa fa-arrow-circle-o-left"></span> </h2> @endsection
                    </div>
                    @endif
                        @include('partial.alerts')
                        @yield('contents')

            </div>
</div>
        <!-- START PRELOADS -->
        <audio id="audio-alert" src="{{asset('/audio/alert.mp3')}}" preload="auto"></audio>
        <audio id="audio-fail" src="{{asset('/audio/fail.mp3')}}" preload="auto"></audio>
        <!-- END PRELOADS -->

    <!-- START SCRIPTS -->
        <!-- START PLUGINS -->
        <script type="text/javascript" src="{{asset('/js/plugins/jquery/jquery.min.js')}}"></script>
        <script type="text/javascript" src="{{asset('/js/plugins/jquery/jquery-ui.min.js')}}"></script>


        @if(Session::get('lang') == 'en')
            <script type="text/javascript" src="{{asset('/js/plugins/bootstrap/bootstrap.min.js')}}"></script>
        @elseif(Session::get('lang') == 'ar')
            <script type="text/javascript" src="{{asset('/js/plugins/bootstrap/bootstrap-ar.min.js')}}"></script>
        @endif
        <!-- END PLUGINS -->

        <!-- START THIS PAGE PLUGINS-->
        <script type='text/javascript' src="{{asset('/js/plugins/icheck/icheck.min.js')}}"></script>
        <script type="text/javascript" src="{{asset('/js/plugins/mcustomscrollbar/jquery.mCustomScrollbar.min.js')}}"></script>
        <script type="text/javascript" src="{{asset('/js/plugins/scrolltotop/scrolltopcontrol.js')}}"></script>

        <script type="text/javascript" src="{{asset('/js/plugins/morris/raphael-min.js')}}"></script>
        <script type="text/javascript" src="{{asset('/js/plugins/morris/morris.min.js')}}"></script>
        <script type="text/javascript" src="{{asset('/js/plugins/rickshaw/d3.v3.js')}}"></script>
        <script type="text/javascript" src="{{asset('/js/plugins/rickshaw/rickshaw.min.js')}}"></script>
        <script type='text/javascript' src="{{asset('/js/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js')}}"></script>
        <script type='text/javascript' src="{{asset('/js/plugins/jvectormap/jquery-jvectormap-world-mill-en.js')}}"></script>
        <script type='text/javascript' src="{{asset('/js/plugins/bootstrap/bootstrap-datepicker.js')}}"></script>
        <script type="text/javascript" src="{{asset('/js/plugins/owl/owl.carousel.min.js')}}"></script>

        <script type="text/javascript" src="{{asset('/js/plugins/moment.min.js')}}"></script>
        <script type="text/javascript" src="{{asset('/js/plugins/daterangepicker/daterangepicker.js')}}"></script>
        <!-- END THIS PAGE PLUGINS-->

        @yield('extra-plugins')

        <!-- START TEMPLATE -->
        <script type="text/javascript" src="{{asset('/js/settings.js')}}"></script>

        @if(Session::get('lang') == 'en')
            <script type="text/javascript" src="{{asset('/js/plugins.js')}}"></script>
        @elseif(Session::get('lang') == 'ar')
            <script type="text/javascript" src="{{asset('/js/plugins-ar.js')}}"></script>
        @endif
        <script type="text/javascript" src="{{asset('/js/actions.js')}}"></script>

        <!-- END TEMPLATE -->


        <script type="text/javascript" src="{{asset('js/plugins/smartwizard/jquery.smartWizard-2.0.min.js')}}"></script>
        <script type="text/javascript" src="{{asset('js/plugins/jquery-validation/jquery.validate.js')}}"></script>
        <!-- END SCRIPTS -->
        <script type="text/javascript" src="{{asset('js/plugins/dropzone/dropzone.min.js')}}"></script>
        <script type="text/javascript" src="{{asset('js/plugins/fileinput/fileinput.min.js')}}"></script>
        <script type="text/javascript" src="{{asset('js/plugins/filetree/jqueryFileTree.js')}}"></script>

         <script type="text/javascript">
            $(document).ready(function() {
                @if($lang == 'ar')
                    theme_settings.st_sb_right = 1;
                @elseif($lang == 'en')
                    theme_settings.st_sb_right = 0;
                @endif

                set_settings(theme_settings,false);
            });

            @yield('javascript')
        </script>
        <script>
            $(function(){
                $("#file-simple").fileinput({
                        showUpload: false,
                        showCaption: false,
                        browseClass: "btn btn-danger",
                        fileType: "any"
                });
                $("#filetree").fileTree({
                    root: '/',
                    script: 'assets/filetree/jqueryFileTree.php',
                    expandSpeed: 100,
                    collapseSpeed: 100,
                    multiFolder: false
                }, function(file) {
                    alert(file);
                }, function(dir){
                    setTimeout(function(){
                        page_content_onresize();
                    },200);
                });
            });
        </script>

        <script type="text/javascript" src="/filezone.js"></script>

        <script type="text/javascript">
            var filezone = new Filezone();
        </script>
    </body>
</html>
