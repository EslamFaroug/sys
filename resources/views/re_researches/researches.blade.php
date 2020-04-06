@php
    $lang = Session::get('lang');
    \App::setLocale($lang);
@endphp
@extends('layouts.report')
@section('title'){{trans('strings.print')}} {{trans("strings.Scientific Research")}}
@endsection


@section("content")

    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="" style="text-align: center">  {{trans('strings.Scientific Research')}} - {{trans('teacher.teachers')}}
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
                    <th>{{trans('teacher.tr_degree')}}</th>
                    <th>{{trans('strings.trr_supper')}}</th>
                    <th>{{trans('strings.publish_place')}}</th>
                    <th>{{trans('strings.publis_date')}}</th>
                </tr>
                </thead>
                <tbody>
                @foreach($researches as $research)
                    <tr>
                        <td>{{$loop -> index+1}}</td>
                        <td>{{$research->ar_name}}</td>
                        <td>{{$research -> title}}</td>
                        <td>{{$research->degree}}</td>
                        <td>
                            @if($research->supervisor_id !== null)

                                    @if($research->supervisor_id)

                                        {{\App\Teacher::find($research->supervisor_id)->ar_name}}
                                    @endif

                            @else
                                {{$research ->other_supervisor}}
                            @endif
                        </td>
                        <td>{{$research -> publish_place}}</td>
                        <td>{{$research -> publish_date}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection
