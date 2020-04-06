@php
    $lang = Session::get('lang');
    \App::setLocale($lang);
@endphp
@extends('layouts.report')
@section('title'){{trans('strings.print')}} {{trans("strings.Books")}}
@endsection


@section("content")

    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="" style="text-align: center">  {{trans('strings.Books')}} - {{trans('teacher.teachers')}}
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
                    <th>{{trans('strings.book-input-label')}}</th>
                    <th>{{trans('strings.book_isbn')}}</th>
                    <th>{{trans('strings.book_publisher')}}</th>
                    <th>{{trans('strings.f_edition')}}</th>
                    <th>{{trans('strings.l_edition')}}</th>
                </tr>
                </thead>
                <tbody>
                @foreach($books as $book)
                    <tr>
                        <td>{{$loop -> index+1}}</td>
                        <td>{{$book->ar_name}}</td>
                        <td>{{$book -> title}}</td>
                        <td>{{$book -> isbn}}</td>
                        <td>{{$book -> publisher}}</td>
                        <td>{{$book -> f_edition}}</td>
                        <td>{{$book -> l_edition}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection
