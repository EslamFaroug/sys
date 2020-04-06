@php
    $lang = Session::get('lang');
    \App::setLocale($lang);
@endphp
@extends('layouts.report')
@if($lang == 'ar')
@section('title') {{trans('strings.contact information')}} - {{$teacher->ar_name}}
@endsection
@elseif($lang == 'en')
@section('title') {{trans('strings.contact information')}} -  {{$teacher->en_name}}
@endsection
@endif

@section("content")
<div class="panel panel-default">
    <div class="panel-heading" style="text-align: center">
        @if($lang =='ar')
            <div >
                <h5 > {{trans('strings.contact information')}} - {{trans('strings.tr_data')}}{{$teacher->ar_name}}</h5>
            </div>
        @elseif($lang == 'en')
            <div >
                <h5 > {{trans('strings.contact information')}} - {{trans('strings.tr_data')}}{{$teacher->en_name}}</h5>
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

        <div class="label label-primary" style="font-size: 12px;">{{trans('strings.contacts')}}</div>
        <br/>
        <br/>
        <table class="table table-bordered">
                    <thead>
                        <tr>
                        <th style="width:150px;">{{{trans('strings.email')}}}</th>
                        <td>@if($teacher->contacts->count()) {{$teacher->contacts[0]->email}} @endif</td>
                        </tr>
                        <tr>
                        <th>{{{trans('strings.tr-mobile')}}}</th>
                        <td>@if($teacher->contacts->count()) {{$teacher->contacts[0]->mobile_no}} @endif</td>
                        </tr>
                        <tr>
                        <th>{{trans('strings.tr_tel')}}</th>
                        <td>@if($teacher->contacts->count()) {{$teacher->contacts[0]->tel_no}} @endif</td>
                        </tr>
                        <tr>
                        <th>{{trans('strings.tr_home')}}</th>
                        <td>@if($teacher->contacts->count()) {{$teacher->contacts[0]->home_no}} @endif</td>
                        </tr>
                        <tr><th>{{trans('strings.tr_website')}}</th>
                        <td>@if($teacher->contacts->count()) {{$teacher->contacts[0]->tr_web}} @endif</td>
                        </tr>
                    </thead>
                </table>
        <div class="label label-primary" style="font-size: 12px;">{{trans('strings.address')}}</div>
        <br/>
        <br/>

        <table class="table table-bordered">

            <thead>
            <th>{{trans('strings.tr_countery')}}</th>
            <th>{{trans('strings.tr_state')}}</th>
            <th>{{trans('strings.tr_regional')}}</th>
            <th>{{trans('strings.tr_unit')}}</th>
            </thead>
            <tbody>

            @foreach($teacher->contacts as $contact)
                <tr>
                    <td>{{$contact->countreis->name}}</td>
                    <td>{{$contact->states->name}}</td>
                    <td>{{$contact->regionals->name}}</td>
                    <td>{{$contact->units->name}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="label label-primary" style="font-size: 12px;">{{trans('strings.place_work')}}</div>
        <br/>
        <br/>

        <table class="table table-bordered">

            <thead>

            <th>{{trans('strings.tr_university')}}</th>

            <th>{{trans('strings.tr_college')}}</th>

            <th>{{trans('strings.tr_department')}}</th>

            <th>{{trans('strings.tr_specialization')}}</th>
            </thead>
            <tbody>

            @foreach($teacher->contacts as $contact)
                <tr>
                    <td>{{$contact->universities->name}}</td>
                    <td>{{$contact->colleges->name}}</td>
                    <td>{{$contact->departments->name}}</td>
                    <td>{{$contact->specials->name}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>

    </div>
</div>
    @endsection
