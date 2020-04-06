@php 
    $lang = Session::get('lang');
    \App::setLocale($lang);
@endphp
<!DOCTYPE html>
<html lang="en">
    <head>        
        <!-- META SECTION -->
        <title>@yield('title') | Home </title>            
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <link rel="icon" href="favicon.ico" type="image/x-icon" />
        <!-- END META SECTION -->

        <!-- CSS INCLUDE -->  
        @if($lang == 'en')      
        <link rel="stylesheet" type="text/css" id="theme" href="{{asset('css/theme-default.css')}}"/>
        @elseif($lang == 'ar')
        <link rel="stylesheet" type="text/css" id="theme" href="{{asset('/css/theme-default-ar.css')}}">
        @endif
        <!-- EOF CSS INCLUDE -->  

        <!-- Ionicons -->
        <link rel="stylesheet" href="{{asset('Ionicons/css/ionicons.min.css')}}">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="{{asset('font-awesome/css/font-awesome.min.css')}}">

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
                font-size:10px;
            }
        </style>                                    
    </head>
    <body>

        <!-- MESSAGE BOX-->
        <div class="message-box animated fadeIn" data-sound="alert" id="mb-signout">
            <div class="mb-container">
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
            </div>
        </div>
        <form id="logout_form" action="/logout" method="post">
            @csrf
        </form>
        <!-- END MESSAGE BOX-->

        <!-- START PAGE CONTAINER -->
       <!-- START PAGE CONTAINER -->
        @if($lang == 'ar')
            <div class="page-container page-mode-rtl">
        @elseif($lang == 'en')
            <div class="page-container">
        @endif

            <!-- START PAGE SIDEBAR -->
            <div class="page-sidebar">
                <!-- START X-NAVIGATION -->
                <ul class="x-navigation">
                    <li class="xn-logo">
                        <a href="index.html">{{trans('strings.applicationName')}}</a>
                        <a href="#" class="x-navigation-control"></a>
                    </li>
                    <li class="xn-profile">
                        <a href="#" class="profile-mini">
                            <img src="assets/images/users/avatar.jpg" />
                        </a>
                        <div class="profile">
                            <div class="profile-image">
                                <img src="assets/images/users/profile.jpg" alt="John Doe"/>
                            </div>
                            <div class="profile-data">
                                <div class="profile-data-name">M.anas </div>
                                <div class="profile-data-title">Tetcher</div>
                            </div>
                            <div class="profile-controls">
                                <a href="#" class="profile-control-left"><span class="fa fa-info"></span></a>
                                <a href="#" class="profile-control-right mb-control"><span class="fa fa-sign-out"></span></a>
                            </div>
                        </div>
                    </li>
                     <!-- <Navigation>                 -->
                    <li class="xn-title">{{trans('Move between pages')}}</li><li class="active"><a href="/"><span class="fa fa-home"></span><span class="xn-text">{{trans('Home Page')}}</span></a></li>    
                    <!-- <Control Panel>                 -->
                    <li class="xn-openable"><a href="#"><span class="fa fa-cogs"></span> <span class="xn-text">{{trans('Control Panel')}}</span></a><ul><li><a href="#"><span class="fa fa-edit"></span>{{trans(' Account management ')}}</a></li><li><a href="#"><span class="fa fa-users"></span>{{trans(' Users Mangement')}}</a></li><li class="xn-openable"><a href="#"><span class="fa fa-envelope"></span> {{trans('Mailbox')}}</a><ul><li class="active"><a href="pages-mailbox-inbox.html"><span class="fa fa-inbox"></span> {{trans('Inbox')}}</a></li><li><a href="pages-mailbox-message.html"><span class="fa fa-file-text"></span> {{trans('Message')}}</a></li><li><a href="pages-mailbox-compose.html"><span class="fa fa-pencil"></span> {{trans('Compose')}}</a></li></ul></li></ul></li>
                    <!-- <Data Control> -->
                    <li class="xn-openable"><a href="#"><span class="fa fa-check-square-o"></span> <span class="xn-text">{{trans('Data control')}}</span></a><ul>
                        <!-- <Spatial Data> -->
                    <li class="xn-openable"><a href="#"><span class="fa fa-map-marker"></span> Spatial data</a><ul><li><a href="pages-mailbox-inbox.html"><span class="fa fa-life-ring"></span> Countries </a></li><li><a href="pages-mailbox-message.html"><span class="fa fa-location-arrow"></span>States</a></li><li><a href="pages-mailbox-compose.html"><span class="fa fa-map-signs"></span> Regionals</a></li><li><a href="pages-mailbox-compose.html"><span class="fa fa-map-pin"></span>Units/Block</a></li></ul></li>
                    <!-- <Universiteis> -->
                    <li class="xn-openable"><a href="#"><span class="fa fa-flag-checkered"></span>University institutions</a><ul><li><a href="pages-mailbox-inbox.html"><span class="fa fa-magnet "></span> Universites </a></li><li><a href="pages-mailbox-message.html"><span class="fa  fa-building"></span>Colleges</a></li><li><a href="pages-mailbox-compose.html"><span class="fa  fa-umbrella"></span> Departments</a></li><li><a href="#"><span class="fa  fa-graduation-cap"></span>Specializations</a></li></ul></li>
                    <!-- <Qualifications> -->
                    <li class="xn-openable"><a href="#"><span class="fa fa-search-plus"></span>Qualifications / Study</a><ul><li><a href="pages-mailbox-inbox.html"><span class="fa fa-database"></span> Degree / Level </a></li><li><a href="pages-mailbox-message.html"><span class="fa  fa-ra"></span>Work Data</a></li><li><a href="pages-mailbox-compose.html"><span class="fa  fa- fa-skype"></span> Study Data</a></li></ul></li></ul></li>

                    <!-- <teachers> -->
                    <li><a href="#"><span class="fa fa-pencil"></span>Professors' Data</a><div class="informer informer-warning">New</div><ul><li><a href="#"><span class="fa fa-user-plus"></span>Baisc Information</a></li><li><a href="#"><span class="fa fa-certificate"></span>Qualifications & certificates</a></li><li><a href="#"><span class="fa fa-shirtsinbulk"></span>Experiences and Jobs</a></li><li><a href="#"><span class="fa fa-recycle"></span>Skills and activities</a></li><li><a href="#"><span class="fa fa-gg"></span>Training and courses</a></li><li><a href="#"><span class="fa fa-copy"></span>Scientific Papers</a></li><li><a href="#"><span class="fa  fa-search-plus"></span>Scientific Research</a></li><li><a href="#"><span class="fa fa-book"></span>Books</a></li><li><a href="#"><span class="fa fa-microphone"></span>Conferences and meetings</a></li></ul></li>

                    <!-- <reports> -->

                    <li><a href="form-layouts-two-column.html"><span class="fa fa-pencil"> </span>Reports</a><div class="informer informer-info">View</div><ul><li><a href="#"><span class="fa fa-user-plus"></span>#</a></li><li><a href="#"><span class="fa fa-certificate"></span>#</a></li><li><a href="#"><span class="fa fa-shirtsinbulk"></span>#</a></li><li><a href="#"><span class="fa fa-recycle"></span># </a></li><li><a href="#"><span class="fa fa-gg"></span>#</a></li><li><a href="#"><span class="fa fa-copy"></span>#</a></li><li><a href="#"><span class="fa  fa-search-plus"></span>#</a></li><li><a href="#"><span class="fa fa-book"></span>#</a></li><li><a href="#"><span class="fa fa-microphone"></span>#</a></li></ul></li>
                    <!-- <end rports> -->

                    <!-- <Statistics> -->
                    <li><a href="#"><span class="fa fa-bar-chart-o"> </span>Statistics and charts</a><div class="informer informer-danger">Mor</div><ul><li><a href="#"><span class="fa fa-line-chart"></span>Line Chart</a></li><li><a href="#"><span class="fa fa-area-chart"></span>Area Chart</a></li><li><a href="#"><span class="fa fa-pie-chart"></span>Donut Chart</a></li><li><a href="#"><span class="fa fa-bar-chart"></span>Bar Chart</a></li>


                     <!-- <li class="active">
                        <a href="index.html"><span class="fa fa-desktop"></span> <span class="xn-text">Shared File </span></a>                        
                    </li>  --> 
                    
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
                            <input type="text" name="search" placeholder="Search..."/>
                        </form>
                    </li>   
                    <!-- END SEARCH -->
                    <li class="xn-icon-button pull-left">
                        <a href="/lang"><span class="text-center fa fa-globe">&nbsp;&nbsp;{{trans('strings.language')}}</a>                        
                    </li>
                    <!-- SIGN OUT -->
                    <li class="xn-icon-button pull-right">
                        <a href="/logout" class="mb-control" data-box="#mb-signout"><span class="fa fa-sign-out"></span></a>                        
                    </li> 
                    <!-- END SIGN OUT -->
                    <!-- MESSAGES -->
                    <li class="xn-icon-button pull-right">
                        <a href="#"><span class="fa fa-comments"></span></a>
                        <div class="informer informer-danger">4</div>
                        <div class="panel panel-primary animated zoomIn xn-drop-left xn-panel-dragging">
                            <div class="panel-heading">
                                <h3 class="panel-title"><span class="fa fa-comments"></span> Messages</h3>                                
                                <div class="pull-right">
                                    <span class="label label-danger">4 new</span>
                                </div>
                            </div>
                            <div class="panel-body list-group list-group-contacts scroll" style="height: 200px;">
                                <a href="#" class="list-group-item">
                                    <div class="list-group-status status-online"></div>
                                    <img src="assets/images/users/user2.jpg" class="pull-left" alt="John Doe"/>
                                    <span class="contacts-title">John Doe</span>
                                    <p>Praesent placerat tellus id augue condimentum</p>
                                </a>
                                <a href="#" class="list-group-item">
                                    <div class="list-group-status status-away"></div>
                                    <img src="assets/images/users/user.jpg" class="pull-left" alt="Dmitry Ivaniuk"/>
                                    <span class="contacts-title">Dmitry Ivaniuk</span>
                                    <p>Donec risus sapien, sagittis et magna quis</p>
                                </a>
                                <a href="#" class="list-group-item">
                                    <div class="list-group-status status-away"></div>
                                    <img src="assets/images/users/user3.jpg" class="pull-left" alt="Nadia Ali"/>
                                    <span class="contacts-title">Nadia Ali</span>
                                    <p>Mauris vel eros ut nunc rhoncus cursus sed</p>
                                </a>
                                <a href="#" class="list-group-item">
                                    <div class="list-group-status status-offline"></div>
                                    <img src="assets/images/users/user6.jpg" class="pull-left" alt="Darth Vader"/>
                                    <span class="contacts-title">Darth Vader</span>
                                    <p>I want my money back!</p>
                                </a>
                            </div>     
                            <div class="panel-footer text-center">
                                <a href="pages-messages.html">Show all messages</a>
                            </div>                            
                        </div>                        
                    </li>
                    <!-- END MESSAGES -->
                    <!-- TASKS -->
                    <li class="xn-icon-button pull-right">
                        <a href="#"><span class="fa fa-tasks"></span></a>
                        <div class="informer informer-warning">3</div>
                        <div class="panel panel-primary animated zoomIn xn-drop-left xn-panel-dragging">
                            <div class="panel-heading">
                                <h3 class="panel-title"><span class="fa fa-tasks"></span> Tasks</h3>                                
                                <div class="pull-right">
                                    <span class="label label-warning">3 active</span>
                                </div>
                            </div>
                            <div class="panel-body list-group scroll" style="height: 200px;">                                
                                <a class="list-group-item" href="#">
                                    <strong>Phasellus augue arcu, elementum</strong>
                                    <div class="progress progress-small progress-striped active">
                                        <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: 50%;">50%</div>
                                    </div>
                                    <small class="text-muted">John Doe, 25 Sep 2014 / 50%</small>
                                </a>
                                <a class="list-group-item" href="#">
                                    <strong>Aenean ac cursus</strong>
                                    <div class="progress progress-small progress-striped active">
                                        <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width: 80%;">80%</div>
                                    </div>
                                    <small class="text-muted">Dmitry Ivaniuk, 24 Sep 2014 / 80%</small>
                                </a>
                                <a class="list-group-item" href="#">
                                    <strong>Lorem ipsum dolor</strong>
                                    <div class="progress progress-small progress-striped active">
                                        <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="95" aria-valuemin="0" aria-valuemax="100" style="width: 95%;">95%</div>
                                    </div>
                                    <small class="text-muted">John Doe, 23 Sep 2014 / 95%</small>
                                </a>
                                <a class="list-group-item" href="#">
                                    <strong>Cras suscipit ac quam at tincidunt.</strong>
                                    <div class="progress progress-small">
                                        <div class="progress-bar" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%;">100%</div>
                                    </div>
                                    <small class="text-muted">John Doe, 21 Sep 2014 /</small><small class="text-success"> Done</small>
                                </a>                                
                            </div>     
                            <div class="panel-footer text-center">
                                <a href="pages-tasks.html">Show all tasks</a>
                            </div>                            
                        </div>                        
                    </li>
                    <!-- END TASKS -->
                </ul>
                <!-- END X-NAVIGATION VERTICAL -->                     

                <!-- START BREADCRUMB -->
                <ul class="breadcrumb">
                    <li><a href="#">Home</a></li>                    
                    <li class="active">Dashboard</li>
                </ul>
                <!-- END BREADCRUMB -->                       
                
                <!-- PAGE CONTENT WRAPPER -->
                <div class="page-content-wrap">
                    
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
                            <div class="widget widget-default widget-item-icon" onclick="location.href='pages-messages.html';">
                                <div class="widget-item-left">
                                    <span class="fa fa-envelope"></span>
                                </div>                             
                                <div class="widget-data">
                                    <div class="widget-int num-count">48</div>
                                    <div class="widget-title">New messages</div>
                                    <div class="widget-subtitle">In your mailbox</div>
                                </div>      
                                <div class="widget-controls">                                
                                    <a href="#" class="widget-control-right widget-remove" data-toggle="tooltip" data-placement="top" title="Remove Widget"><span class="fa fa-times"></span></a>
                                </div>
                            </div>                            
                            <!-- END WIDGET MESSAGES -->
                            
                        </div>
                        <div class="col-md-3">
                            
                            <!-- START WIDGET REGISTRED -->
                            <div class="widget widget-default widget-item-icon" onclick="location.href='pages-address-book.html';">
                                <div class="widget-item-left">
                                    <span class="fa fa-user"></span>
                                </div>
                                <div class="widget-data">
                                    <div class="widget-int num-count">375</div>
                                    <div class="widget-title">Registred users</div>
                                    <div class="widget-subtitle">On your website</div>
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
                    
                    <div class="row">
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
                                        <h3>File Stetus</h3>
                                    
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
                                                    <th width="50%">File</th>
                                                    <th width="20%">Stetus</th>
                                                    <th width="30%">Brogress</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td><strong>Images </strong></td>
                                                    <td><span class="label label-danger">Image File </span></td>
                                                    <td>
                                                        <div class="progress progress-small progress-striped active">
                                                            <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: 85%;">85%</div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Videos </strong></td>
                                                    <td><span class="label label-warning">Videos File </span></td>
                                                    <td>
                                                        <div class="progress progress-small progress-striped active">
                                                            <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: 40%;">40%</div>
                                                        </div>
                                                    </td>
                                                </tr>                                                
                                                <tr>
                                                    <td><strong>Audeo </strong></td>
                                                    <td><span class="label label-warning">Audeo File </span></td>
                                                    <td>
                                                        <div class="progress progress-small progress-striped active">
                                                            <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: 72%;">72%</div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Doc </strong></td>
                                                    <td><span class="label label-success">Doc File </span></td>
                                                    <td>
                                                        <div class="progress progress-small progress-striped active">
                                                            <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: 100%;">100%</div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Exe</strong></td>
                                                    <td><span class="label label-success">Exe File </span></td>
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
                                        <a href="/dash_users" class="btn btn-success btn-lg">Yes</a>
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
        <script type="text/javascript" src="{{asset('js/plugins/bootstrap/bootstrap.min.js')}}"></script>         
        <!-- END PLUGINS -->

       
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
<!-- START TEMPLATE -->
        <script type="text/javascript" src="{{asset('js/settings.js')}}"></script>
        
        <script type="text/javascript" src="{{asset('js/plugins.js')}}"></script>        
        <script type="text/javascript" src="{{asset('js/actions.js')}}"></script>    
        <script type="text/javascript" src="{{asset('js/demo_dashboard.js')}}"></script>
        <!-- END TEMPLATE -->
    <!-- END SCRIPTS -->         
    </body>
</html>






