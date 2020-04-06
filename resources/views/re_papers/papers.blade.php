@php
    $lang = Session::get('lang');
    \App::setLocale($lang);
@endphp
@extends('layouts.report')
@section('title'){{trans('strings.print')}} {{trans("strings.paper_title")}}
@endsection


@section("content")

    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="" style="text-align: center">  {{trans('strings.paper_title')}} - {{trans('teacher.teachers')}}
                @if($request->university_id) - {{\App\University::find($request->university_id)->name}} @endif
                @if($request->college_id) - {{\App\College::find($request->college_id)->name}} @endif
                @if($request->depart_id) - {{\App\Department::find($request->depart_id)->name}} @endif
                @if($request->special_id) - {{\App\Special::find($request->special_id)->name}} @endif
                @if($request->degreel_id) - {{\App\Degree::find($request->degreel_id)->name}} @endif
                @if($request->title) - {{$request->title}} @endif
                @if($request->value) - {{$request->value}} @endif
                @if($request->date) - {{$request->date}} @endif
            </h4>
        </div>
        <div class="panel-body">
            <table class="table datatable">
                <thead>
                <tr>
                    <th>{{trans('strings.ID')}}</th>
                    <th>{{trans('strings.tr_sk_name')}}</th>
                    <th>{{trans('strings.pa_title')}}</th>
                    <th>{{trans('strings.publish_place')}}</th>
                    <th>{{trans('strings.publis_date')}}</th>
                    <th>{{trans('strings.volume_no')}}</th>
                </tr>
                </thead>
                <tbody>
                @foreach($papers as $paper)
                    <tr>
                        <td>{{$loop -> index+1}}</td>
                        <td>{{$paper->ar_name}}</td>
                        <td>{{$paper -> title}}</td>
                        <td>{{$paper -> publish_place}}</td>
                        <td>{{$paper -> publis_date}}</td>
                        <td>{{$paper -> volume_no}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection
