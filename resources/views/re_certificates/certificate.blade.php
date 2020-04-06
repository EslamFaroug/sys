@php
    $lang = Session::get('lang');
    \App::setLocale($lang);
@endphp
@extends('layouts.report')
@if($lang == 'ar')
@section('title') {{trans('strings.Qualifications & certificates')}} - {{$teacher->ar_name}}
@endsection
@elseif($lang == 'en')
@section('title') {{trans('strings.Qualifications & certificates')}} -  {{$teacher->en_name}}
@endsection
@endif

@section("content")
<div class="panel panel-default">
    <div class="panel-heading" style="text-align: center">
        @if($lang =='ar')
            <div >
                <h5 > {{trans('strings.Qualifications & certificates')}} - {{trans('strings.tr_data')}}{{$teacher->ar_name}}</h5>
            </div>
        @elseif($lang == 'en')
            <div >
                <h5 > {{trans('strings.Qualifications & certificates')}} - {{trans('strings.tr_data')}}{{$teacher->en_name}}</h5>
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
