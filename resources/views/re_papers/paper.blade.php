@php
    $lang = Session::get('lang');
    \App::setLocale($lang);
@endphp
@extends('layouts.report')
@if($lang == 'ar')
@section('title') {{trans('strings.paper_title')}} - {{$teacher->ar_name}}
@endsection
@elseif($lang == 'en')
@section('title') {{trans('strings.paper_title')}} -  {{$teacher->en_name}}
@endsection
@endif

@section("content")
    <div class="panel panel-default">
        <div class="panel-heading" style="text-align: center">
            @if($lang =='ar')
                <div >
                    <h5 > {{trans('strings.paper_title')}} - {{trans('strings.tr_data')}}{{$teacher->ar_name}}</h5>
                </div>
            @elseif($lang == 'en')
                <div >
                    <h5 > {{trans('strings.paper_title')}} - {{trans('strings.tr_data')}}{{$teacher->en_name}}</h5>
                </div>
            @endif


        </div>

        <div class="panel-body">
            <div class="label label-primary" style="font-size: 12px;">{{trans('strings.Basic information')}}</div>
            <br/>
            <br/>

            <table class="table table-bordered">

                <thead>
                <tr>
                    <th style="width:150px;">{{trans('teacher.AR_Name')}}</th><td>{{$teacher->ar_name}}</td>
                </tr><tr>
                    <th>{{trans('teacher.en_name')}}</th><td>{{$teacher->en_name}}</td>
                </tr>

                </thead>
            </table>

            <div class="label label-primary" style="font-size: 12px;">{{trans('strings.paper_title')}}</div>
            <br/>
            <br/>
            <table class="table table-bordered">

                <thead>
                <th>#</th>
                <th>{{trans('strings.pa_title')}}</th>
                <th>{{trans('strings.publish_place')}}</th>
                <th>{{trans('strings.publis_date')}}</th>
                <th>{{trans('strings.volume_no')}}</th>
                </thead>
                <tbody>
                @if($teacher->papers->count())

                    @foreach($teacher->papers as $paper)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$paper -> title}}</td>
                            <td>{{$paper -> publish_place}}</td>
                            <td>{{$paper -> publis_date}}</td>
                            <td>{{$paper -> volume_no}}</td>
                        </tr>
                    @endforeach
                @endif

                </tbody>
            </table>

        </div>
    </div>
@endsection
