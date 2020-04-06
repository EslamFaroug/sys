@php
    $lang = Session::get('lang');
    \App::setLocale($lang);
@endphp
@extends('layouts.report')
@section('title'){{trans('strings.print')}} {{trans("strings.teachers")}} - {{trans('strings.Experiences and Jobs')}}
@endsection


@section("content")

    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="" style="text-align: center"> {{trans('strings.Experiences and Jobs')}} - {{trans('teacher.teachers')}}

                @if($request->university_id) - {{\App\University::find($request->university_id)->name}} @endif
                @if($request->college_id) - {{\App\College::find($request->college_id)->name}} @endif
                @if($request->depart_id) - {{\App\Department::find($request->depart_id)->name}} @endif
                @if($request->special_id) - {{\App\Special::find($request->special_id)->name}} @endif
                @if($request->degree_id) - {{\App\Degree::find($request->degree_id)->name}} @endif
                @if($request->mangejob_id) - {{\App\Mangejob::find($request->mangejob_id)->name}} @endif
                @if($request->institute) - {{$request->institute}} @endif
                @if($request->exp_name) - {{$request->exp_name}} @endif
                @if($request->value) - {{$request->value}} @endif
            </h4>
        </div>
        <div class="panel-body">
            <table class="table datatable">
                <thead>
                <tr>
                    <th>{{trans('strings.ID')}}</th>
                    <th>{{trans('strings.tr_name')}}</th>
                    <th>{{trans('strings.job')}}</th>
                    <th>{{trans('strings.tr_exp_institute')}}</th>
                    <th>{{trans('strings.tr_countery')}}</th>
                    <th>{{trans('strings.work_type')}}</th>
                    <th>{{trans('strings.st_date')}}</th>
                    <th>{{trans('strings.end_date')}}</th>
                </tr>
                </thead>
                <tbody>
                @foreach($experiences as $experience)
                    <tr>

                        <td>{{$loop -> index+1}}</td>
                        <td>@if($experience->teacher_ar_name) {{$experience->teacher_ar_name}} @else {{$experience->teachers->ar_name}} @endif</td>

                        <td>
                            @if($experience->degree_id)
                                @if($experience->degree)  {{$experience->degree}} @else @if($experience->degree_id) {{$experience->degrees->name}} @endif @endif
                            @elseif($experience->mangejob_id)
                                @if($experience->mangejob)  {{$experience->mangejob}} @else @if($experience->mangejob_id) {{$experience->mangejobs->name}} @endif @endif
                            @elseif($experience->exp_name)
                                {{$experience->exp_name}}
                            @endif

                        </td>

                        <td>


                                @if($experience->degree_id)
                                    @if($experience->university)  {{$experience->university}} @else @if($experience->special_id) {{$experience->specials->departments->colleges->universities->name}} @endif @endif
                                @elseif($experience->mangejob_id)
                                    @if($experience->university)  {{$experience->university}} @else @if($experience->special_id) {{$experience->specials->departments->colleges->universities->name}} @endif @endif
                                @elseif($experience->exp_name)
                                    {{$experience->institute}}
                                @endif
                        </td>
                        <td>@if($experience->countery)  {{$experience->countery}} @else @if($experience->countery_id) {{$experience->countreis->name}} @endif @endif</td>
                        <td>@if($experience->work)  {{$experience->work}} @else @if($experience->work_id) {{$experience->work_types->name}} @endif @endif</td>
                        <td>{{$experience->start_date}}</td>
                        <td>{{$experience->end_date}}</td>


                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection
