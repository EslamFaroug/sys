@php
    App::setLocale(Session::get('lang'));
@endphp
<!DOCTYPE html>
<html lang="en" class="body-full-height">
    <head>        
        <!-- META SECTION -->
        <title> {{trans('strings.login_title')}} | {{trans('strings.applicationName')}}  </title>      
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        
        <link rel="icon" href="/img/logos/neelain-ico.gif" type="image/x-icon" />
        <!-- END META SECTION -->
        
        <!-- CSS INCLUDE -->   
        @if(Session::get('lang') == 'en')     
            <link rel="stylesheet" type="text/css" id="theme" href="{{asset('css/theme-default.css')}}"/>
        @elseif(Session::get('lang') == 'ar')
            <link rel="stylesheet" type="text/css" id="theme" href="{{asset('css/theme-default-ar.css')}}"/>
        @endif
        <!-- EOF CSS INCLUDE -->    
        
        <style type="text/css">
            @font-face{
                font-family: Noto Kufi Arabic;
                src: url(/fonts/NotoKufiArabic-Regular.ttf);
            }
            body{
                font-family: 'Noto Kufi Arabic', 'Ruda', sans-serif;
                font-size:12px;
            }
        </style>                              
    </head>                                
    </head>
    <body>
        
        <div class="login-container lightmode">
        
            <div class="login-box animated fadeInDown">
                <!-- <div class="login-logo" style="height: 75px; background-color: white">
                </div>
                <hr/> -->
                <div style="text-align: center;background-color: inherit; width: 100%;font-size: 20px;margin-bottom: 10px;padding: 10px;font-weight: bolder;font-family: inherit;">{{trans('strings.applicationName')}}</div>
                <div class="login-body">
                    <div class="login-title" style="text-align: center;">{!!trans('strings.welcom_message')!!}
                    <form action="{{ route('login') }}" class="form-horizontal" method="post">
                        @csrf
                        <div class="form-group">
                            <div class="col-md-12">
                                <input type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="{{trans('strings.email')}}" name="email" value="{{ old('email') }}" required autofocus/>

                                 @if ($errors->has('email'))
                                    <span style="margin-top: 10px" class="alert alert-danger" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif

                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-12">
                                <input type="password" placeholder="{{trans('strings.password')}}" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required/>

                                @if ($errors->has('password'))
                                    <span style="margin-top: 10px" class="alert alert-danger" class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <!-- <div class="form-group row text-center">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check" style="color: silver">
                                    <label class="check" for="remember">
                                            <input class="icheckbox" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                        {{trans('strings.remember')}}
                                    </label>
                                </div>
                            </div>
                        </div> -->
                        <div class="form-group">
                            <div class="col-md-6">
                                <a href="{{ route('password.request') }}" class="btn btn-link btn-block">{{trans('strings.forgot_password')}}</a>
                            </div>
                            <div class="col-md-6">
                                <button class="btn btn-info btn-block">{{trans('strings.login_btn')}}</button>
                            </div>
                        </div>
                        <div class="login-or">OR</div>
                    <div class="form-group">
                        <div class="col-md-4">
                            <button class="btn btn-info btn-block btn-twitter"><span class="fa fa-twitter"></span> Twitter</button>
                        </div>
                        <div class="col-md-4">
                            <button class="btn btn-info btn-block btn-facebook"><span class="fa fa-facebook"></span> Facebook</button>
                        </div>
                        <div class="col-md-4">                            
                            <button class="btn btn-info btn-block btn-google"><span class="fa fa-google-plus"></span> Google</button>
                        </div>
                    </div>
                    <div class="login-subtitle">
                        {{trans('strings.Dont have an account yet?')}} <a href="{{ route('register') }}">{{trans('strings.Create an account')}}</a>
                    </div>
                    </form>
                    
                </div>
                <div class="login-footer">
                    <div class="row">
                        <div class="col-sm-5">
                            <div class=" pull-left">
                                &copy;  2019<!-- {{Carbon\Carbon::now()->format('Y')}} --> {{trans('strings.developer')}}
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class=" text-center">
                                <span class="xn-icon-button ">
                                    <a href="/lang"><span class="text-center fa fa-globe">&nbsp;&nbsp;{{trans('strings.language')}}</a>                        
                                </span>
                            </div>
                        </div>
                        <div class="col-sm-5">
                            <div class="pull-right">
                                <a href="#">{{trans('strings.about')}}</a> |
                                <a href="#">{{trans('strings.contact_us')}}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
        
        <!-- END MESSAGE BOX-->

        <!-- START PRELOADS -->
        <audio id="audio-alert" src="audio/alert.mp3" preload="auto"></audio>
        <audio id="audio-fail" src="audio/fail.mp3" preload="auto"></audio>
        <!-- END PRELOADS -->             
        
    <!-- START SCRIPTS -->
        <!-- START PLUGINS -->
        <script type="text/javascript" src="js/plugins/jquery/jquery.min.js"></script>
        <script type="text/javascript" src="js/plugins/jquery/jquery-ui.min.js"></script>
        <script type="text/javascript" src="js/plugins/bootstrap/bootstrap.min.js"></script>                
        <!-- END PLUGINS -->
        
        <!-- THIS PAGE PLUGINS -->
        <script type='text/javascript' src='js/plugins/icheck/icheck.min.js'></script>
        <script type="text/javascript" src="js/plugins/mcustomscrollbar/jquery.mCustomScrollbar.min.js"></script>
        
        <script type="text/javascript" src="js/plugins/bootstrap/bootstrap-datepicker.js"></script>
        <script type="text/javascript" src="js/plugins/bootstrap/bootstrap-timepicker.min.js"></script>
        <script type="text/javascript" src="js/plugins/bootstrap/bootstrap-colorpicker.js"></script>
        <script type="text/javascript" src="js/plugins/bootstrap/bootstrap-file-input.js"></script>
        <script type="text/javascript" src="js/plugins/bootstrap/bootstrap-select.js"></script>
        <script type="text/javascript" src="js/plugins/tagsinput/jquery.tagsinput.min.js"></script>
        <!-- END THIS PAGE PLUGINS -->       
        
        <!-- START TEMPLATE -->
        <script type="text/javascript" src="js/settings.js"></script>
        
        <script type="text/javascript" src="js/plugins.js"></script>        
        <script type="text/javascript" src="js/actions.js"></script>        
        <!-- END TEMPLATE -->
    <!-- END SCRIPTS -->   
    </body>
</html>






