@php
    $lang = Session::get('lang');
    \App::setLocale($lang);
@endphp

@extends('layouts.admin')

@section('title') {{trans('strings.book_title')}}
@endsection

@section('extra-plugins')

	<script type='text/javascript' src="{{asset('/js/plugins/icheck/icheck.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('/js/plugins/mcustomscrollbar/jquery.mCustomScrollbar.min.js')}}"></script>

    <script type="text/javascript" src="{{asset('/js/plugins/datatables/jquery.dataTables.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('/js/plugins/tableexport/tableExport.js')}}"></script>
	<script type="text/javascript" src="{{asset('/js/plugins/tableexport/jquery.base64.js')}}"></script>
	<script type="text/javascript" src="{{asset('/js/plugins/tableexport/html2canvas.js')}}"></script>
	<script type="text/javascript" src="{{asset('/js/plugins/tableexport/jspdf/libs/sprintf.js')}}"></script>
	<script type="text/javascript" src="{{asset('/js/plugins/tableexport/jspdf/jspdf.js')}}"></script>
	<script type="text/javascript" src="{{asset('/js/plugins/tableexport/jspdf/libs/base64.js')}}"></script>

	<script type='text/javascript' src="{{asset('/js/plugins/icheck/icheck.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('/js/plugins/mcustomscrollbar/jquery.mCustomScrollbar.min.js')}}"></script>

    <script type="text/javascript" src="{{asset('/js/plugins/blueimp/jquery.blueimp-gallery.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('/js/plugins/dropzone/dropzone.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('/js/plugins/icheck/icheck.min.js')}}"></script>

    <script type="text/javascript" src="{{asset('/js/plugins/fileinput/fileinput.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('/js/plugins/filetree/jqueryFileTree.js')}}"></script>

    <script type='text/javascript' src="{{('/js/plugins/icheck/icheck.min.js')}}"></script>
    <script type="text/javascript" src="{{('/js/plugins/mcustomscrollbar/jquery.mCustomScrollbar.min.js')}}"></script>
    <script type="text/javascript" src="{{('/js/plugins/datatables/jquery.dataTables.min.js')}}"></script>
    <script type='text/javascript' src="{{('/js/plugins/bootstrap/bootstrap-datepicker.js')}}"></script>
    <script>

        function destroy_books(id) {
            $.ajax({
                url: "{{url('/books/destroy')}}/"+id,
                type: 'POST',
                data: '_token={{csrf_token()}}',
                success: function(res) {
                    refersh();
                }
            });
        }
        $("#update-books").submit(function(event){
            event.preventDefault();
            var form = $(this)[0];
            var formData = new FormData(form);
            $.ajax({
                url: "{{url('/books/update')}}/"+form['book_id'].value,
                data: formData,
                type: 'POST',
                contentType: false,
                processData: false,
                success: function(data) {
                    if(data == 'done') {
                        document.location.reload();
                    }
                },error: function (errr, exp) {
                    var list = "";
                    $.each(errr.responseJSON.errors, function (index, v) {
                        alert(v);
                    });
                }
            });

        });

        function update_books(id) {
            $.ajax({
                url: '/books/edit/'+id,
                type: 'POST',
                data: '_token={{csrf_token()}}',
                success: function(res) {
                    $('#modal-update-books-form-form').html(res);
                    $("#editBookModal").modal();
                }
            });
        }
        function view_books(id) {
            $.ajax({
                url: '/books/view/'+id,
                type: 'POST',
                data: '_token={{csrf_token()}}',
                success: function(res) {
                    $('#modal-view-books').html(res);
                    $("#viewBookModal").modal();
                }
            });
        }

        function refersh() {
            document.location.href = document.location.href;
        }

    </script>

@endsection

@section('javascript')
    $(document).ready(function(){
});
@endsection

