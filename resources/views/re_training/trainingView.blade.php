@php
    $lang = Session::get('lang');
    \App::setLocale($lang);
@endphp

@extends('layouts.admin')
@if($lang == 'ar')
@section('title') {{trans('strings.Training and courses')}} - {{$teacher->ar_name}}
@endsection
@elseif($lang == 'en')
@section('title') {{trans('strings.Training and courses')}} -  {{$teacher->en_name}}
@endsection
@endif


<!-- @section('inner-title')
    {{trans('strings.countreis-title')}}
@endsection -->
@section('extra-plugins')

	<script type='text/javascript' src="{{asset('/js/plugins/icheck/icheck.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('/js/plugins/mcustomscrollbar/jquery.mCustomScrollbar.min.js')}}"></script>

    <script type="text/javascript" src="{{asset('/js/plugins/datatables/jquery.dataTables.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('/js/plugins/tableexport/tableExport.js')}}"></script>
	<script type="text/javascript" src="{{asset('/js/plugins/tableexport/jquery.base64.js')}}"></script>
	<script type="text/javascript" src="{{asset('/js/plugins/tableexport/html2canvas.js')}}"></script>
	<script type="text/javascript" src="{{asset('/js/plugins/tableexport/jspdf/libs/sprintf.js')}}"></script>
	<script type="text/javascript" src="{{asset('/js/plugins/tableexport/jspdf/jspdf.js')}}"></script>
	<script type="text/javascript" src="{{asset('/js/plugins/tableexport/jspdf/libs/base64.js')}}"></script>

	<script type='text/javascript' src="{{asset('/js/plugins/icheck/icheck.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('/js/plugins/mcustomscrollbar/jquery.mCustomScrollbar.min.js')}}"></script>

    <script type="text/javascript" src="{{asset('/js/plugins/blueimp/jquery.blueimp-gallery.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('/js/plugins/dropzone/dropzone.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('/js/plugins/icheck/icheck.min.js')}}"></script>

    <script type="text/javascript" src="{{asset('/js/plugins/fileinput/fileinput.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('/js/plugins/filetree/jqueryFileTree.js')}}"></script>

    <script type='text/javascript' src="{{('/js/plugins/icheck/icheck.min.js')}}"></script>
    <script type="text/javascript" src="{{('/js/plugins/mcustomscrollbar/jquery.mCustomScrollbar.min.js')}}"></script>

    <script type="text/javascript" src="{{('/js/plugins/datatables/jquery.dataTables.min.js')}}"></script>

    <style type="text/css">
        tr th {
            background-color: #aeaeae;
            width: 200px;
        }
        tr th+td {
            /*background-color: #e0e0e0;*/
            background-color: inherit;
        }
    </style>
@endsection

@section('javascript')
$(document).ready(function(){
});
@endsection

@section('contents')

                <!-- START BREADCRUMB -->
                <ul class="breadcrumb">

                    <li><a href="/">{{trans('strings.Home')}}</a></li>
                    <li><a href="/re_training/index">{{trans('strings.teachers')}} - {{trans('strings.Training and courses')}}</a></li>
                    @if($lang == 'ar')
                    <li class="active">{{$teacher->ar_name}}</li>
                    @elseif($lang == 'en')
                    <li class="active">{{$teacher->en_name}}</li>
                    @endif

                </ul>
                <div class="panel panel-default">
                <div class="panel-heading">
                    @if($lang =='ar')
                    <div class="panel-title-box">
                        <h2 class="panel-title">{{trans('strings.tr_data')}}{{$teacher->ar_name}}</h2>
                    </div>
                    @elseif($lang == 'en')
                    <div class="panel-title-box">
                        <h2 class="panel-title">{{trans('strings.tr_data')}}{{$teacher->en_name}}</h2>
                    </div>
                    @endif

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

        <div class="panel-body">
                <div class="label label-primary" style="font-size: 12px;">{{trans('strings.Basic information')}}</div>
                <br/>
                <br/>
                <table class="table table-bordered">

                    <thead>
                                    <tr>
                                        <th>{{trans('teacher.AR_Name')}}</th><td>{{$teacher->ar_name}}</td>
                                    </tr><tr>
                                        <th>{{trans('teacher.en_name')}}</th><td>{{$teacher->en_name}}</td>
                                    </tr>

                    </thead>
                </table>

            <div class="label label-primary" style="font-size: 12px;">{{trans('strings.train_title')}}</div>
            <br/>
            <br/>
            <table class="table table-bordered">
                <thead>
                <th>#</th>
                <th>{{trans('strings.title-input-label')}}</th>
                <th>{{trans('strings.institute-input-label')}}</th>
                <th>{{trans('strings.training place')}}</th>
                <th>{{trans('strings.track of training')}}</th>
                <th>{{trans('strings.from_date')}}</th>
                <th>{{trans('strings.final_date')}}</th>
                </thead>
                <tbody>
                @foreach($teacher->trains as $train)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$train -> title}}</td>
                        <td>{{$train -> institute}}</td>
                        <td>{{$train->countreis->name}}</td>
                        <td>{{$train->specials->name}}</td>
                        <td>{{$train -> st_date}}</td>
                        <td>{{$train -> end_date}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>

        </div>
    </div>

@endsection
