@php 
    $lang = Session::get('lang');
    \App::setLocale($lang);
@endphp
<!DOCTYPE html>
<html lang="en">
    <head>        
        <!-- META SECTION -->
        <title>@yield('title') | Home</title>            
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        
        <link rel="icon" href="/img/logos/neelain-ico.gif" type="image/x-icon" />
        
        <!-- END META SECTION -->
        <!-- Ionicons -->
        <link rel="stylesheet" href="{{asset('Ionicons/css/ionicons.min.css')}}">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="{{asset('font-awesome/css/font-awesome.min.css')}}">

        <!-- CSS INCLUDE -->    
        @if($lang == 'en')    
            <link rel="stylesheet" type="text/css" id="theme" href="{{asset('/css/theme-default.css')}}"/>
        @elseif($lang == 'ar')  
            <link rel="stylesheet" type="text/css" id="theme" href="{{asset('/css/theme-default-ar.css')}}"/>
        @endif
        <!-- EOF CSS INCLUDE -->  
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
                font-size:14px;
            }
        </style>
    </head>
    <body>
        <div id="app" class="login-container lightmode">

        <!-- START PAGE CONTAINER -->
        <div class="navbar navbar-expand-md navbar-light shadow-sm">            
            <!-- PAGE CONTENT -->
            <div class="page-content">
                
                <!-- START X-NAVIGATION VERTICAL -->
                <ul class="x-navigation x-navigation-horizontal pull-right">
                    <li class="navbar-brand">
                        <a href="{{ url('/') }}">{{trans('strings.applicationName')}}</a>
                        <a href="#" class="x-navigation-control"></a>
                    </li>

                    <!-- SEARCH -->
                    <li class="xn-search">
                        <form role="form">
                            <input type="text" name="search" placeholder="{{trans('strings.search')}}"/>
                        </form>
                    </li>   
                    <!-- END SEARCH -->

                        <!-- <Control Panel>-->
                    <li class="xn-openable"><a href="#">
                        <span class="fa fa-cogs"></span>
                        <span class="xn-text">{{trans('strings.settings')}}</span></a>
                        <ul>@auth
                            <li class="xn-openable">
                                <a href="#"><span class="fa fa-edit"></span> {{trans('strings.Control in Account')}}</a>
                                <ul>
                                    <li><a href="#"><span class="fa fa-male"></span>{{trans('strings.Basic information')}}</a></li>
                                    <li><a href="#"><span class="fa fa-certificate"></span> {{trans('strings.Qualifications and certificates')}}</a></li>
                                    <li><a href="form-layouts-tabbed.html"><span class="fa fa-refresh"></span> {{trans('strings.Experience and jobs')}}</a></li>
                                    <li><a href="form-layouts-separated.html"><span class="fa fa-star-half-empty"></span>{{trans('strings.Skills and activities')}}</a></li>
                                    <li><a href="#"><span class="fa fa-arrow-right"></span> {{trans('strings.Training and courses')}}</a></li>
                                    <li><a href="form-layouts-two-column.html"><span class="fa fa-file-text-o"></span> {{trans('strings.Scientific Papers')}} </a></li>
                                    <li><a href="form-layouts-tabbed.html"><span class="fa fa-table"></span>{{trans('strings.Scientific Research')}}</a></li>
                                    <li><a href="form-layouts-separated.html"><span class="fa fa-book"></span> {{trans('strings.Books')}} </a></li>
                                    <li><a href="form-layouts-separated.html"><span class="fa fa-camera"></span>{{trans('strings.Conferences and meetings')}}</a></li>
                                </ul> 
                            </li>
                            <li class="xn-openable">
                                <a href="#"><span class="fa fa-envelope"></span> {{trans('strings.Mailbox')}}</a>
                                <ul>
                                    <li><a href="pages-mailbox-inbox.html"><span class="fa fa-inbox"></span> {{trans('strings.Inbox')}}</a></li>
                                    <li><a href="pages-mailbox-message.html"><span class="fa fa-file-text"></span> {{trans('strings.Message')}}</a></li>
                                    <li><a href="pages-mailbox-compose.html"><span class="fa fa-pencil"></span> {{trans('strings.Compose')}}</a></li>
                                </ul>
                            </li>
                            @endauth
                            <li class="xn-openable">
                                <a href="#"><span class="fa fa-edit"></span>{{trans('strings.Mange Account:')}}:@auth {{ Auth::user()->name }}@endauth</a>
                                <ul>
                                    <li>
                                        @if (Route::has('login'))
                                         @auth
                                    <a  href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();"><span class="fa fa-sign-out"></span>
                                        {{ __('Logout') }}
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                    </li>
                                    <li>
                                         @else
                                         <a href="{{ route('login') }}"><span class="fa fa-sign-in"></span>{{trans('strings.login_title')}}</a>
                                        @endauth
                                        @endif
                                    </li>
                                    <li>
                                </ul>    
                            </li>
                            <!-- <li class="xn-openable">
                                <a href="#"><span class="fa fa-edit"></span> {{trans('strings.profile_page_title')}}</a>
                                <ul>
                                    <li><a href="#"><span class="fa fa-male"></span>{{trans('strings.Basic information')}}</a></li>
                                    <li><a href="#"><span class="fa fa-certificate"></span> {{trans('strings.Qualifications and certificates')}}</a></li>
                                </ul>
                            </li> -->
                        </ul>
                    </li>
                    <li class="xn-openable">
                        <a href="/"><span class="fa fa-home"></span><span class="xn-text">{{trans('strings.Home')}}</span></a>
                    </li>
                    <li class="xn-openable">
                        <a href="#"><span class="fa fa-magnet"></span> <span class="xn-text">{{trans('strings.University institutions')}}</span></a>
                        <ul class="animated zoomIn">
                            <li><a href="#"><span class="fa fa-graduation-cap"></span> {{trans('strings.Un Government')}} </a></li>
                            <li><a href="#"><span class="fa fa-flag-o"></span> {{trans('strings.Ahli Universities')}}</a></li>
                            <li><a href="#"><span class="fa fa-certificate"></span> {{trans('strings.Private Universities')}}</a></li>
                    </li>                             
                </ul>
                    <li class="xn-openable">
                      <a href="#"><span class="fa fa-users"></span> <span class="xn-text">{{trans('strings.Teaching staff')}}</span></a>
                        <ul>
                            <li><a href="#"><span class="fa fa-user"></span> {{trans('strings.Members')}}</a></li>
                        </ul>
                    </li>                   
                    <li class="xn-openable">
                        <a href="#"><span class="fa fa-bar-chart-o"></span> <span class="xn-text">{{trans('strings.Statistics and charts')}}</span></a>
                        <ul class="animated zoomIn">
                            <li class="xn-openable">
                                <a href="form-layouts-two-column.html"><span class="fa fa-chain-broken"></span> {{trans('strings.Charts')}}</a>
                                <ul>
                                    <li><a href="#"><span class="fa fa-line-chart"></span>{{trans('strings.Line Chart')}}</a></li>
                                    <li><a href="#"><span class="fa fa-area-chart"></span>{{trans('strings.Area Chart')}}</a></li>
                                    <li><a href="#"><span class="fa fa-pie-chart"></span>{{trans('strings.Donut Chart')}}</a></li>
                                    <li><a href="#"><span class="fa fa-bar-chart"></span>{{trans('strings.Bar Chart')}}</a></li>
                                </ul> 
                            </li>
                            <li><a href="form-elements.html"><span class="fa fa fa-table"></span> {{trans('strings.Reports')}}</a></li>
                            <li><a href="form-validation.html"><span class="fa fa-map-marker"></span>{{trans('strings.Maps')}}</a></li>
                        </ul>
                    </li>
                    <li class="xn-openable">
                        <a href="#"><span class="fa fa-university"></span> <span class="xn-text">{{trans('strings.About Ministry')}}</span></a>
                    </li>
                   
                    <!-- END SIGN OUT --> 
                    @auth
                    <li class="xn-icon-button pull-right">
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
                                    <img src="assets/images/users/user2.jpg" class="pull-right" alt="John Doe"/>
                                    <span class="contacts-title">John Doe</span>
                                    <p>Praesent placerat tellus id augue condimentum</p>
                                </a>
                                <a href="#" class="list-group-item">
                                    <div class="list-group-status status-away"></div>
                                    <img src="assets/images/users/user.jpg" class="pull-right" alt="Dmitry Ivaniuk"/>
                                    <span class="contacts-title">Dmitry Ivaniuk</span>
                                    <p>Donec risus sapien, sagittis et magna quis</p>
                                </a>

                            </div>     
                            <div class="panel-footer text-center">
                                <a href="pages-messages.html">{{trans('strings.Show all messages')}}</a>
                            </div>                            
                        </div>                        
                    </li>
                    <li class="xn-icon-button pull-right">
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
                                    <img src="assets/images/users/user2.jpg" class="pull-right" alt="John Doe"/>
                                    <span class="contacts-title">John Doe</span>
                                    <p>Praesent placerat tellus id augue condimentum</p>
                                </a>
                                <a href="#" class="list-group-item">
                                    <div class="list-group-status status-away"></div>
                                    <img src="assets/images/users/user.jpg" class="pull-right" alt="Dmitry Ivaniuk"/>
                                    <span class="contacts-title">Dmitry Ivaniuk</span>
                                    <p>Donec risus sapien, sagittis et magna quis</p>
                                </a>

                            </div>     
                            <div class="panel-footer text-center">
                                <a href="pages-messages.html">{{trans('strings.Show all tasks')}}</a>
                            </div>                            
                        </div>                        
                    </li>
                    <!-- END MESSAGES -->
                    @endauth
                   
                    <!-- SIGN OUT -->
                    <!-- <li class="xn-icon-button pull-right">
                        <a href="#" class="mb-control" data-box="#mb-signout"><span class="fa fa-sign-out">logout</span></a>                        
                    </li> --> 
                    <!-- END SIGN OUT -->  
                     <li class="xn-icon-button pull-left">
                        <a href="/lang"><span class="text-center fa fa-globe">&nbsp;&nbsp;{{trans('strings.language')}}</a>                        
                    </li>            
                </ul>
                <!-- END X-NAVIGATION VERTICAL -->                     
                
                <!-- START BREADCRUMB -->
               <!--  <ul class="breadcrumb">
                    <li><a href="#">Home</a></li>
                    <li><a href="#">Layouts</a></li>
                    <li class="active">Navigation Top</li>
                </ul> -->
                <!-- END BREADCRUMB -->                
                
                <!-- <div class="page-title pull-right">                    
                    <h2><span class="fa fa-arrow-circle-o-left"></span> Navigation Top</h2>
                </div> -->                   
                <!-- PAGE CONTENT WRAPPER -->
                <div class="page-content-wrap">
                    <div>
                        
                        @yield('contents')                  
                    </div>
                    <div class="row">
                        <div class="col-md-8">
                        </div>
                    </div>
                </div>
                <!-- PAGE CONTENT WRAPPER -->                
            </div>            
            <!-- END PAGE CONTENT -->
        </div>
        <!-- END PAGE CONTAINER -->
        </div>
        <!-- MESSAGE BOX-->
        <div class="message-box animated fadeIn" data-sound="alert" id="mb-signout">
            <div class="mb-container">
                <div class="mb-middle">
                    <div class="mb-title"><span class="fa fa-sign-out"></span> Log <strong>Out</strong> ?</div>
                    <div class="mb-content">
                        <p>Are you sure you want to log out?</p>                    
                        <p>Press No if youwant to continue work. Press Yes to logout current user.</p>
                    </div>
                    <div class="mb-footer">
                        <div class="pull-right">
                            <a href="pages-login.html" class="btn btn-success btn-lg">Yes</a>
                            <button class="btn btn-default btn-lg mb-control-close">No</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END MESSAGE BOX-->

        <!-- START PRELOADS -->
        <audio id="audio-alert" src="{{asset('audio/alert.mp3')}}" preload="auto"></audio>
        <audio id="audio-fail" src="{{asset('audio/fail.mp3')}}" preload="auto"></audio>
        <!-- END PRELOADS -->               

    <!-- START SCRIPTS -->
        <!-- START PLUGINS -->
        <script type="text/javascript" src="{{asset('js/plugins/jquery/jquery.min.js')}}"></script>
        <script type="text/javascript" src="{{asset('js/plugins/jquery/jquery-ui.min.js')}}"></script>


        @if(Session::get('lang') == 'en')
            <script type="text/javascript" src="{{asset('/js/plugins/bootstrap/bootstrap.min.js')}}"></script>   
        @elseif(Session::get('lang') == 'ar')     
            <script type="text/javascript" src="{{asset('/js/plugins/bootstrap/bootstrap-ar.min.js')}}"></script>
        @endif

        <!-- THIS PAGE PLUGINS -->
        <script type='text/javascript' src="{{asset('js/plugins/icheck/icheck.min.js')}}"></script>
        <script type="text/javascript" src="{{asset('js/plugins/mcustomscrollbar/jquery.mCustomScrollbar.min.js')}}"></script>
        <script type="text/javascript" src="{{asset('js/plugins/scrolltotop/scrolltopcontrol.js')}}"></script>
        <!-- END PAGE PLUGINS -->       

        <script type="text/javascript" src="{{asset('js/plugins/morris/raphael-min.js')}}"></script>
        <script type="text/javascript" src="{{asset('js/plugins/morris/morris.min.js')}}"></script>       
        <script type="text/javascript" src="{{asset('js/plugins/rickshaw/d3.v3.js')}}"></script>
        <script type="text/javascript" src="{{asset('js/plugins/rickshaw/rickshaw.min.js')}}"></script>
        <script type='text/javascript' src="asset('js/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js')}}"></script>
        <script type='text/javascript' src="asset('js/plugins/jvectormap/jquery-jvectormap-world-mill-en.js')}}"></script>                
        <script type='text/javascript' src="asset('js/plugins/bootstrap/bootstrap-datepicker.js')}}"></script>                
        <script type="text/javascript" src="{{asset('js/plugins/owl/owl.carousel.min.js')}}"></script> 
        <script type="text/javascript" src="{{asset('js/plugins/moment.min.js')}}"></script>
        <script type="text/javascript" src="{{asset('js/plugins/daterangepicker/daterangepicker.js')}}"></script>
        <!-- END THIS PAGE PLUGINS-->
        @yield('extra-plugins') 
        <!-- END TEMPLATE -->
        
        <!-- END TEMPLATE -->
         <!-- START TEMPLATE -->
        
        @if(Session::get('lang') == 'en')
            <script type="text/javascript" src="{{asset('/js/plugins.js')}}"></script>
        @elseif(Session::get('lang') == 'ar')       
            <script type="text/javascript" src="{{asset('/js/plugins-ar.js')}}"></script> 
        @endif
        <script type="text/javascript" src="{{asset('/js/actions.js')}}"></script>
        <!-- END TEMPLATE -->
    <!-- END SCRIPTS -->   
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
    </body>
</html>






