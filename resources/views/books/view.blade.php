@php
    $lang = Session::get('lang');
    \App::setLocale($lang);
@endphp

<input type="hidden" name="book_id" value="{{$book->book_id}}">

<div class="row">
    <label class="col-md-2 control-label">{{trans('strings.t_name')}}</label>
        <div class="col-md-10">
            @if($lang == 'ar')
                {{$book->teachers->ar_name}}
            @else
                {{$book->teachers->en_name}}
            @endif
        </div>
</div>
<div class="row">
    <label class="col-md-2 control-label">{{trans('strings.book-input-label')}}</label>
    <div class="col-md-10">
        {{$book->title}}
    </div>
</div>
<div class="row">
<label class="col-md-2 control-label">{{trans('strings.book-input-isbn')}}</label>
    <div class="col-md-10">
        {{$book->isbn}}
    </div>
</div>
<div class="row">
<label class="col-md-2 control-label">{{trans('strings.book-input-publish')}}</label>
    <div class="col-md-10">
        {{$book->publisher}}
    </div>
</div>
<div class="row">
    <label class="col-md-2 control-label">{{trans('strings.f_edition')}}</label>
        <div class="col-md-10">
            {{$book->f_edition}}
        </div>
</div>
<div class="row">
    <label class="col-md-2 control-label">{{trans('strings.l_edition')}}</label>
        <div class="col-md-10">
            {{$book->l_edition}}
        </div>
</div>



<div class="row">
    <label class="col-md-2 col-lg-2 col-sm-2 col-xs-2 control-label">{{trans('strings.paper_file')}}</label>
    <div class="col-lg-10 col-md-10 col-sm-10 col-xs-10">
        <a target="_blank" class="btn btn-link" href="{{asset($book->book_file)}}"><i class="fa fa-link"></i> {{$book->title}}</a>
    </div>
</div>
