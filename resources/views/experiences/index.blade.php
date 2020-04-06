@php
    $lang = Session::get('lang');
    \App::setLocale($lang);
@endphp

@extends('layouts.admin')

@section('title') {{trans('strings.exp_title')}}
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

    <script>


         $("#update-contacts").submit(function(event){
             event.preventDefault();
             var form = $(this)[0];
            var formData = new FormData(form);
            $.ajax({
                url: "{{url('/experiences/update')}}/"+form['exp_id'].value,
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

        function destroy_experiences(id) {
            $.ajax({
                url: "{{url('/experiences/destroy')}}/"+id,
                type: 'POST',
                data: '_token={{csrf_token()}}',
                success: function(res) {
                    refersh();
                }
            });
        }

        function update_contacts(id) {
            $.ajax({
                url: '/experiences/edit/'+id,
                type: 'POST',
                data: '_token={{csrf_token()}}',
                success: function(res) {
                    $('#modal-update-contacts-form-form').html(res);
                    $("#editContactModal").modal();
                }
            });
        }

        function refersh() {
            document.location.href = document.location.href;
        }

        $('#toggle_all_contacts').click(function(){
            $('.contacts_table_actions').each(function(i,e){
                $(e).prop('checked', false);
            });
        });

// Education Information:=>

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
        })

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
        })

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
        })

        $(document).ready(function () {

          $(".iradio").change(function () {
               if(this.value=="job_teach"){
                   $("#job_teach").show();
                   $("#uni").show();
                   $("#job_mange").hide();
                   $("#exp").hide();
               }else if(this.value=="job_mange"){
                   $("#job_mange").show();
                   $("#uni").show();
                   $("#job_teach").hide();
               }else if(this.value=="exp"){
                   $("#exp").show();
                   $("#uni").hide();
                   $("#job_mange").hide();
                   $("#job_teach").hide();

               }
          })
        })
    </script>

@endsection

@section('javascript')
$(document).ready(function(){
});
@endsection