@section('contents')
         <!-- Start Delete Alert -->

    <div class="message-box animated fadeIn" data-sound="alert" id="delete_papers">
        <div class="mb-container">
            @if($lang == 'ar')
            <div class="mb-middle pull-right">
                <div class="mb-title"><span class="fa fa-sign-out"></span> {{trans('strings.delete')}}<strong>{{trans('strings.book_del')}}</strong> ! </div>
                <div class="mb-content">
                    <p>{{trans('strings.delete-alert-message-prompt-book')}}</p>
                    <p>{{trans('strings.delete-alert-message-hint')}}.</p>
                </div>
                <div class="mb-footer">
                    <div class="pull-right">
                        <button id="confirm_delete_books" data="" onclick='destroy_books($(this).attr("data"))'  class="btn btn-success btn-lg">{{trans('strings.yes')}}</button>
                        <button class="btn btn-default btn-lg mb-control-close">{{trans('strings.no')}}</button>
                    </div>
                </div>
            </div>
            @elseif($lang == 'en')
            <div class="mb-middle">
                <div class="mb-title"><span class="fa fa-sign-out"></span> {{trans('strings.delete')}} <strong>{{trans('strings.book_del')}}</strong> ?</div>
                <div class="mb-content">
                    <p>{{trans('strings.delete-alert-message-prompt-book')}}</p>
                    <p>{{trans('strings.delete-alert-message-hint')}}.</p>
                </div>
                <div class="mb-footer">
                    <div class="pull-right">
                        <button id="confirm_delete_books" data="" onclick='destroy_books($(this).attr("data"))'  class="btn btn-success btn-lg">{{trans('strings.yes')}}</button>
                        <button class="btn btn-default btn-lg mb-control-close">{{trans('strings.no')}}</button>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
    <!-- End Delete Alert -->

    <!-- Start Modal Frame -->
    <form id='store-books' action="/books/store" method="post" enctype="multipart/form-data" class="form-horizontal" role="form">
        <div class="modal fade" id="addBookModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle"> {{trans('strings.add-new')}} : {{trans('strings.upd_book')}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: 0px">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body" id="modal_create_countery">

                    {{csrf_field()}}
                    <div class="form-group">
                        <label class="col-md-3 control-label">{{trans('strings.t_name')}}</label>
                        <div class="col-md-9">
                            <select id="teacherSelect" class="form-control js-teachers" type="text" name="teacher_id">
                                <optgroup  label="{{trans('strings.select_tr_name')}}">
                                    <option style="color: gray" value="" selected="selected" hidden="hidden"> {{trans('strings.select_tr_name')}} </option>
                                    @foreach($teachers as $teacher)
                                    <option value="{{$teacher->teacher_id}}">{{$teacher->ar_name}}</option>
                                    @endforeach
                                </optgroup>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">{{trans('strings.book-input-label')}}</label>
                        <div class="col-md-9">
                            <input type="text" name="title" required="
                                " class="form-control" placeholder="{{trans('strings.book-input-placeholder')}}" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">{{trans('strings.book-input-isbn')}}</label>
                        <div class="col-md-9">
                            <input type="text" name="isbn" required="
                                " class="form-control" placeholder="{{trans('strings.book-isbn-placeholder')}}" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">{{trans('strings.book-input-publish')}}</label>
                        <div class="col-md-9">
                            <input type="text" name="publisher" required="
                                " class="form-control" placeholder="{{trans('strings.book-publish-placeholder')}}" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">{{trans('strings.f_edition')}}</label>
                            <div class="col-md-9">
                                <input type="text"  name="f_edition" id="from-datepicker" class="form-control datepicker" value="2014-08-04">
                            </div>
                    </div>
                     <div class="form-group">
                        <label class="col-md-3 control-label">{{trans('strings.l_edition')}}</label>
                            <div class="col-md-9">
                                <input type="text"  name="l_edition" id="from-datepicker" class="form-control datepicker" value="2014-08-04">
                            </div>
                    </div>


                  <div class="form-group">
                      <div class="col-md-12">
                          <label>{{trans('strings.paper_file')}}</label>
                          <input id="certificat-upload-field" type="file" class="file" data-preview-file-type="any" name="file" />
                      </div>
                  </div>

                    <div>
                        @foreach ($errors->all() as $error)
                        {{ $error }} <br>
                        @endforeach
                    </div>

              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{trans('strings.close')}}</button>
                <button type="submit" class="btn btn-primary">{{trans('strings.save')}}</button>
              </div>
            </div>
          </div>
        </div>
    </form>
    <!-- End Modal Frame -->

    <!-- Start Modal-Update Frame -->

    <!-- Start Modal-Update Frame -->
    <form id='update-books' action="{{url('/books/update/{id}')}}" method="post" enctype="multipart/form-data" class="form-horizontal" role="form">
        <div class="modal fade" id="editBookModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">{{trans('strings.upd-new')}} : {{trans('strings.upd_book')}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: 0px">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body" id="modal-update-books-form-form">



              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{trans('strings.close')}}</button>
                <button type="submit" class="btn btn-primary">{{trans('strings.save')}}</button>
              </div>
            </div>
          </div>
        </div>
    </form>
    <!-- End Modal Frame -->

         <!-- Start Modal-view Frame -->
              <div class="modal fade" id="viewBookModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                 <div class="modal-dialog modal-dialog-centered" role="document">
                     <div class="modal-content">
                         <div class="modal-header">
                             <h5 class="modal-title" id="exampleModalLongTitle">{{trans('strings.display')}} : {{trans('strings.upd_book')}}</h5>
                             <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: 0px">
                                 <span aria-hidden="true">&times;</span>
                             </button>
                         </div>
                         <div class="modal-body" id="modal-view-books">



                         </div>
                         <div class="modal-footer">
                             <button type="button" class="btn btn-secondary" data-dismiss="modal">{{trans('strings.close')}}</button>
                          </div>
                     </div>
                 </div>
             </div>
          <!-- End Modal Frame -->
    <!-- End Modal Frame -->


                <!-- START BREADCRUMB -->
                <ul class="breadcrumb">
                    <li><a href="/">{{trans('strings.Home')}}</a></li>
                     <li><a href="/books/index">{{trans('strings.books-title')}}</a></li>
                    <li class="active">{{trans('strings.sc_books')}}</li>
                </ul>
                <!-- END BREADCRUMB -->


                    <!-- START CONTENT FRAME TOP -->
                    <div class="content-frame-top">
                        @if($lang == 'ar')
                        <div class="pull-right" style="margin-left: 10px">
                            <button  data-toggle="modal" data-target="#addBookModal" class="btn btn-info"><span class="fa fa-plus"></span>  {{trans('strings.add_book')}}</button>
                        </div>
                        @elseif($lang =='en')
                        <div class="pull-left" style="margin-left:10px">
                            <button data-toggle="modal" data-target="#addBookModal" class="btn btn-info"><span class="fa fa-plus"></span> {{trans('strings.add_book')}}</button>
                        </div>
                            @endif
                    </div>
                    <!-- START CONTENT FRAME BODY -->
                    <div class="content-frame-body content-frame-body-left">
                        <div class="page-content-wrap">
                    <div class="row">
                        <div class="col-md-12">
                            <!-- START DEFAULT DATATABLE -->
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title pull-left"><span class="fa fa-opencart"></span>  {{trans('strings.rep_books')}} <span class="fa fa-eye"></span></h3>
                                    <ul class="panel-controls pull-right">
                                        <li><a href="#" class="panel-collapse"><span class="fa fa-angle-down"></span></a></li>
                                        <li><a href="#" class="panel-refresh"><span class="fa fa-refresh"></span></a></li>
                                        <li><a href="#" class="panel-remove"><span class="fa fa-times"></span></a></li>
                                    </ul>
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
                                            <th>{{trans('strings.paper_file')}}</th>
                                            <th>{{trans('strings.Actions')}}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($books as $book)
                                            <tr>
                                               <td>{{$loop -> index+1}}</td>
                                               <td>{{$book->teachers->ar_name}}</td>
                                                <td>{{$book -> title}}</td>
                                                <td>{{$book -> isbn}}</td>
                                                <td>{{$book -> publisher}}</td>
                                                <td>{{$book -> f_edition}}</td>
                                                <td>{{$book -> l_edition}}</td>
                                                <td><a href="">{{$book -> book_file}}</td>
                                                <td>
                                                <button onclick='view_books(this.id)'
                                                    id="{{$book->book_id}}"
                                                    class="btn btn-info btn-rounded btn-sm mb-control"
                                                    data-box="#"><span class="fa fa-eye"></span>
                                                </button>
                                                <button onclick='update_books(this.id)' id="{{$book->book_id}}" class="btn btn-success btn-rounded btn-sm"><span class="fa fa-pencil"></span>
                                                </button>
                                                <button onclick='$("#confirm_delete_books").attr("data",this.id);'
                                                    id="{{$book->book_id}}"
                                                    class="btn btn-danger btn-rounded btn-sm mb-control"
                                                    data-box="#delete_papers"><span class="fa fa-times"></span>
                                                </button>
                                            </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- END DEFAULT DATATABLE -->
                        </div>
                    </div>
                </div>
                </div>
                    <!-- END CONTENT FRAME BODY -->

                <!-- END CONTENT FRAME -->

                <!-- PAGE CONTENT WRAPPER -->

                <!-- END PAGE CONTENT WRAPPER -->


@endsection
