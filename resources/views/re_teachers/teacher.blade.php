@php
    $lang = Session::get('lang');
    \App::setLocale($lang);
@endphp
@extends('layouts.report')
@if($lang == 'ar')
@section('title') {{$teacher->ar_name}}
@endsection
@elseif($lang == 'en')
@section('title') {{$teacher->en_name}}
@endsection
@endif

@section("content")
<div class="panel panel-default">
    <div class="panel-heading" style="text-align: center">
        @if($lang =='ar')
            <div >
                <h4 >{{trans('strings.tr_data')}}{{$teacher->ar_name}}</h4>
            </div>
        @elseif($lang == 'en')
            <div >
                <h2 >{{trans('strings.tr_data')}}{{$teacher->en_name}}</h2>
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
            </tr><tr>
                <th>{{trans('teacher.card_id')}}</th><td>{{$teacher->card_id}}</td>
            </tr><tr>
                <th>{{trans('teacher.dob')}}</th><td>{{$teacher->dob}}</td>
            </tr><tr>
                <th>{{trans('teacher.pob')}}</th><td>{{$teacher->pob}}</td>
            </tr><tr>
                <th>{{trans('teacher.gender')}}</th><td>{{$genders[$teacher->gender]}}</td>
            </tr><tr>
                <th>{{trans('teacher.status')}}</th><td>{{$status[$teacher->status]}}</td>
            </tr><tr>
                <th>{{trans('teacher.mother_tounge')}}</th><td>@if($teacher->mother_tounge == 1){{trans('teacher.Arabic')}}
                    @elseif($teacher->mother_tounge == 2){{trans('teacher.English')}}
                    @elseif($teacher->mother_tounge == 3){{trans('teacher.French')}}
                    @elseif($teacher->mother_tounge == 4){{trans('teacher.German')}}
                    @elseif($teacher->mother_tounge == 5){{trans('teacher.Swahili')}}
                    @elseif($teacher->mother_tounge == 6){{trans('teacher.Italian')}}
                    @endif
                </td>
            </tr><tr>
                <th>{{trans('teacher.national_id')}}</th><td>{{$teacher->countreis->name}}</td>
            </tr><tr>
                <th>{{trans('strings.degree-table-title')}}</th><td>{{$teacher->degrees->name}}</td>
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
        <div class="label label-primary" style="font-size: 12px;">{{trans('strings.exp_title')}}</div>
        <br/>
        <br/>
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>#</th>
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
            @if($teacher->experiences->count())
                @foreach($teacher->experiences as $experienc)
                    <tr>
                        <td>{{$loop -> index+1}}</td>
                        <td>{{$experienc->teachers->ar_name}}</td>

                        <td>
                            @if($experienc->degree_id)
                                {{$experienc->degrees->name}}
                            @elseif($experienc->mangejob_id)
                                {{$experienc->mangejobs->name}}
                            @elseif($experienc->exp_name)
                                {{$experienc->exp_name}}
                            @endif
                        </td>

                        <td>
                            @if($experienc->degree_id)
                                {{$experienc->universities->name}}
                            @elseif($experienc->mangejob_id)
                                {{$experienc->universities->name}}
                            @elseif($experienc->exp_name)
                                {{$experienc->institute}}
                            @endif
                        </td>
                        <td>{{$experienc->countreis->name}}</td>
                        <td>{{$experienc->work_types->name}}</td>
                        <td>{{$experienc->start_date}}</td>
                        <td>{{$experienc->end_date}}</td>

                    </tr>
                @endforeach
            @endif
            </tbody>
        </table>

        <div class="label label-primary" style="font-size: 12px;">{{trans('strings.skill_title')}}</div>
        <br/>
        <br/>
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>#</th>
                <th>{{trans('strings.skill_name')}}</th>
                <th>{{trans('strings.skill_desc')}}</th>
            </tr>
            </thead>
            <tbody>
            @foreach($teacher->skills as $skill)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$skill -> name}}</td>
                    <td>{{$skill -> decription}}</td>

                </tr>
            @endforeach
            </tbody>
        </table>

        <div class="label label-primary" style="font-size: 12px;">{{trans('strings.train_title')}}</div>
        <br/>
        <br/>
        <table class="table table-bordered">
            <thead>
            <th>#</th>
            <th>{{trans('strings.title-input-label')}}</th>
            <th>{{trans('strings.institute-input-label')}}</th>
            <th>{{trans('strings.training place')}}</th>
            <th>{{trans('strings.track of training')}}</th>
            <th>{{trans('strings.from_date')}}</th>
            <th>{{trans('strings.final_date')}}</th>
            </thead>
            <tbody>
            @foreach($teacher->trains as $train)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$train -> title}}</td>
                    <td>{{$train -> institute}}</td>
                    <td>{{$train->countreis->name}}</td>
                    <td>{{$train->specials->name}}</td>
                    <td>{{$train -> st_date}}</td>
                    <td>{{$train -> end_date}}</td>
                </tr>
            @endforeach
            </tbody>
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

            @foreach($teacher->papers as $paper)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$paper -> title}}</td>
                    <td>{{$paper -> publish_place}}</td>
                    <td>{{$paper -> publis_date}}</td>
                    <td>{{$paper -> volume_no}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>

        <div class="label label-primary" style="font-size: 12px;">{{trans('strings.research_title')}}</div>
        <br/>
        <br/>
        <table class="table table-bordered">

            <thead>
            <th>#</th>
            <th>{{trans('strings.pa_title')}}</th>
            <th>{{trans('teacher.tr_degree')}}</th>
            <th>{{trans('strings.publish_place')}}</th>
            <th>{{trans('strings.publis_date')}}</th>

            </thead>
            <tbody>

            @foreach($teacher->researches as $research)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$research -> title}}</td>
                    <td>{{$research ->degrees-> name}}</td>
                    <td>{{$research ->publish_place}}</td>
                    <td>{{$research ->publish_date}}</td>
                </tr>
            @endforeach
            </tbody>
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
            </tbody>
        </table>

        <div class="label label-primary" style="font-size: 12px;">{{trans('strings.re_conf_title')}}</div>
        <br/>
        <br/>
        <table class="table table-bordered">

            <thead>
            <th>#</th>
            <th>{{trans('strings.conf_nane')}}</th>
            <th>{{trans('strings.St_country')}}</th>
            <th>{{trans('strings.re_state')}}</th>
            <th>{{trans('strings.conf_date')}}</th>
            <th>{{trans('strings.participant_type')}}</th>
            </thead>
            <tbody>
            @foreach($teacher->conferences as $conf)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$conf->name}}</td>
                    <td>{{$conf->countreis->name}}</td>
                    <td>{{$conf->states->name}}</td>
                    <td>{{$conf->conf_date}}</td>
                    <td>
                        @if($conf->participant == 1)
                            {{trans('strings.member')}}
                        @elseif($conf->participant == 2)
                            {{trans('strings.participants')}}
                        @endif
                    </td>

                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="label label-primary" style="font-size: 12px;">{{trans('strings.interest_title')}}</div>
        <br/>
        <br/>
        <table class="table table-bordered">

            <thead>
            <th>#</th>
            <th>{{trans('strings.interest-input-label')}}</th>
            <th>{{trans('strings.descrip-input-int')}}</th>
            </thead>
            <tbody>

            @foreach($teacher->interests as $interest)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$interest -> title}}</td>
                    <td>{{$interest -> descrip}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
    @endsection
