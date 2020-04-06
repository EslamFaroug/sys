@php
    $lang = Session::get('lang');
    \App::setLocale($lang);
@endphp
@extends('layouts.report')
@if($lang == 'ar')
@section('title') {{trans('strings.Books')}} - {{$teacher->ar_name}}
@endsection
@elseif($lang == 'en')
@section('title') {{trans('strings.Books')}} -  {{$teacher->en_name}}
@endsection
@endif

@section("content")
    <div class="panel panel-default">
        <div class="panel-heading" style="text-align: center">
            @if($lang =='ar')
                <div >
                    <h5 > {{trans('strings.Books')}} - {{trans('strings.tr_data')}}{{$teacher->ar_name}}</h5>
                </div>
            @elseif($lang == 'en')
                <div >
                    <h5 > {{trans('strings.Books')}} - {{trans('strings.tr_data')}}{{$teacher->en_name}}</h5>
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

            <div class="label label-primary" style="font-size: 12px;">{{trans('strings.book_title')}}</div>
            <br/>
            <br/>
            <table class="table table-bordered">

                <thead>
                <th>#</th>
                <th>{{trans('strings.book-input-label')}}</th>
                <th>{{trans('strings.book_publisher')}}</th>
                <th>{{trans('strings.f_edition')}}</th>
                <th>{{trans('strings.l_edition')}}</th>
                <th>{{trans('strings.book_isbn')}}</th>

                </thead>
                <tbody>
                @if($teacher->books->count())

                    @foreach($teacher->books as $book)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$book -> title}}</td>
                            <td>{{$book -> publisher}}</td>
                            <td>{{$book -> f_edition}}</td>
                            <td>{{$book -> l_edition}}</td>
                            <td>{{$book -> isbn}}</td>
                        </tr>
                    @endforeach
                @endif

                </tbody>
            </table>

        </div>
    </div>
@endsection