@section('contents')


     <!-- Start Delete Alert -->

    <div class="message-box animated fadeIn" data-sound="alert" id="delete_contacts">
            <div class="mb-container">
                @if($lang == 'ar')
                <div class="mb-middle pull-right">
                    <div class="mb-title"><span class="fa fa-sign-out"></span> {{trans('strings.delete')}}<strong>{{trans('strings.exp_info')}}</strong> ! </div>
                    <div class="mb-content">
                        <p>{{trans('strings.delete-alert-message-prompt-exp')}}</p>
                        <p>{{trans('strings.delete-alert-message-hint')}}.</p>
                    </div>
                    <div class="mb-footer">
                        <div class="pull-right">
                            <button id="confirm_delete_experiences" data="" onclick='destroy_experiences($(this).attr("data"))'  class="btn btn-success btn-lg">{{trans('strings.yes')}}</button>
                            <button class="btn btn-default btn-lg mb-control-close">{{trans('strings.no')}}</button>
                        </div>
                    </div>
                </div>
                @elseif($lang == 'en')
                <div class="mb-middle">
                    <div class="mb-title"><span class="fa fa-sign-out"></span> {{trans('strings.delete')}} <strong>{{trans('strings.exp_info')}}</strong> ?</div>
                    <div class="mb-content">
                        <p>{{trans('strings.delete-alert-message-prompt-exp')}}</p>
                        <p>{{trans('strings.delete-alert-message-hint')}}.</p>
                    </div>
                    <div class="mb-footer">
                        <div class="pull-right">
                            <button id="confirm_delete_experiences" data="" onclick='destroy_experiences($(this).attr("data"))'  class="btn btn-success btn-lg">{{trans('strings.yes')}}</button>
                            <button class="btn btn-default btn-lg mb-control-close">{{trans('strings.no')}}</button>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>

    <!-- End Delete Alert -->

    <!-- Start Modal Frame -->
    <form id='store-experiences'  action="/experiences/store" method="post" enctype="multipart/form-data" class="form-horizontal" role="form">
        <div class="modal fade" id="addSpecialModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle"> {{trans('strings.add-new')}} : {{trans('strings.UPD_exp')}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: 0px">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body" id="modal_create_special">

                 {{csrf_field()}}

                    <div class="form-group">
                        <label class="col-md-3 control-label">{{trans('strings.t_name')}}</label>
                        <div class="col-md-9">
                            <select id="teacherSelect" required class="form-control js-teachers" type="text" name="teacher_id">
                                <optgroup  label="{{trans('strings.select_tr_name')}}">
                                    <option style="color: gray"  value="" hidden="hidden"> {{trans('strings.select_tr_name')}} </option>
                                    @foreach($teachers as $teacher)
                                    <option value="{{$teacher->teacher_id}}">{{$teacher->ar_name}}</option>
                                    @endforeach
                                </optgroup>
                            </select>
                        </div>
                    </div>


                  <div class="form-group">
                      <label class="col-md-3 control-label">{{trans('strings.job_type')}}</label>
                      <div class="col-md-9">
                          <div class="form-group">
                              <div class="col-lg-4 col-md-4 col-sm-4">
                                  <label class="check"><input type="radio" checked="" required value="job_teach" class="iradio" name="iradio"/> {{trans('strings.teach')}}</label>
                              </div>
                              <div class="col-lg-4 col-md-4 col-sm-4">
                                  <label class="check"><input type="radio" required value="job_mange" class="iradio" name="iradio" /> {{trans('strings.mange')}}</label>
                              </div>
                              <div class="col-lg-4 col-md-4 col-sm-4">
                                  <label class="check"><input type="radio" required value="exp" class="iradio" name="iradio" /> {{trans('strings.exp')}}</label>
                              </div>
                          </div>
                      </div>
                  </div>
                  <!-- job_teach-->
                  <div id="job_teach" style=" margin-bottom: 15px;">
                  <div class="form-group">
                      <label class="col-md-3 control-label">{{trans('strings.job_teach')}}</label>
                      <div class="col-md-9">
                          <select id="degreeSelect" class="form-control js-teachers" type="text" name="degree_id">
                              <optgroup  label="{{trans('strings.select_degree-label')}}">
                                  <option style="color: gray"  selected hidden="hidden" value=""> {{trans('strings.select_degree-label')}} </option>
                                  @foreach($degrees as $degree)
                                      <option value="{{$degree->degree_id}}">{{$degree->name}}</option>
                                  @endforeach
                              </optgroup>
                          </select>
                      </div>
                  </div>
                  </div>

                  <!-- job_mange-->
                  <div id="job_mange" style="display: none ; margin-bottom: 15px;">
                      <div class="form-group">
                          <label class="col-md-3 control-label">{{trans('strings.job_mange')}}</label>
                          <div class="col-md-9">
                              <select id="mangeSelect" class="form-control js-teachers" type="text" name="mangejob_id">
                                  <optgroup  label="{{trans('strings.select_mange_label')}}">
                                      <option value="na"> لا يوجد </option>
                                      <option style="color: gray" selected  hidden="hidden" value="">{{trans('strings.select_mange_label')}} </option>
                                      @foreach($mangejobs as $mange)
                                          <option value="{{$mange->mangejob_id}}">{{$mange->name}}</option>
                                      @endforeach
                                  </optgroup>
                              </select>
                          </div>
                      </div>
                  </div>

                  <div id="uni" style="  margin-bottom: 15px;">
                    <div class="form-group">
                        <label class="col-md-3 control-label">{{trans('strings.select_university')}}</label>
                        <div class="col-md-9">
                            <select onchange="getColleges(this.value())" id="universitySelect" class="form-control js-specials" type="text" name="university_id">
                                <optgroup  label="{{trans('strings.select_univers-label')}}">
                                    <option style="color: gray" selected  hidden="hidden" value=""> {{trans('strings.select_univers-label')}} </option>
                                    @foreach($universities as $unive)
                                    <option value="{{$unive->university_id}}">{{$unive->name}}</option>
                                    @endforeach
                                </optgroup>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">{{trans('strings.select_college')}}</label>
                        <div class="col-md-9">
                            <select disabled id="collegeSelect" class="form-control js-specials" name="college_id">
                                <option selected="selected" value="">{{trans('strings.select_college_first')}}</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">{{trans('strings.special_depart')}}</label>
                        <div class="col-md-9">
                            <select disabled id="departmentSelect" class="form-control js-specials" name="depart_id">
                                <option selected="selected" value="">{{trans('strings.select_depart_first')}}</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">{{trans('strings.special-input-name')}}</label>
                        <div class="col-md-9">
                            <select disabled id="specialSelect" class="form-control js-specials" name="special_id">
                                <option selected="selected" value="">{{trans('strings.select_special_first')}}</option>
                            </select>
                        </div>
                    </div>
                  </div>



                  <!-- exp-->
                  <div id="exp" style="display: none ;  margin-bottom: 15px;">
                  <div class="form-group">
                      <label class="col-md-3 control-label">{{trans('strings.exp_name')}}</label>
                      <div class="col-md-9">
                          <input type="text" name="exp_name" class="form-control" placeholder="{{trans('strings.exp_name_placeholder')}}" />
                      </div>
                  </div>
                  <div class="form-group">
                        <label class="col-md-3 control-label">{{trans('strings.exp_institute')}}</label>
                        <div class="col-md-9">
                            <input type="text" name="institute" class="form-control" placeholder="{{trans('strings.institute_placeholder')}}" />
                        </div>
                    </div>
                  </div>

                    <!-- Address Information-->
                    <div class="form-group">
                        <label class="col-md-3 control-label">{{trans('strings.work_type')}}</label>
                        <div class="col-md-9">
                            <select id="degreeSelect" class="form-control js-teachers" type="text" name="work_id">
                                <optgroup  label="{{trans('strings.work_type_label')}}">
                                    <option style="color: gray" selected="selected" hidden="hidden"> {{trans('strings.work_type_label')}} </option>
                                    @foreach($work_types as $work_ty)
                                    <option value="{{$work_ty->work_id}}">{{$work_ty->name}}</option>
                                    @endforeach
                                </optgroup>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">{{trans('strings.type_domain')}}</label>
                        <div class="col-md-9">
                            <select id="degreeSelect" class="form-control js-teachers" type="text" name="type_id">
                                <optgroup  label="{{trans('strings.type_domain_label')}}">
                                    <option style="color: gray" selected="selected" hidden="hidden"> {{trans('strings.type_domain_label')}} </option>
                                    @foreach($types as $w_ty)
                                    <option value="{{$w_ty->type_id}}">{{$w_ty->name}}</option>
                                    @endforeach
                                </optgroup>
                            </select>
                        </div>
                    </div>
                    <!-- Country -->

                    <div class="form-group">
                        <label class="col-md-3 control-label">{{trans('strings.place_country')}}</label>
                        <div class="col-md-9">
                            <select onchange="getStates(this.value())" id="countrySelect" class="form-control js-regionals" type="text" name="countery_id">
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
                        <label class="col-md-3 control-label">{{trans('strings.work_place_2')}}</label>
                        <div class="col-md-9">
                            <input type="text" name="work_place_2" class="form-control" placeholder="{{trans('strings.work_place_2_placeholder')}}" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">{{trans('strings.st_date')}}</label>
                            <div class="col-md-9">
                                <input type="text"  name="start_date" id="from-datepicker" class="form-control datepicker" value="2014-08-04">
                            </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">{{trans('strings.end_date')}}</label>
                            <div class="col-md-9">
                                <input type="text"  name="end_date" id="from-datepicker" class="form-control datepicker" value="2014-08-04">
                            </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">{{trans('strings.work_decrip')}}</label>
                        <div class="col-md-9">
                            <input type="text" name="decrip" class="form-control" placeholder="{{trans('strings.decrip_placeholder')}}" />
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
     <form id='update-contacts' contacts method="post" enctype="multipart/form-data" class="form-horizontal" role="form">
        <div class="modal fade" id="editContactModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">{{trans('strings.upd-new')}} : {{trans('strings.UPD_exp')}}</h5>

              </div>
              <div class="modal-body" id="modal-update-contacts-form-form">

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


                <!-- START BREADCRUMB -->
                <ul class="breadcrumb">
                    <li><a href="/">{{trans('strings.Home')}}</a></li>
                     <li><a href="/experiences/index">{{trans('strings.experiences')}}</a></li>
                    <li class="active">{{trans('strings.sc_experiences')}}</li>
                </ul>
                <!-- END BREADCRUMB -->


                    <!-- START CONTENT FRAME TOP -->
                    <div class="content-frame-top">
                        <!-- <div class="page-title">
                            <h2><span class="fa fa-image"></span> Gallery</h2>
                        </div>  -->
                        @if($lang == 'ar')
                        <div class="pull-right" style="margin-left: 10px">
                            <button  data-toggle="modal" data-target="#addSpecialModal" class="btn btn-info"><span class="fa fa-plus"></span>  {{trans('strings.ad_experiences')}}</button>
                            <!-- <button class="btn btn-default content-frame-right-toggle"><span class="fa fa-bars"></span></button> -->
                        </div>
                        @elseif($lang =='en')
                        <div class="pull-left" style="margin-left:10px">
                            <button data-toggle="modal" data-target="#addSpecialModal" class="btn btn-info"><span class="fa fa-plus"></span> {{trans('strings.ad_experiences')}}</button>
                        </div>
                            @endif
                    </div>

                    <!-- END CONTENT FRAME RIGHT -->

                    <!-- START CONTENT FRAME BODY -->
                    <div class="content-frame-body content-frame-body-left">
                            <div class="page-content-wrap">
                    <div class="row">
                        <div class="col-md-12">
                            <!-- START DEFAULT DATATABLE -->
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title pull-left"><span class="fa fa-opencart"></span>  {{trans('strings.Report of experiences')}} <span class="fa fa-eye"></span></h3>
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
                                                <th>{{trans('strings.job')}}</th>
                                                <th>{{trans('strings.tr_exp_institute')}}</th>
                                                <th>{{trans('strings.tr_countery')}}</th>
                                                <th>{{trans('strings.work_type')}}</th>
                                                <th>{{trans('strings.st_date')}}</th>
                                                <th>{{trans('strings.end_date')}}</th>


                                            <th>{{trans('strings.Actions')}}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                         @foreach($experiences as $experienc)
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


                                            <td>
                                                <button onclick='update_contacts(this.id)' id="{{$experienc->exp_id}}" class="btn btn-default btn-rounded btn-sm"><span class="fa fa-pencil"></span></button>
                                                <button onclick='$("#confirm_delete_experiences").attr("data",this.id);'
                                                    id="{{$experienc->exp_id}}"
                                                    class="btn btn-danger btn-rounded btn-sm mb-control"
                                                    data-box="#delete_contacts"><span class="fa fa-times"></span>
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
