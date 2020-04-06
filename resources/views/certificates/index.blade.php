@php
    $lang = Session::get('lang');
    \App::setLocale($lang);
@endphp

@extends('layouts.admin')

@section('title') {{trans('strings.cert_title')}}
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
    <script>

        // $("#store-certificates").submit(function(event)
        // {
        //     let form = FormData($(this));
        // $.ajax({
        //         url: "{{url('/certificates/store')}}",
        //         data: $(this).serialize(),
        //         type: 'POST',
        //         success: function(data) {
        //             if(data == 'done') {
        //                 refersh();
        //             }
        //         }
        //     });

        //     event.preventDefault();
        // });

         $("#update-certificates").submit(function(event){
            var form = $(this)[0];
            var formData = new FormData(form);

            $.ajax({
                url: "{{url('/certificates/update')}}/"+form['cert_id'].value,
                data: formData,
                type: 'POST',
                contentType: false,
                processData: false,
                success: function(data) {
                    if(data == 'done') {
                        document.location.reload();
                    }
                }
            });

            event.preventDefault();
        });

        function destroy_certificates(id) {
            $.ajax({
                url: "{{url('/certificates/destroy')}}/"+id,
                type: 'POST',
                data: '_token={{csrf_token()}}',
                success: function(res) {
                    refersh();
                }
            });
        }

        function update_certificates(id) {
            $.ajax({
                url: '/certificates/edit/'+id,
                type: 'POST',
                data: '_token={{csrf_token()}}',
                success: function(res) {
                    $('#modal-update-certificates-form-form').html(res);
                    $("#editCertificatModal").modal();
                }
            });
        }
        function view_certificates(id) {
            $.ajax({
                url: '/certificates/view/'+id,
                type: 'POST',
                data: '_token={{csrf_token()}}',
                success: function(res) {
                    $('#modal-view-certificates').html(res);
                    $("#viewCertificatModal").modal();
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

        $('#toggle_all_certificates').click(function(){
            $('.certificates_table_actions').each(function(i,e){
                $(e).prop('checked', false);
            });
        });


        $(document).ready(function(){
            $('#universitySelect').on('change',function(){
                let id = $(this).val();
                $.ajax({
                    url: '{{url("universities/getColleges")}}',
                    type: 'post',
                    data: '_token={{csrf_token()}}&uid='+id,
                    success: function(response) {
                        $('#collegeSelect').html(response);
                        $('#collegeSelect').removeAttr('disabled');
                    }
                });
            });
        });

        $(document).ready(function(){
            $('#collegeSelect').on('change',function(){
                let id = $(this).val();
                $.ajax({
                    url: '{{url("colleges/getDepartments")}}',
                    type: 'post',
                    data: '_token={{csrf_token()}}&cid='+id,
                    success: function(response) {
                        $('#departmentSelect').html(response);
                        $('#departmentSelect').removeAttr('disabled');
                    }
                });
            });
        });

        $(document).ready(function(){
            $('#departmentSelect').on('change',function(){
                let id = $(this).val();
                $.ajax({
                    url: '{{url("specials/getSpecials")}}',
                    type: 'post',
                    data: '_token={{csrf_token()}}&sid='+id,
                    success: function(response) {
                        $('#specialSelect').html(response);
                        $('#specialSelect').removeAttr('disabled');
                    }
                });
            });
        });


        $(document).ready(function(){
            $('#countrySelect').on('change',function(){
                let id = $(this).val();
                $.ajax({
                    url: '{{url("countries/getStates")}}',
                    type: 'post',
                    data: '_token={{csrf_token()}}&cid='+id,
                    success: function(response) {
                        $('#stateSelect').html(response);
                        $('#stateSelect').removeAttr('disabled');
                    }
                });
            });
        });


        $(document).ready(function(){
            $('#stateSelect').on('change',function(){
                let id = $(this).val();
                $.ajax({
                    url: '{{url("states/getRegional")}}',
                    type: 'post',
                    data: '_token={{csrf_token()}}&sid='+id,
                    success: function(response) {
                        $('#regionalSelect').html(response);
                        $('#regionalSelect').removeAttr('disabled');
                    }
                });
            });
        });

        $(document).ready(function(){
            $('#regionalSelect').on('change',function(){
                let id = $(this).val();
                $.ajax({
                    url: '{{url("units/getUnits")}}',
                    type: 'post',
                    data: '_token={{csrf_token()}}&uid='+id,
                    success: function(response) {
                        $('#unitlSelect').html(response);
                        $('#unitlSelect').removeAttr('disabled');
                    }
                });
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

    <div class="message-box animated fadeIn" data-sound="alert" id="delete_certificates">
            <div class="mb-container">
                @if($lang == 'ar')
                <div class="mb-middle pull-right">
                    <div class="mb-title"><span class="fa fa-sign-out"></span> {{trans('strings.delete')}}<strong>{{trans('strings.cert_info')}}</strong> ! </div>
                    <div class="mb-content">
                        <p>{{trans('strings.delete-alert-message-prompt-cert')}}</p>
                        <p>{{trans('strings.delete-alert-message-hint')}}.</p>
                    </div>
                    <div class="mb-footer">
                        <div class="pull-right">
                            <button id="confirm_delete_certificates" data="" onclick='destroy_certificates($(this).attr("data"))'  class="btn btn-success btn-lg">{{trans('strings.yes')}}</button>
                            <button class="btn btn-default btn-lg mb-control-close">{{trans('strings.no')}}</button>
                        </div>
                    </div>
                </div>
                @elseif($lang == 'en')
                <div class="mb-middle">
                    <div class="mb-title"><span class="fa fa-sign-out"></span> {{trans('strings.delete')}} <strong>{{trans('strings.cert_info')}}</strong> ?</div>
                    <div class="mb-content">
                        <p>{{trans('strings.delete-alert-message-prompt-cert')}}</p>
                        <p>{{trans('strings.delete-alert-message-hint')}}.</p>
                    </div>
                    <div class="mb-footer">
                        <div class="pull-right">
                            <button id="confirm_delete_certificates" data="" onclick='destroy_certificates($(this).attr("data"))'  class="btn btn-success btn-lg">{{trans('strings.yes')}}</button>
                            <button class="btn btn-default btn-lg mb-control-close">{{trans('strings.no')}}</button>
                        </div>
                    </div>
                </div>
                @endif
            </div>
    </div>

    <!-- End Delete Alert -->
    <!-- Start Modal Frame -->
    <form id='store-certificates' action="/certificates/store" method="post" enctype="multipart/form-data" class="form-horizontal" role="form">
        <div class="modal fade" id="addCertificatModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle"> {{trans('strings.add-new')}} : {{trans('strings.add_certificat')}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: 0px">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body" id="modal_create_special">

                 {{csrf_field()}}

                    <div class="form-group">
                        <label class="col-md-4 control-label">{{trans('strings.t_name')}}</label>
                        <div class="col-md-8">
                            <select id="teacherSelect" required class="form-control js-teachers" type="text" name="teacher_id">
                                <optgroup  label="{{trans('strings.select_tr_name')}}">
                                    <option style="color: gray" selected="selected" hidden="hidden"> {{trans('strings.select_tr_name')}} </option>
                                    @foreach($teachers as $teacher)
                                    <option value="{{$teacher->teacher_id}}">{{$teacher->ar_name}}</option>
                                    @endforeach
                                </optgroup>
                            </select>
                        </div>
                    </div>

                      <div class="form-group">
                        <label class="col-md-4 control-label">{{trans('teacher.degree')}}</label>
                        <div class="col-md-8">
                            <select id="degreeSelect" required class="form-control js-teachers" type="text" name="degree_id">
                                <optgroup  label="{{trans('teacher.select_degree-label')}}">
                                    <option style="color: gray" selected="selected" hidden="hidden"> {{trans('teacher.select_degree-label')}} </option>
                                    @foreach($degrees as $degree)
                                    <option value="{{$degree->degree_id}}">{{$degree->name}}</option>
                                    @endforeach
                                </optgroup>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label">{{trans('strings.ser_qual')}} </label>
                        <div class="col-md-8">
                        <input type="text" name="cert_name" required class="form-control" placeholder="{{trans('strings.ser_qual-input-placeholder')}}"/>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label">{{trans('strings.select_university')}}</label>
                        <div class="col-md-8">
                            <select onchange="getColleges(this.value())" required id="universitySelect" class="form-control js-specials" type="text" name="university_id">
                                <optgroup  label="{{trans('strings.select_univers-label')}}">
                                    <option style="color: gray" selected="selected" hidden="hidden"> {{trans('strings.select_univers-label')}} </option>
                                    @foreach($universities as $unive)
                                    <option value="{{$unive->university_id}}">{{$unive->name}}</option>
                                    @endforeach
                                </optgroup>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-4 control-label">{{trans('strings.select_college')}}</label>
                        <div class="col-md-8">
                            <select disabled id="collegeSelect" required class="form-control js-specials" name="college_id">
                                <option selected="selected">{{trans('strings.select_college_first')}}</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-4 control-label">{{trans('strings.special_depart')}}</label>
                        <div class="col-md-8">
                            <select disabled id="departmentSelect" class="form-control js-specials" name="depart_id">
                                <option selected="selected">{{trans('strings.select_depart_first')}}</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-4 control-label">{{trans('strings.special-input-name')}}</label>
                        <div class="col-md-8">
                            <select disabled id="specialSelect" required class="form-control js-specials" name="special_id">
                                <option selected="selected">{{trans('strings.select_special_first')}}</option>
                            </select>
                        </div>
                    </div>

                    <!-- Address Information-->

                    <!-- Country -->

                    <div class="form-group">
                        <label class="col-md-4 control-label">{{trans('strings.select_country')}}</label>
                        <div class="col-md-8">
                            <select onchange="getStates(this.value())" required id="countrySelect" class="form-control js-regionals" type="text" name="countery_id">
                                <optgroup  label="{{trans('strings.select_state-label')}}">
                                    <option style="color: gray" selected="selected" hidden="hidden"> {{trans('strings.select_state-label')}} </option>
                                    @foreach($countreis as $count)
                                    <option value="{{$count->countery_id}}">{{$count->name}}</option>
                                    @endforeach
                                </optgroup>
                            </select>
                        </div>
                    </div>
                      <div class="form-group">
                        <label class="col-md-4 control-label">{{trans('strings.study')}}</label>
                        <div class="col-md-8">
                            <select id="studySelect" class="form-control js-teachers" required type="text" name="study_id">
                                <optgroup  label="{{trans('strings.select_study')}}">
                                    <option style="color: gray" selected="selected" hidden="hidden"> {{trans('strings.select_study')}} </option>
                                    @foreach($studes as $study)
                                    <option value="{{$study->study_id}}">{{$study->name}}</option>
                                    @endforeach
                                </optgroup>
                            </select>
                        </div>
                    </div>


                    <div class="form-group">
                        <label class="col-md-4 control-label">{{trans('strings.sert_grad')}}</label>
                        <div class="col-md-8">
                            <input type="text" name="sert_grade" required class="form-control" placeholder="{{trans('strings.sert_grad-input-placeholder')}}" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-4 control-label">{{trans('strings.certdate')}}</label>
                            <div class="col-md-8">
                                <input type="text"  name="cert_date" required id="from-datepicker" class="form-control datepicker" value="2014-08-04">
                            </div>
                    </div>
                  <div class="form-group">
                      <label class="col-md-2 control-label">{{trans('strings.sert_img')}}</label>
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

    <!-- START WIZARD WITH SUBMIT BUTTON -->

    <!-- END WIZARD WITH SUBMIT BUTTON -->
    <!-- Start Modal-Update Frame -->
         <div class="modal fade" id="viewCertificatModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
             <div class="modal-dialog modal-dialog-centered" role="document">
                 <div class="modal-content">
                     <div class="modal-header">
                         <h5 class="modal-title" id="exampleModalLongTitle">{{trans('strings.viw-new')}} : {{trans('strings.UPD_cert')}}</h5>

                     </div>
                     <div class="modal-body" id="modal-view-certificates">
                     </div>
                     <div class="modal-footer">
                         <button type="button" class="btn btn-secondary" data-dismiss="modal">{{trans('strings.close')}}</button>
                         <button type="submit" class="btn btn-primary">{{trans('strings.save')}}</button>
                     </div>
                 </div>
             </div>
         </div>
    <!-- End Modal Frame -->


                <!-- START BREADCRUMB -->
                <ul class="breadcrumb">
                    <li><a href="/">{{trans('strings.Home')}}</a></li>
                     <li><a href="/certificates/index">{{trans('strings.certificates')}}</a></li>
                    <li class="active">{{trans('strings.sc_certificates')}}</li>
                </ul>
                <!-- END BREADCRUMB -->


                    <!-- START CONTENT FRAME TOP -->
                    <div class="content-frame-top">
                        <!-- <div class="page-title">
                            <h2><span class="fa fa-image"></span> Gallery</h2>
                        </div>  -->
                        @if($lang == 'ar')
                        <div class="pull-right" style="margin-left: 10px">
                            <button  data-toggle="modal" data-target="#addCertificatModal" class="btn btn-info"><span class="fa fa-plus"></span>  {{trans('strings.AD_certificates')}}</button>
                            <!-- <button class="btn btn-default content-frame-right-toggle"><span class="fa fa-bars"></span></button> -->
                        </div>
                        @elseif($lang =='en')
                        <div class="pull-left" style="margin-left:10px">
                            <button data-toggle="modal" data-target="#addCertificatModal" class="btn btn-info"><span class="fa fa-plus"></span> {{trans('strings.AD_certificates')}}</button>
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
                                    <h3 class="panel-title pull-left"><span class="fa fa-opencart"></span>  {{trans('strings.Report of certificates Data')}} <span class="fa fa-eye"></span></h3>
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
                                            <th>{{trans('strings.tr_name')}}</th>
                                            <th>{{trans('teacher.tr_degree')}}</th>
                                            <th>{{trans('strings.sert_name')}}</th>
                                            <th>{{trans('strings.tr_university')}}</th>
                                            <th>{{trans('strings.tr_college')}}</th>
                                            <th>{{trans('strings.tr_department')}}</th>
                                            <th>{{trans('strings.tr_specialization')}}</th>
                                            <th>{{trans('strings.tr_countery')}}</th>
                                            <th>{{trans('strings.study_type')}}</th>
                                            <th>{{trans('strings.sert_date')}}</th>
                                            <th>{{trans('strings.sert_grad')}}</th>
                                            <th>{{trans('strings.Actions')}}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                         @foreach($certificates as $certificat)
                                            <tr>
                                            <td>{{$loop -> index+1}}</td>
                                            <td>{{$certificat->teachers->ar_name}}</td>
                                            <td>{{$certificat->degrees->name}}</td>
                                            <td>{{$certificat->cert_name}}</td>
                                            <td>{{$certificat->specials->departments->colleges->universities->name}}</td>
                                                <td>{{$certificat->specials->departments->colleges->name}}</td>
                                            <td>{{$certificat->specials->departments->name}}</td>
                                            <td>{{$certificat->specials->name}}</td>
                                            <td>{{$certificat->countreis->name}}</td>

                                            <td>{{$certificat->studes->name}}</td>
                                            <td>{{$certificat->cert_date}}</td>
                                            <td>{{$certificat->sert_grade}}</td>
                                            <td>
                                                <button onclick='view_certificates(this.id)'
                                                    id="{{$certificat->cert_id}}"
                                                    class="btn btn-info btn-rounded btn-sm mb-control"><span class="fa fa-eye"></span>
                                                </button>
                                                <button onclick='update_certificates(this.id)' id="{{$certificat->cert_id}}" class="btn btn-success btn-rounded btn-sm"><span class="fa fa-pencil"></span>
                                                </button>
                                                <button onclick='$("#confirm_delete_certificates").attr("data",this.id);'
                                                    id="{{$certificat->cert_id}}"
                                                    class="btn btn-danger btn-rounded btn-sm mb-control"
                                                    data-box="#delete_certificates"><span class="fa fa-times"></span>
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
