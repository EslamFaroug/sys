@php
    $lang = Session::get('lang');
    \App::setLocale($lang);
@endphp

@extends('layouts.admin')

@section('title') {{trans('strings.train_title')}}
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
    <script type="text/javascript" src="{{('/js/plugins/datatables/jquery.dataTables.min.js')}}"></script>
    <script type='text/javascript' src="{{('/js/plugins/bootstrap/bootstrap-datepicker.js')}}"></script>
    <script type="text/javascript" src="{{asset('/js/plugins/fileinput/fileinput.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('/js/plugins/filetree/jqueryFileTree.js')}}"></script>

    <script>


         $("#update-training").submit(function(event){
             event.preventDefault();
             var form = $(this)[0];
            var formData = new FormData(form);
             $.ajax({
                url: "{{url('/training/update')}}/"+form['train_id'].value,
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

        function destroy_training(id) {
            $.ajax({
                url: "{{url('/training/destroy')}}/"+id,
                type: 'POST',
                data: '_token={{csrf_token()}}',
                success: function(res) {
                    refersh();
                }
            });
        }

        function update_training(id) {
            $.ajax({
                url: '/training/edit/'+id,
                type: 'POST',
                data: '_token={{csrf_token()}}',
                success: function(res) {
                    $('#modal-update-training-form').html(res);
                    $("#editTrainModal").modal();
                }
            });
        }
         function view_training(id) {
             $.ajax({
                 url: '/training/view/'+id,
                 type: 'POST',
                 data: '_token={{csrf_token()}}',
                 success: function(res) {
                     $('#modal-view-training').html(res);
                     $("#ViewTrainModal").modal();
                 }
             });
         }



        // $('#certificat-upload-field-edit').ready(function() {
        //     $(this).change(function(event) {
        //         //alert(e.target.files[0].result);
        //         var tmppath = URL.createObjectURL(event.target.files[0]);
        //         $('#img-update').fadeIn("slow").attr('src',tmppath);
        //         $('#update-photo-question').attr('checked','checked');
        //     });
        // });

        function refersh() {
            document.location.href = document.location.href;
        }
        function click_select_photo() {
            $('#certificat-upload-field-edit').click();
        }


        $('#toggle_all_skills').click(function(){
            $('.skills_table_actions').each(function(i,e){
                $(e).prop('checked', false);
            });
        });
         var filezone = new Filezone();

    </script>

@endsection

@section('javascript')
    $(document).ready(function(){
});
@endsection

@section('contents')


    <!-- Start Delete Alert -->

    <div class="message-box animated fadeIn" data-sound="alert" id="delete_training">
            <div class="mb-container">
                @if($lang == 'ar')
                <div class="mb-middle pull-right">
                    <div class="mb-title"><span class="fa fa-sign-out"></span> {{trans('strings.delete')}}<strong>{{trans('strings.train-input-label')}}</strong> ! </div>
                    <div class="mb-content">
                        <p>{{trans('strings.delete-alert-message-prompt-train')}}</p>
                        <p>{{trans('strings.delete-alert-message-hint')}}.</p>
                    </div>
                    <div class="mb-footer">
                        <div class="pull-right">
                            <button id="confirm_delete_training" data="" onclick='destroy_training($(this).attr("data"))'  class="btn btn-success btn-lg">{{trans('strings.yes')}}</button>
                            <button class="btn btn-default btn-lg mb-control-close">{{trans('strings.no')}}</button>
                        </div>
                    </div>
                </div>
                @elseif($lang == 'en')
                <div class="mb-middle">
                    <div class="mb-title"><span class="fa fa-sign-out"></span> {{trans('strings.delete')}} <strong>{{trans('strings.train-input-label')}}</strong> ?</div>
                    <div class="mb-content">
                        <p>{{trans('strings.delete-alert-message-prompt-train')}}</p>
                        <p>{{trans('strings.delete-alert-message-hint')}}.</p>
                    </div>
                    <div class="mb-footer">
                        <div class="pull-right">
                            <button id="confirm_delete_training" data="" onclick='destroy_training($(this).attr("data"))'  class="btn btn-success btn-lg">{{trans('strings.yes')}}</button>
                            <button class="btn btn-default btn-lg mb-control-close">{{trans('strings.no')}}</button>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>

    <!-- End Delete Alert -->

    <!-- Start Modal Frame -->
    <form id='store-training' action="/training/store" method="post" enctype="multipart/form-data" class="form-horizontal" role="form">
        <div class="modal fade" id="addTrainModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle"> {{trans('strings.add-new')}} : {{trans('strings.upd_train')}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: 0px">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body" id="modal_create_countery">

                    {{csrf_field()}}
                    <div class="form-group">
                        <label class="col-md-2 control-label">{{trans('strings.t_name')}}</label>
                        <div class="col-md-10">
                            <select id="teacherSelect" class="form-control js-teachers" type="text" name="teacher_id">
                                <optgroup  label="{{trans('strings.select_tr_name')}}">
                                    <option style="color: gray" selected="selected" value="" hidden="hidden"> {{trans('strings.select_tr_name')}} </option>
                                    @foreach($teachers as $teacher)
                                    <option value="{{$teacher->teacher_id}}">{{$teacher->ar_name}}</option>
                                    @endforeach
                                </optgroup>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">{{trans('strings.title-input-label')}}</label>
                        <div class="col-md-10">
                            <input type="text" name="title" required="
                                " class="form-control" placeholder="{{trans('strings.title-input-placeholder')}}" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">{{trans('strings.institute-input-label')}}</label>
                        <div class="col-md-10">
                            <input type="text" name="institute" required="
                                " class="form-control" placeholder="{{trans('strings.institute-input-placeholder')}}" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-2 control-label">{{trans('strings.training place')}}</label>
                        <div class="col-md-10">
                            <select onchange="getStates(this.value())" id="countrySelect" class="form-control js-regionals" type="text" name="countery_id">
                                <optgroup  label="{{trans('strings.select_state-label')}}">
                                    <option style="color: gray" selected="selected" value="" hidden="hidden"> {{trans('strings.select_state-label')}} </option>
                                    @foreach($countreis as $count)
                                    <option value="{{$count->countery_id}}">{{$count->name}}</option>
                                    @endforeach
                                </optgroup>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">{{trans('strings.track of training')}}</label>
                        <div class="col-md-10">
                            <select id="teacherSelect" class="form-control js-teachers" type="text" name="special_id">
                                <optgroup  label="{{trans('strings.select_special_track')}}">
                                    <option style="color: gray" selected="selected" value="" hidden="hidden"> {{trans('strings.select_special_track')}} </option>
                                    @foreach($specials as $special)
                                    <option value="{{$special->special_id}}">{{$special->name}}</option>
                                    @endforeach
                                </optgroup>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">{{trans('strings.st_date')}}</label>
                            <div class="col-md-10">
                                <input type="text"  name="st_date" id="from-datepicker" class="form-control datepicker" value="2014-08-04">
                            </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">{{trans('strings.end_date')}}</label>
                            <div class="col-md-10">
                                <input type="text"  name="end_date" id="from-datepicker" class="form-control datepicker" value="2014-08-04">
                            </div>
                    </div>

                  <div class="form-group">
                      <label class="col-md-2 control-label">{{trans('strings.train_file')}}</label>
                      <div class="col-md-10">
                          <div class="filezone" filezone-input-name="image" filezone-image-path="{{asset("")}}"></div>
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
    <form id='update-training' training method="post" enctype="multipart/form-data" class="form-horizontal" role="form">
        <div class="modal fade" id="editTrainModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">{{trans('strings.upd-new')}} : {{trans('strings.upd_train')}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: 0px">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body" id="modal-update-training-form">



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


    <!-- Start Modal-View Frame -->
         <div class="modal fade" id="ViewTrainModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">{{trans('strings.display')}} : {{trans('strings.upd_train')}}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: 0px">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" id="modal-view-training">



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
                     <li><a href="/training/index">{{trans('strings.train-table-title')}}</a></li>
                    <li class="active">{{trans('strings.sc_train')}}</li>
                </ul>
                <!-- END BREADCRUMB -->


                    <!-- START CONTENT FRAME TOP -->
                    <div class="content-frame-top">
                        <!-- <div class="page-title">
                            <h2><span class="fa fa-image"></span> Gallery</h2>
                        </div>  -->
                        @if($lang == 'ar')
                        <div class="pull-right" style="margin-left: 10px">
                            <button  data-toggle="modal" data-target="#addTrainModal" class="btn btn-info"><span class="fa fa-plus"></span>  {{trans('strings.add_train')}}</button>
                            <!-- <button class="btn btn-default content-frame-right-toggle"><span class="fa fa-bars"></span></button> -->
                        </div>
                        @elseif($lang =='en')
                        <div class="pull-left" style="margin-left:10px">
                            <button data-toggle="modal" data-target="#addTrainModal" class="btn btn-info"><span class="fa fa-plus"></span> {{trans('strings.add_train')}}</button>
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
                                    <h3 class="panel-title pull-left"><span class="fa fa-opencart"></span>  {{trans('strings.Report of train')}} <span class="fa fa-eye"></span></h3>
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
                                            <th>{{trans('strings.title-input-label')}}</th>
                                            <th>{{trans('strings.institute-input-label')}}</th>
                                            <th>{{trans('strings.training place')}}</th>
                                            <th>{{trans('strings.track of training')}}</th>
                                            <th>{{trans('strings.from_date')}}</th>
                                            <th>{{trans('strings.final_date')}}</th>
                                            <th>{{trans('strings.Actions')}}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($trains as $train)
                                            <tr>
                                               <td>{{$loop -> index+1}}</td>
                                               <td>{{$train->teachers->ar_name}}</td>
                                                <td>{{$train -> title}}</td>
                                                <td>{{$train -> institute}}</td>
                                                <td>{{$train->countreis->name}}</td>
                                                <td>{{$train->specials->name}}</td>
                                                <td>{{$train -> st_date}}</td>
                                                <td>{{$train -> end_date}}</td>
                                                <td>

                                                <button onclick='view_training(this.id)'
                                                    id="{{$train->train_id}}"
                                                    class="btn btn-info btn-rounded btn-sm mb-control"><span class="fa fa-eye"></span>
                                                </button>
                                                <button onclick='update_training(this.id)' id="{{$train->train_id}}" class="btn btn-success btn-rounded btn-sm"><span class="fa fa-pencil"></span>
                                                </button>
                                                <button onclick='$("#confirm_delete_training").attr("data",this.id);'
                                                    id="{{$train->train_id}}"
                                                    class="btn btn-danger btn-rounded btn-sm mb-control"
                                                    data-box="#delete_training"><span class="fa fa-times"></span>
                                                </button>

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
