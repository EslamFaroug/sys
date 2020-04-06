@php
    $lang = Session::get('lang');
    \App::setLocale($lang);
@endphp
@extends('layouts.report')
@section('title'){{trans('strings.print')}} {{trans("strings.teachers")}} - {{trans('strings.Training and courses')}}
@endsection


@section("content")

    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="" style="text-align: center"> {{trans('strings.Training and courses')}} - {{trans('teacher.teachers')}}


                @if($request->country_id) - {{\App\Countery::find($request->country_id)->name}} @endif
                @if($request->trainuing_field) - {{\App\Special::find($request->trainuing_field)->name}} @endif
                @if($request->university_id) - {{\App\University::find($request->university_id)->name}} @endif
                @if($request->college_id) - {{\App\College::find($request->college_id)->name}} @endif
                @if($request->depart_id) - {{\App\Department::find($request->depart_id)->name}} @endif
                @if($request->special_id) - {{\App\Special::find($request->special_id)->name}} @endif
                @if($request->institute) - {{$request->institute}} @endif
                @if($request->title) - {{$request->title}} @endif
                @if($request->value) - {{$request->value}} @endif

            </h4>
        </div>
        <div class="panel-body">
            <table class="table datatable">
                <thead>
                <tr>
                    <th>{{trans('strings.ID')}}</th>
                    <th>{{trans('strings.tr_sk_name')}}</th>
                    <th>{{trans('strings.title-input-label')}}</th>
                    <th>{{trans('strings.institute-input-label')}}</th>
                    <th>{{trans('strings.training place')}}</th>
                    <th>{{trans('strings.track of training')}}</th>
                    <th>{{trans('strings.from_date')}}</th>
                    <th>{{trans('strings.final_date')}}</th>
                </tr>
                </thead>
                <tbody>
                @foreach($trainings as $train)
                    <tr>

                        <td>{{$loop -> index+1}}</td>
                        <td>@if($train->teacher_ar_name) {{$train->teacher_ar_name}} @else {{$train->teachers->ar_name}}  @endif</td>
                        <td>{{$train -> title}}</td>
                        <td>{{$train -> institute}}</td>
                        <td>@if($train->countery)  {{$train->countery}} @else @if($train->countery_id) {{$train->countreis->name}} @endif @endif</td>
                        <td>@if($train->special)  {{$train->special}} @else @if($train->special_id) {{$train->specials->name}} @endif @endif</td>
                        <td>{{$train -> st_date}}</td>
                        <td>{{$train -> end_date}}</td>


                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection
