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
        
        <link rel="icon" href="favicon.ico" type="image/x-icon" />
        <!-- END META SECTION -->
        
        <!-- CSS INCLUDE -->        
            <link rel="stylesheet" type="text/css" id="theme" href="{{asset('/css/theme-default-ar.css')}}"/>
       
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
        <div class="error-container">
            <div class="error-code" style="color: inherit;">404</div>
            <div class="error-text" style="color: red;">{{trans('strings.page not available')}}</div>
            <div class="error-subtext">{{trans('strings.Unfortunately')}}</div>
            <div class="error-actions">                                
                <div class="row">
                    <div class="col-md-6">
                        <button class="btn btn-info btn-block btn-lg" onClick="document.location.href = '/';">{{trans('strings.Back to dashboard')}}</button>
                    </div>
                    <div class="col-md-6">
                        <button class="btn btn-primary btn-block btn-lg" onClick="history.back();">{{trans('strings.Previous page')}}</button>
                    </div>
                </div>                                
            </div>
            <div class="error-subtext">{{trans('strings.need')}}</div>
            <div class="row">
                <div class="col-md-12">
                    <div class="input-group">
                        <input type="text" placeholder= {{trans('strings.search')}} class="form-control"/>
                        <div class="input-group-btn">
                            <button class="btn btn-primary"><span class="fa fa-search"></span></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>                 
    </body>
</html>






