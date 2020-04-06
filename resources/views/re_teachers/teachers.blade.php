@php
    $lang = Session::get('lang');
    \App::setLocale($lang);
@endphp
@extends('layouts.report')
@section('title'){{trans('strings.print')}} {{trans("strings.teacher-table-title")}}
@endsection


@section("content")

    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="" style="text-align: center">  {{trans('teacher.teachers')}}
                @if($request->university_id) - {{\App\University::find($request->university_id)->name}} @endif
                @if($request->college_id) - {{\App\College::find($request->college_id)->name}} @endif
                @if($request->depart_id) - {{\App\Department::find($request->depart_id)->name}} @endif
                @if($request->special_id) - {{\App\Special::find($request->special_id)->name}} @endif
                @if($request->degree_id) - {{\App\Degree::find($request->degree_id)->name}} @endif
                @if($request->value) - {{$request->value}} @endif
            </h4>
        </div>
        <div class="panel-body">
            <table class="table datatable">
                <thead>
                <tr>
                    <th>{{trans('strings.ID')}}</th>
                    <th>{{trans('teacher.AR_Name')}}</th>
                    <th>{{trans('teacher.en_name')}}</th>
                    <th>{{trans('teacher.card_id')}}</th>
                    <th>{{trans('teacher.dob')}}</th>
                    <th>{{trans('teacher.pob')}}</th>
                    <th>{{trans('teacher.gender')}}</th>
                    <th>{{trans('teacher.status')}}</th>
                    <th>{{trans('teacher.mother_tounge')}}</th>
                    <th>{{trans('teacher.national_id')}}</th>
                    <th>{{trans('teacher.tr_degree')}}</th>
                </tr>
                </thead>
                <tbody>
                @foreach($teachers as $teacher)
                    <tr>
                        <td>{{$loop -> index+1}}</td>
                        <td>{{$teacher->ar_name}}</td>
                        <td>{{$teacher->en_name}}</td>
                        <td>{{$teacher->card_id}}</td>
                        <td>{{$teacher->dob}}</td>
                        <td>{{$teacher->pob}}</td>

                        <td>
                            @if($teacher->gender == 1)
                                {{trans('teacher.gender_m')}}
                            @elseif($teacher->gender == 2)
                                {{trans('teacher.gender_f')}}
                            @endif
                        </td>

                        <td>@if($teacher->status == 1){{trans('teacher.Single')}}
                            @elseif($teacher->status == 2){{trans('teacher.Married')}}
                            @elseif($teacher->status == 3){{trans('teacher.Divorced')}}
                            @elseif($teacher->status == 4){{trans('teacher.widow')}}
                            @endif</td>

                        <td>@if($teacher->mother_tounge == 1){{trans('teacher.Arabic')}}
                            @elseif($teacher->mother_tounge == 2){{trans('teacher.English')}}
                            @elseif($teacher->mother_tounge == 3){{trans('teacher.French')}}
                            @elseif($teacher->mother_tounge == 4){{trans('teacher.German')}}
                            @elseif($teacher->mother_tounge == 5){{trans('teacher.Swahili')}}
                            @elseif($teacher->mother_tounge == 6){{trans('teacher.Italian')}}
                            @endif
                        </td>

                        <td>@if($teacher->countery) {{$teacher->countery}} @else {{$teacher->countreis->name}} @endif</td>
                        <td>@if($teacher->degree) {{$teacher->degree}} @else {{$teacher->degrees->name}} @endif</td>

                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection
