@php
    $lang = Session::get('lang');
    \App::setLocale($lang);
@endphp

@extends('layouts.admin')

@section('title') {{trans('strings.study-title')}}
@endsection



<!-- @section('inner-title')
    {{trans('strings.countreis-title')}}
@endsection -->

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


    <script>

        $("#store-study_types").submit(function(event){

            $.ajax({
                url: "{{url('/study_types/store')}}",
                data: $(this).serialize(),
                type: 'POST',
                success: function(data) {
                    if(data == 'done') {
                        refersh();
                    }
                }
            });

            event.preventDefault();
        });

         $("#update-study_types").submit(function(event){
            var form = $(this)[0];
            var formData = new FormData(form);

            $.ajax({
                url: "{{url('/study_types/update')}}/"+form['study_id'].value,
                data: formData,
                type: 'POST',
                contentType: false,
                processData: false,
                success: function(data) {
                    if(data == 'done') {
                        refersh();
                    }
                }
            });

            event.preventDefault();
        });

        function destroy_study_types(id) {
            $.ajax({
                url: "{{url('/study_types/destroy')}}/"+id,
                type: 'POST',
                data: '_token={{csrf_token()}}',
                success: function(res) {
                    refersh();
                }
            });
        }

        function update_study_types(id) {
            $.ajax({
                url: '/study_types/edit/'+id,
                type: 'POST',
                data: '_token={{csrf_token()}}',
                success: function(res) {
                    $('#modal-update-studes-form').html(res);
                    $("#editWorkModal").modal();
                }
            });
        }

        function refersh() {
            document.location.href = document.location.href;
        }

        $('#toggle_all_studes').click(function(){
            $('.degrees_table_actions').each(function(i,e){
                $(e).prop('checked', false);
            });
        });

    </script>

@endsection

@section('javascript')
    $(document).ready(function(){
});
@endsection

@section('contents')


    <!-- Start Delete Alert -->

    <div class="message-box animated fadeIn" data-sound="alert" id="delete_studes">
            <div class="mb-container">
                @if($lang == 'ar')
                <div class="mb-middle pull-right">
                    <div class="mb-title"><span class="fa fa-sign-out"></span> {{trans('strings.delete')}}<strong>{{trans('strings.study-input-label')}}</strong> ! </div>
                    <div class="mb-content">
                        <p>{{trans('strings.delete-alert-message-prompt-study')}}</p>
                        <p>{{trans('strings.delete-alert-message-hint')}}.</p>
                    </div>
                    <div class="mb-footer">
                        <div class="pull-right">
                            <button id="confirm_delete_studes" data="" onclick='destroy_study_types($(this).attr("data"))'  class="btn btn-success btn-lg">{{trans('strings.yes')}}</button>
                            <button class="btn btn-default btn-lg mb-control-close">{{trans('strings.no')}}</button>
                        </div>
                    </div>
                </div>
                @elseif($lang == 'en')
                <div class="mb-middle">
                    <div class="mb-title"><span class="fa fa-sign-out"></span> {{trans('strings.delete')}} <strong>{{trans('strings.study-input-label')}}</strong> ?</div>
                    <div class="mb-content">
                        <p>{{trans('strings.delete-alert-message-prompt-study')}}</p>
                        <p>{{trans('strings.delete-alert-message-hint')}}.</p>
                    </div>
                    <div class="mb-footer">
                        <div class="pull-right">
                            <button id="confirm_delete_studes" data="" onclick='destroy_study_types($(this).attr("data"))'  class="btn btn-success btn-lg">{{trans('strings.yes')}}</button>
                            <button class="btn btn-default btn-lg mb-control-close">{{trans('strings.no')}}</button>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>

    <!-- End Delete Alert -->

    <!-- Start Modal Frame -->
    <form id='store-study_types'  method="post" enctype="multipart/form-data" class="form-horizontal" role="form">
        <div class="modal fade" id="addStudyModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle"> {{trans('strings.add-new')}} : {{trans('strings.add_studes')}}</h5>
               <!--  <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: 0px">
                  <span aria-hidden="true">&times;</span>
                </button> -->
              </div>
              <div class="modal-body" id="modal_create_work">

                        {{csrf_field()}}
                        <div class="form-group">
                            <label class="col-md-2 control-label">{{trans('strings.study-input-label')}}</label>
                            <div class="col-md-10">
                                <input type="text" name="name" required="
                                " class="form-control" placeholder="{{trans('strings.study-input-placeholder')}}" />
                            </div>
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
    <form id='update-study_types' works method="post" enctype="multipart/form-data" class="form-horizontal" role="form">
        <div class="modal fade" id="editWorkModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">{{trans('strings.upd-new')}} : {{trans('strings.upd_study')}}</h5>
                <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: 0px">
                  <span aria-hidden="true">&times;</span>
                </button> -->
              </div>
              <div class="modal-body" id="modal-update-studes-form">



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
    <!-- End Modal Frame -->


                <!-- START BREADCRUMB -->
                <ul class="breadcrumb">
                    <li><a href="/">{{trans('strings.Home')}}</a></li>
                     <li><a href="/study_types/index">{{trans('strings.study_type-title')}}</a></li>
                    <li class="active">{{trans('strings.sc_study')}}</li>
                </ul>
                <!-- END BREADCRUMB -->


                    <!-- START CONTENT FRAME TOP -->
                    <div class="content-frame-top">
                        <!-- <div class="page-title">
                            <h2><span class="fa fa-image"></span> Gallery</h2>
                        </div>  -->
                        @if($lang == 'ar')
                        <div class="pull-right" style="margin-left: 10px">
                            <button  data-toggle="modal" data-target="#addStudyModal" class="btn btn-info"><span class="fa fa-plus"></span>  {{trans('strings.Add_study')}}</button>
                            <!-- <button class="btn btn-default content-frame-right-toggle"><span class="fa fa-bars"></span></button> -->
                        </div>
                        @elseif($lang =='en')
                        <div class="pull-left" style="margin-left:10px">
                            <button data-toggle="modal" data-target="#addStudyModal" class="btn btn-info"><span class="fa fa-plus"></span> {{trans('strings.Add_study')}}</button>
                        </div>
                            @endif
                    </div>

                    <!-- START CONTENT FRAME RIGHT -->
                    <!-- <div class="content-frame-right">
                        <div class="block push-up-10">
                            <form action="upload.php" class="dropzone dropzone-mini"></form>
                        </div>
                        <h4>Groups:</h4>
                        <div class="list-group border-bottom push-down-20">
                            <a href="#" class="list-group-item active">All <span class="badge badge-primary">12</span></a>
                            <a href="#" class="list-group-item">Nature <span class="badge badge-success">7</span></a>
                            <a href="#" class="list-group-item">Music <span class="badge badge-danger">3</span></a>
                            <a href="#" class="list-group-item">Space <span class="badge badge-info">2</span></a>
                            <a href="#" class="list-group-item">Girls <span class="badge badge-warning">3</span></a>
                        </div>

                    </div> -->
                    <!-- END CONTENT FRAME RIGHT -->

                    <!-- START CONTENT FRAME BODY -->
                    <div class="content-frame-body content-frame-body-left">
                            <div class="page-content-wrap">
                    <div class="row">
                        <div class="col-md-12">
                            <!-- START DEFAULT DATATABLE -->
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title pull-left"><span class="fa fa-opencart"></span>  {{trans('strings.Report of studes')}} <span class="fa fa-eye"></span></h3>
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
                                                <th>{{trans('strings.study_name')}}</th>
                                                <th>{{trans('strings.Actions')}}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($studes as $study)
                                            <tr>
                                               <td>{{$loop -> index+1}}</td>
                                                <td>{{$study -> name}}</td>
                                                <td>
                                                <button onclick='update_study_types(this.id)' id="{{$study->study_id}}" class="btn btn-default btn-rounded btn-sm"><span class="fa fa-pencil"></span>  {{trans('strings.update')}} </button>
                                                <button
                                                    onclick='$("#confirm_delete_studes").attr("data",this.id);'
                                                    id="{{$study->study_id}}"
                                                    class="btn btn-danger btn-rounded btn-sm mb-control"
                                                    data-box="#delete_studes">
                                                        <span class="fa fa-times"></span>  {{trans('strings.delete')}}
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
