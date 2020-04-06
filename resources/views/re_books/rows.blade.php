@php
    $lang = Session::get('lang');
    \App::setLocale($lang);
@endphp
@foreach($books as $book)
    <div class="col-md-3">
        <!-- CONTACT ITEM -->
        <div class="panel panel-default">
            <div class="panel-body profile">
                <div class="profile-data" style="margin-bottom: 10px">
                    <div class="profile-data-name" style="font-size: 12px">{{$book->title}}</div>
                </div>
                <div class="profile-image">
                    <img src="/assets/images/paper.png" alt="Nadia Ali"/>
                </div>
                <div class="profile-data">
                    <div class="profile-data-name">{{$book->ar_name}}</div>
                    <div class="profile-data-title">{{$book->en_name}}</div>
                </div>
                @if($lang == 'en')
                    <div class="profile-controls">
                        <a href="{{url('re_books/book/'.$book->book_id)}}" class="profile-control-right"><span class="fa fa-info"></span></a>
                        <a href="{{url('re_books/book/print/'.$book->book_id)}}" class="profile-control-left"><span class="fa fa-print"></span></a>

                    </div>
                @elseif($lang == 'ar')
                    <div class="profile-controls">
                        <a href="{{url('re_books/book/'.$book->book_id)}}" class="profile-control-left"><span class="fa fa-info"></span></a>
                        <a href="{{url('re_books/book/print/'.$book->book_id)}}" class="profile-control-right"><span class="fa fa-print"></span></a>
                    </div>
                @endif
            </div>
            <div class="panel-body">
                <div class="contact-info" style="font-size: 10px">
                    <p><small>{{trans('strings.degree-select-label')}} :</small> {{$book->degree}} </p>

                    <hr  style="margin-top: 0px; margin-bottom: 5px">

                    <p><small>{{trans('strings.book_isbn')}} :</small>  {{$book->isbn}}</p>
                    <p><small>{{trans('strings.book_publisher')}} :</small> {{$book->publisher}}</p>
                    <p><small>{{trans('strings.f_edition')}} :</small> {{$book->f_edition}}</p>
                </div>
            </div>

        </div>
        <!-- END CONTACT ITEM -->
    </div>
@endforeach
