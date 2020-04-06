@php 
    $lang = Session::get('lang');
    \App::setLocale($lang);
@endphp
<!DOCTYPE html>
<html lang="en">
    <head> 
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="/img/logos/neelain-ico.gif" type="image/x-icon" />
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />           
        <!-- META SECTION -->
        <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title> @yield('title') | {{trans('strings.applicationName')}}  </title>
    <!-- <script src="{{ asset('js/app.js') }}" defer></script> -->
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
        <link rel="stylesheet" href="{{asset('Ionicons/css/ionicons.min.css')}}">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="{{asset('font-awesome/css/font-awesome.min.css')}}">
        <!-- EOF CSS INCLUDE -->     
        <style type="text/css">

            @yield('style')
        </style>    
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
        <nav class="navbar navbar-expand-md navbar-light shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{trans('strings.applicationName')}}
                </a>
                <a class="nav-link" href="{{ url('/') }}">
                <span class="fa fa-home"></span>
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                   
                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto pull-right">
                        <!-- Authentication Links -->

                        @if(Auth::check())
                        @if(Auth::user()->hasRole('Admin'))
                        <li class="nav-item">
                                <a class="nav-link" href="{{ route('layouts.admin') }}">
                                    <span class="fa fa-desktop"></span> {{ trans('strings.cpanel') }} </a>
                        </li>
                        @endif
                        @endif
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ trans('strings.login_title') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{trans('strings.Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                    <a class="nav-link" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                                     <span class="fa fa-sign-out"></span>
                                                     {{trans('strings.Logout') }}
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                            </li>
                        @endguest
                         <!--  <li class="nav-item">
                                <a class="nav-link" href="{{ url('/') }}">
                                    <span class="fa fa-home"></span></a>
                          </li> -->
                          <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link" href="/lang">
                            <span class="text-center fa fa-globe"></span> &nbsp;&nbsp;{{trans('strings.language')}}
                            </a>                        
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>
     <!-- START PAGE CONTAINER -->
        @if($lang == 'ar')
        <div class="page-container page-navigation-toggled page-mode-rtl">
        @endif
        @if($lang == 'ar')
            <div class="page-container page-mode-rtl">
        @elseif($lang == 'en')
        <div class="page-container page-navigation-toggled page-mode-rtl">
            <div class="page-container">
        @endif
            <!-- START PAGE SIDEBAR -->
            <div class="page-sidebar">
                <!-- START X-NAVIGATION -->
                <ul class="x-navigation">
                    <li class="xn-logo">
                        <a href="index.html">{{trans('strings.Dashboard')}}</a>
                        <a href="#" class="x-navigation-control"></a>
                    </li>
                    <li class="xn-profile">
                        <a href="#" class="profile-mini">
                            <img src="assets/images/users/avatar.jpg" alt="John Doe"/>
                        </a>
                        <div class="profile">
                            <div class="profile-image">
                                <img src="assets/images/users/avatar.jpg" alt="John Doe"/>
                            </div>
                            <div class="profile-data">
                                <div class="profile-data-name">John Doe</div>
                                <div class="profile-data-title">Web Developer/Designer</div>
                            </div>
                            <div class="profile-controls">
                                <a href="pages-profile.html" class="profile-control-left"><span class="fa fa-info"></span></a>
                                <a href="pages-messages.html" class="profile-control-right"><span class="fa fa-envelope"></span></a>
                            </div>
                        </div>                                                                        
                    </li>
                    <li class="xn-title">{{trans('strings.Dashboard')}}</li>
                    <li>
                        <a href="/"><span class="fa fa-desktop"></span> <span class="xn-text">{{trans('strings.Home')}}</span></a>                        
                    </li>
                    <li class="xn-openable active">
                        <a href="#">
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
                                    <li>@if (Route::has('login'))
                                         @auth
                                        <a href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();"><span class="fa fa-sign-out"></span>
                                        {{ __('Logout') }}</a>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                    </li>
                                    <li> @else
                                        <a href="{{ route('login') }}"><span class="fa fa-sign-in"></span>{{trans('strings.login_title')}}</a>
                                         @endauth
                                        @endif
                                    </li>
                                </ul>
                            </li>
                            <li><a href="pages-messages.html"><span class="fa fa-comments"></span> Messages</a></li>
                            <li><a href="pages-calendar.html"><span class="fa fa-calendar"></span> Calendar</a></li>
                            <li class="active"><a href="pages-tasks.html"><span class="fa fa-edit"></span> Tasks</a></li>
                            <li class="xn-openable">
                                <a href="#"><span class="fa fa-file"></span> Blog</a>
                                
                                <ul>                                    
                                    <li><a href="pages-blog-list.html"><span class="fa fa-copy"></span> List of Posts</a></li>
                                    <li><a href="pages-blog-post.html"><span class="fa fa-file-o"></span>Single Post</a></li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <li class="xn-openable">
                        <a href="#"><span class="fa fa-users"></span> <span class="xn-text">{{trans('strings.Teaching staff')}}</span></a>
                        <ul>
                            <li><a href="layout-boxed.html"><span class="fa fa-user"></span> {{trans('strings.Members')}}</a></li>
                            <li><a href="layout-nav-toggled.html">Navigation Toggled</a></li>
                            <li><a href="blank.html">Blank Page</a></li>
                        </ul>
                    </li>
                    <li class="xn-openable">
                        <a href="#">
                        <span class="fa fa-cogs"></span>
                        <span class="xn-text">{{trans('strings.settings')}}</span></a>                        
                        <ul>
                            <li><a href="ui-widgets.html"><span class="fa fa-heart"></span> Widgets</a></li>
                        </ul>
                    </li>                    
                    <li class="xn-openable">
                        <a href="tables.html"><span class="fa fa-magnet"></span> <span class="xn-text">{{trans('strings.University institutions')}}</span></a>
                        <ul>                            
                            <li><a href="table-basic.html"><span class="fa fa-graduation-cap"></span> {{trans('strings.Un Government')}} </a></li>
                            <li><a href="table-datatables.html"><span class="fa fa-flag-o"></span> {{trans('strings.Ahli Universities')}}</a></li>
                            <li><a href="table-export.html"><span class="fa fa-certificate"></span> {{trans('strings.Private Universities')}}</a></li>
                        </ul>
                    </li>
                    <li class="xn-openable">
                        <a href="tables.html"><span class="fa fa-bar-chart-o"></span> <span class="xn-text">{{trans('strings.Statistics and charts')}}</span></a>
                        <ul>                            
                            <li><a href="table-basic.html"><span class="fa fa-chain-broken"></span> {{trans('strings.Charts')}}</a></li>
                            <li><a href="table-datatables.html"><span class="fa fa-line-chart"></span>{{trans('strings.Line Chart')}}</a></li>
                            <li><a href="table-export.html"><span class="fa fa-area-chart"></span>{{trans('strings.Area Chart')}}</a></li>
                            <li><a href="table-export.html"><span class="fa fa-pie-chart"></span>{{trans('strings.Donut Chart')}}</a></li>
                            <li><a href="#"><span class="fa fa-bar-chart"></span>{{trans('strings.Bar Chart')}}</a></li>                            
                        </ul>
                    </li>
                    <li>
                        <a href="#"><span class="fa fa-university"></span> <span class="xn-text">{{trans('strings.About Ministry')}}</span></a>
                    </li>
                    <li class="xn-openable">
                        <a href="tables.html"><span class="fa fa fa-table"></span> <span class="xn-text">{{trans('strings.Reports')}}</span></a>
                        <ul>                            
                            <li><a href="table-basic.html"><span class="fa fa fa-table"></span> {{trans('strings.Reports')}}</a></li>
                            <li><a href="table-datatables.html"><span class="fa fa-map-marker"></span>{{trans('strings.Maps')}}</a></li>
                        </ul>
                    </li>                    
                    <!-- <li class="xn-openable">
                        <a href="#"><span class="fa fa-sitemap"></span> <span class="xn-text">Navigation Levels</span></a>
                        <ul>                            
                            <li class="xn-openable">
                                <a href="#">Second Level</a>
                                <ul>
                                    <li class="xn-openable">
                                        <a href="#">Third Level</a>
                                        <ul>
                                            <li class="xn-openable">
                                                <a href="#">Fourth Level</a>
                                                <ul>
                                                    <li><a href="#">Fifth Level</a></li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>                            
                        </ul>
                    </li> -->
                    
                </ul>
                <!-- END X-NAVIGATION -->
            </div>
            <!-- END PAGE SIDEBAR -->
            
            <!-- PAGE CONTENT -->
            <div class="page-content">
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
                    <li class="xn-openable active">
                        <a href="#">
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
                                    <li>@if (Route::has('login'))
                                         @auth
                                        <a href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();"><span class="fa fa-sign-out"></span>
                                        {{ __('Logout') }}</a>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                    </li>
                                    <li> @else
                                        <a href="{{ route('login') }}"><span class="fa fa-sign-in"></span>{{trans('strings.login_title')}}</a>
                                         @endauth
                                        @endif
                                    </li>
                                </ul>
                            </li>
                            <li><a href="pages-messages.html"><span class="fa fa-comments"></span> Messages</a></li>
                            <li><a href="pages-calendar.html"><span class="fa fa-calendar"></span> Calendar</a></li>
                            <li class="active"><a href="pages-tasks.html"><span class="fa fa-edit"></span> Tasks</a></li>
                            <li class="xn-openable">
                                <a href="#"><span class="fa fa-file"></span> Blog</a>
                                
                                <ul>                                    
                                    <li><a href="pages-blog-list.html"><span class="fa fa-copy"></span> List of Posts</a></li>
                                    <li><a href="pages-blog-post.html"><span class="fa fa-file-o"></span>Single Post</a></li>
                                </ul>
                            </li>
                        </ul>
                    </li>
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
                                    <p>السلام عليكم ورحمة الله حبيبنا الاخبار والصحة ان شاء الله تمام التمام؟</p>
                                </a>

                            </div>     
                            <div class="panel-footer text-center">
                                <a href="pages-messages.html">{{trans('strings.Show all tasks')}}</a>
                            </div>                            
                        </div>                        
                    </li>
                    @endauth
                    
                </ul>
                <!-- END X-NAVIGATION VERTICAL -->                     

                <!-- START BREADCRUMB -->
                <ul class="breadcrumb">
                    @yield('breadcrumb')
                </ul>
                <!-- END BREADCRUMB -->                       
                                                            
                                
                <!-- START CONTENT FRAME -->
                <div class="content-frame">   
                    <!-- START WIDGETS -->                    
                    <div class="row">
                        <div class="col-md-3">
                            
                            <!-- START WIDGET SLIDER -->
                            <div class="widget widget-default widget-carousel">
                                <div class="owl-carousel" id="owl-example">
                                    <div>                                    
                                        <div class="widget-title">Disk Size </div>                                                                        
                                        <div class="widget-subtitle">27/08/2014 15:23</div>
                                        <div class="widget-int">3,548</div>
                                    </div>
                                    <div>                                    
                                        <div class="widget-title">Images </div>
                                        <div class="widget-subtitle">Visitors</div>
                                        <div class="widget-int">1,695</div>
                                    </div>
                                    <div>                                    
                                        <div class="widget-title">Audeo</div>
                                        <div class="widget-subtitle">Visitors</div>
                                        <div class="widget-int">1,977</div>
                                    </div>
                                </div>                            
                                <div class="widget-controls">                                
                                    <a href="#" class="widget-control-right widget-remove" data-toggle="tooltip" data-placement="top" title="Remove Widget"><span class="fa fa-times"></span></a>
                                </div>                             
                            </div>         
                            <!-- END WIDGET SLIDER -->
                            
                        </div>
                        <div class="col-md-3">
                            
                            <!-- START WIDGET MESSAGES -->
                            <div class="widget widget-default widget-item-icon" onclick="location.href='#';">
                                <div class="widget-item-left">
                                    <span class="fa fa-envelope"></span>
                                </div>                             
                                <div class="widget-data">
                                    <div class="widget-int num-count">5400</div>
                                    <div class="widget-title">{{trans('strings.all_teachers')}}</div>
                                    <div class="widget-subtitle">{{trans('strings.at this moment')}}</div>
                                </div>      
                                <div class="widget-controls">                                
                                    <a href="#" class="widget-control-right widget-remove" data-toggle="tooltip" data-placement="top" title="Remove Widget"><span class="fa fa-times"></span></a>
                                </div>
                            </div>                            
                            <!-- END WIDGET MESSAGES -->
                            
                        </div>
                        <div class="col-md-3">
                            
                            <!-- START WIDGET REGISTRED -->
                            <div class="widget widget-default widget-item-icon" onclick="location.href='#';">
                                <div class="widget-item-left">
                                    <span class="fa fa-user"></span>
                                </div>
                                <div class="widget-data">
                                    <div class="widget-int num-count">375</div>
                                    <div class="widget-title">{{trans('strings.all_teachers')}}</div>
                                    <div class="widget-subtitle">{{trans('strings.website')}}</div>
                                </div>
                                <div class="widget-controls">                                
                                    <a href="#" class="widget-control-right widget-remove" data-toggle="tooltip" data-placement="top" title="Remove Widget"><span class="fa fa-times"></span></a>
                                </div>                            
                            </div>                            
                            <!-- END WIDGET REGISTRED -->
                            
                        </div>
                        <div class="col-md-3">
                            
                            <!-- START WIDGET CLOCK -->
                            <div class="widget widget-info widget-padding-sm">
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
                            <!-- END WIDGET CLOCK -->
                            
                        </div>
                    </div>
                    <!-- END WIDGETS -->  
                    <!-- START CONTENT FRAME TOP -->
                    <div class="content-frame-top">                        
                        <div class="page-title">                    
                            <h2><span class="fa fa-arrow-circle-o-left"></span> Tasks</h2>
                        </div>                                                
                        <div class="pull-right">
                            <button class="btn btn-default content-frame-left-toggle"><span class="fa fa-bars"></span></button>
                        </div>                                
                        <div class="pull-right" style="width: 100px; margin-right: 5px;">
                            <select class="form-control select">
                                <option>All</option>                                
                                <option>Work</option>
                                <option>Home</option>
                                <option>Friends</option>
                                <option>Closed</option>
                            </select>
                        </div>
                        
                    </div>                    
                    <div class="content-frame-left">
                        <div class="form-group">
                            <h4>Add new task:</h4>
                            <textarea class="form-control push-down-10" id="new_task" rows="4" placeholder="Your task text here..."></textarea>                            
                            <button class="btn btn-primary" id="add_new_task"><span class="fa fa-edit"></span> Add</button>
                        </div>                        
                        <div class="form-group push-up-10">
                            <h4>Searh in tasks:</h4>
                            <div class="input-group">
                                <div class="input-group-addon"><span class="fa fa-search"></span></div>
                                <input type="text" class="form-control" placeholder="keyword..."/>
                            </div>
                        </div>
                        <div class="form-group">
                            <h4>Task groups:</h4>
                            <div class="list-group border-bottom">
                                <a href="#" class="list-group-item"><span class="fa fa-circle text-primary"></span> Project #1</a>
                                <a href="#" class="list-group-item"><span class="fa fa-circle text-success"></span> Personal</a>
                                <a href="#" class="list-group-item"><span class="fa fa-circle text-warning"></span> Project #2</a>
                                <a href="#" class="list-group-item"><span class="fa fa-circle text-danger"></span> Meetings</a>
                                <a href="#" class="list-group-item"><span class="fa fa-circle text-info"></span> Work</a>
                            </div>
                        </div>
                        <div class="form-group">
                            <h4>Tags:</h4>
                            <ul class="list-tags">
                                <li><a href="#"><span class="fa fa-tag"></span> amet</a></li>
                                <li><a href="#"><span class="fa fa-tag"></span> rutrum</a></li>
                                <li><a href="#"><span class="fa fa-tag"></span> nunc</a></li>
                                <li><a href="#"><span class="fa fa-tag"></span> tempor</a></li>
                                <li><a href="#"><span class="fa fa-tag"></span> eros</a></li>
                                <li><a href="#"><span class="fa fa-tag"></span> suspendisse</a></li>
                                <li><a href="#"><span class="fa fa-tag"></span> dolor</a></li>
                            </ul>                            
                        </div>
                        
                    </div>       
                    <!-- END CONTENT FRAME TOP -->
                    
                    <!-- START CONTENT FRAME BODY -->
                    <div class="content-frame-body">
                                                
                        <div class="row push-up-10">
                            <div class="col-md-4">
                                
                                <h3>To-do List</h3>
                                
                                <div class="tasks" id="tasks">

                                    <div class="task-item task-primary">                                    
                                        <div class="task-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris rutrum velit vel erat fermentum, a dignissim dolor malesuada.</div>
                                        <div class="task-footer">
                                            <div class="pull-left"><span class="fa fa-clock-o"></span> 1h 30min</div>                                    
                                        </div>                                    
                                    </div>

                                    <div class="task-item task-success">                                    
                                        <div class="task-text">Suspendisse a tempor eros. Curabitur fringilla maximus lorem, eget congue lacus ultrices eu. Nunc et molestie elit. Curabitur consectetur mollis ipsum, id hendrerit nunc molestie id.</div>
                                        <div class="task-footer">
                                            <div class="pull-left"><span class="fa fa-clock-o"></span> 1h 45min</div>
                                            <div class="pull-right"><a href="#"><span class="fa fa-chain"></span></a> <a href="#"><span class="fa fa-comments"></span></a></div>
                                        </div>                                    
                                    </div>

                                    <div class="task-item task-warning">                                    
                                        <div class="task-text">Donec lacus lacus, iaculis nec pharetra id, congue ut tortor. Donec tincidunt luctus metus eget rhoncus.</div>
                                        <div class="task-footer">
                                            <div class="pull-left"><span class="fa fa-clock-o"></span> 1day ago</div>
                                        </div>                                    
                                    </div>

                                    <div class="task-item task-danger">                                    
                                        <div class="task-text">Pellentesque faucibus molestie lectus non efficitur. Vestibulum mattis dignissim diam, eget dapibus urna rutrum vitae.</div>
                                        <div class="task-footer">
                                            <div class="pull-left"><span class="fa fa-clock-o"></span> 2days ago</div>
                                            <div class="pull-right"><a href="#"><span class="fa fa-chain"></span></a> <a href="#"><span class="fa fa-comments"></span></a></div>
                                        </div>                                    
                                    </div>

                                    <div class="task-item task-info">                                    
                                        <div class="task-text">Quisque quis ipsum quis magna bibendum laoreet.</div>
                                        <div class="task-footer">
                                            <div class="pull-left"><span class="fa fa-clock-o"></span> 3days ago</div>
                                            <div class="pull-right"><a href="#"><span class="fa fa-chain"></span></a> <a href="#"><span class="fa fa-comments"></span></a></div>
                                        </div>                                    
                                    </div>
                                    
                                </div>                            

                            </div>
                            <div class="col-md-4">
                                <h3>In Progress</h3>
                                <div class="tasks" id="tasks_progreess">

                                    <div class="task-item task-warning">
                                        <div class="task-text">In mauris nunc, blandit a turpis in, vehicula viverra metus. Quisque dictum purus lorem, in rhoncus justo dapibus eget. Aenean pretium non mauris et porttitor.</div>
                                        <div class="task-footer">
                                            <div class="pull-left"><span class="fa fa-clock-o"></span> 2h 55min</div>
                                            <div class="pull-right"><span class="fa fa-pause"></span> 4:51</div>
                                        </div>                                    
                                    </div>                            
                                    
                                    <div class="task-drop push-down-10">
                                        <span class="fa fa-cloud"></span>
                                        Drag your task here to start it tracking time
                                    </div>
                                    
                                </div>
                            </div>
                            <div class="col-md-4">
                                <h3>Completed</h3>
                                <div class="tasks" id="tasks_completed">
                                    <div class="task-item task-danger task-complete">                                    
                                        <div class="task-text">Donec maximus sodales feugiat.</div>
                                        <div class="task-footer">
                                            <div class="pull-left"><span class="fa fa-clock-o"></span> 15min</div>                                    
                                        </div>                                    
                                    </div>
                                    <div class="task-item task-info task-complete">                                    
                                        <div class="task-text">Aliquam eget est a dui tincidunt commodo in nec ante.</div>
                                        <div class="task-footer">
                                            <div class="pull-left"><span class="fa fa-clock-o"></span> 35min</div>                                    
                                        </div>                                    
                                    </div>
                                    <div class="task-drop">
                                        <span class="fa fa-cloud"></span>
                                        Drag your task here to finish it
                                    </div>                                    
                                </div>
                            </div>
                        </div>                        
                                                
                    </div>
                    <!-- END CONTENT FRAME BODY -->
                    
                </div>
                <!-- END CONTENT FRAME -->

            </div>            
            <!-- END PAGE CONTENT -->
        </div>
        <!-- END PAGE CONTAINER -->

        <!-- MODALS -->        
        <div class="modal fade" id="taskEdit" tabindex="-1" role="dialog" aria-labelledby="taskEditModalHead" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title" id="taskEditModalHead">Edit Task</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Task description</label>
                            <textarea class="form-control" id="task-text" rows="4"></textarea>
                        </div>
                        <div class="form-group">
                            <label>Task group</label>
                            <select class="form-control select">
                                <option>Work</option>
                                <option>Home</option>
                                <option>Friends</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">                        
                        <button type="button" class="btn btn-primary">Save changes</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>        
        <!-- END MODALS -->
        
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


        
       

    <!-- START WIDGETS -->                    

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
        <script type="text/javascript" src="{{asset('/js/plugins/bootstrap/bootstrap-select.js')}}"></script>
        @yield('extra-plugins')

        <!-- START TEMPLATE -->
        <script type="text/javascript" src="{{asset('/js/settings.js')}}"></script>
        
        @if(Session::get('lang') == 'en')
            <script type="text/javascript" src="{{asset('/js/plugins.js')}}"></script>
        @elseif(Session::get('lang') == 'ar')       
            <script type="text/javascript" src="{{asset('/js/plugins-ar.js')}}"></script> 
        @endif
        <script type="text/javascript" src="{{asset('/js/actions.js')}}"></script>
        <script type="text/javascript" src="{{asset('/js/demo_tasks.js')}}"></script>

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
        
    </body>
</html>