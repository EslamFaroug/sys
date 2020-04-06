@php
    $lang = Session::get('lang');
    \App::setLocale($lang);
@endphp

@extends('layouts.admin')
@if($lang == 'ar')
@section('title') {{trans('strings.Qualifications & certificates')}} - {{$teacher->ar_name}}
@endsection
@elseif($lang == 'en')
@section('title') {{trans('strings.Qualifications & certificates')}} -  {{$teacher->en_name}}
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
                    <li><a href="/re_certificates/index">{{trans('strings.teachers')}} - {{trans('strings.Qualifications & certificates')}}</a></li>
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

            <div class="label label-primary" style="font-size: 12px;">{{trans('strings.certificates')}}</div>
            <br/>
            <br/>

            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>#</th>
                    <th>{{trans('strings.sert_name')}}</th>
                    <th>{{trans('strings.degree-table-title')}}</th>
                    <th>{{trans('strings.tr_university')}}</th>
                    <th>{{trans('strings.tr_college')}}</th>
                    <th>{{trans('strings.tr_department')}}</th>
                    <th>{{trans('strings.tr_specialization')}}</th>
                    <th>{{trans('strings.tr_countery')}}</th>
                    <th>{{trans('strings.study_type')}}</th>
                    <th>{{trans('strings.sert_date')}}</th>
                    <th>{{trans('strings.sert_grad')}}</th>
                </tr>
                </thead>
                <tbody>

                @foreach($teacher->certificates as $certificat)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$certificat->cert_name}}</td>
                        <td>{{$certificat->degrees->name}}</td>
                        <td>{{$certificat->universities->name}}</td>
                        <td>{{$certificat->colleges->name}}</td>
                        <td>{{$certificat->departments->name}}</td>
                        <td>{{$certificat->specials->name}}</td>
                        <td>{{$certificat->countreis->name}}</td>
                        <td>{{$certificat->studes->name}}</td>
                        <td>{{$certificat->cert_date}}</td>
                        <td>{{$certificat->sert_grade}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection
