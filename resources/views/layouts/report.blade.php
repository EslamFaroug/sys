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
    <script>
        window.print();
        setTimeout(function () {
            history.back();
        },3000)
    </script>
</head>
<body>
@yield("content")
</body>
</html>