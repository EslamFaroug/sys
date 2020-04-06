@php
    $lang = Session::get('lang');
    \App::setLocale($lang);
@endphp

@extends('layouts.admin')

@section('title') {{trans('strings.contact_title')}}
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

        $("#store-contacts").submit(function(event){

            $.ajax({
                url: "{{url('/tr_contact/store')}}",
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

         $("#update-contacts").submit(function(event){
            var form = $(this)[0];
            var formData = new FormData(form);
            $.ajax({
                url: "{{url('/tr_contact/update')}}",
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

        function destroy_contacts(id) {
            $.ajax({
                url: "{{url('/tr_contact/destroy')}}/"+id,
                type: 'POST',
                data: '_token={{csrf_token()}}',
                success: function(res) {
                    refersh();
                }
            });
        }

        function update_contacts(id) {
            $.ajax({
                url: '/tr_contact/edit/'+id,
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

// Address Information:=>

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
        })


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
        })


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
                    <div class="mb-title"><span class="fa fa-sign-out"></span> {{trans('strings.delete')}}<strong>{{trans('strings.contact_info')}}</strong> ! </div>
                    <div class="mb-content">
                        <p>{{trans('strings.delete-alert-message-prompt-contact')}}</p>
                        <p>{{trans('strings.delete-alert-message-hint')}}.</p>
                    </div>
                    <div class="mb-footer">
                        <div class="pull-right">
                            <button id="confirm_delete_contacts" data="" onclick='destroy_contacts($(this).attr("data"))'  class="btn btn-success btn-lg">{{trans('strings.yes')}}</button>
                            <button class="btn btn-default btn-lg mb-control-close">{{trans('strings.no')}}</button>
                        </div>
                    </div>
                </div>
                @elseif($lang == 'en')
                <div class="mb-middle">
                    <div class="mb-title"><span class="fa fa-sign-out"></span> {{trans('strings.delete')}} <strong>{{trans('strings.contact_info')}}</strong> ?</div>
                    <div class="mb-content">
                        <p>{{trans('strings.delete-alert-message-prompt-contact')}}</p>
                        <p>{{trans('strings.delete-alert-message-hint')}}.</p>
                    </div>
                    <div class="mb-footer">
                        <div class="pull-right">
                            <button id="confirm_delete_contacts" data="" onclick='destroy_contacts($(this).attr("data"))'  class="btn btn-success btn-lg">{{trans('strings.yes')}}</button>
                            <button class="btn btn-default btn-lg mb-control-close">{{trans('strings.no')}}</button>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>

    <!-- End Delete Alert -->
    <!-- Start Modal Frame -->
    <form id='store-contacts' action="tr_contact/store" method="post" enctype="multipart/form-data" class="form-horizontal" role="form">
        <div class="modal fade" id="addSpecialModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle"> {{trans('strings.add-new')}} : {{trans('strings.AD_contact')}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: 0px">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body" id="modal_create_special">

                 {{csrf_field()}}

                    <div class="form-group">
                        <label class="col-md-4 control-label">{{trans('strings.t_name')}}</label>
                        <div class="col-md-8">
                            <select id="teacherSelect" class="form-control js-teachers" type="text" name="teacher_id">
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
                        <label class="col-md-4 control-label">{{trans('strings.tr-email')}} </label>
                        <div class="col-md-8">
                        <input type="email" name="email" class="form-control" placeholder="{{trans('strings.email-input-placeholder')}}"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-4 control-label">{{trans('strings.tr-mobile')}}</label>
                        <div class="col-md-8">
                            <input type="text" name="mobile_no" class="form-control" placeholder="{{trans('strings.mobile-input-placeholder')}}" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-4 control-label">{{trans('strings.tr-tel')}}</label>
                        <div class="col-md-8">
                            <input type="text" name="tel_no" class="form-control" placeholder="{{trans('strings.tel-input-placeholder')}}" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-4 control-label">{{trans('strings.tr-home')}}</label>
                        <div class="col-md-8">
                            <input type="text" name="home_no" class="form-control" placeholder="{{trans('strings.tel-input-placeholder')}}" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-4 control-label">{{trans('strings.tr-web')}}</label>
                        <div class="col-md-8">
                            <input type="url" name="tr_web" class="form-control" placeholder="{{trans('strings.web-input-placeholder')}}" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-4 control-label">{{trans('strings.select_university')}}</label>
                        <div class="col-md-8">
                            <select onchange="getColleges(this.value())" id="universitySelect" class="form-control js-specials" type="text" name="university_id">
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
                            <select disabled id="collegeSelect" class="form-control js-specials" name="college_id">
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
                            <select disabled id="specialSelect" class="form-control js-specials" name="special_id">
                                <option selected="selected">{{trans('strings.select_special_first')}}</option>
                            </select>
                        </div>
                    </div>

                    <!-- Address Information-->

                    <!-- Country -->

                    <div class="form-group">
                        <label class="col-md-4 control-label">{{trans('strings.select_country')}}</label>
                        <div class="col-md-8">
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

                    <!-- States -->

                    <div class="form-group">
                        <label class="col-md-4 control-label">{{trans('strings.select_state')}}</label>
                        <div class="col-md-8">
                            <select disabled id="stateSelect" class="form-control js-regionals" name="state_id">
                                <option selected="selected">{{trans('strings.select_st_first')}}</option>
                            </select>
                        </div>
                    </div>

                    <!-- Regionals -->

                    <div class="form-group">
                        <label class="col-md-4 control-label">{{trans('strings.select_regional')}}</label>
                        <div class="col-md-8">
                            <select disabled id="regionalSelect" class="form-control js-units" name="regional_id">
                                <option selected="selected">{{trans('strings.select_reg_first')}}</option>
                            </select>
                        </div>
                    </div>

                    <!-- Units -->

                    <div class="form-group">
                        <label class="col-md-4 control-label">{{trans('strings.unit-input-name')}}</label>
                        <div class="col-md-8">
                            <select disabled id="unitlSelect" class="form-control js-specials" name="unit_id">
                                <option selected="selected">{{trans('strings.select_unit_first')}}</option>
                            </select>
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
     <form id='update-contacts'  method="post" enctype="multipart/form-data" class="form-horizontal" role="form">
        <div class="modal fade" id="editContactModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">{{trans('strings.upd-new')}} : {{trans('strings.UPD_contact')}}</h5>

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
                     <li><a href="/tr_contact/index">{{trans('strings.contacts')}}</a></li>
                    <li class="active">{{trans('strings.sc_contacts')}}</li>
                </ul>
                <!-- END BREADCRUMB -->


                    <!-- START CONTENT FRAME TOP -->
                    <div class="content-frame-top">
                        <!-- <div class="page-title">
                            <h2><span class="fa fa-image"></span> Gallery</h2>
                        </div>  -->
                        @if($lang == 'ar')
                        <div class="pull-right" style="margin-left: 10px">
                            <button  data-toggle="modal" data-target="#addSpecialModal" class="btn btn-info"><span class="fa fa-plus"></span>  {{trans('strings.AD_contact')}}</button>
                        </div>
                        @elseif($lang =='en')
                        <div class="pull-left" style="margin-left:10px">
                            <button data-toggle="modal" data-target="#addSpecialModal" class="btn btn-info"><span class="fa fa-plus"></span> {{trans('strings.AD_contact')}}</button>
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
                                    <h3 class="panel-title pull-left"><span class="fa fa-opencart"></span>  {{trans('strings.Report of Contacts Data')}} <span class="fa fa-eye"></span></h3>
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
                                            <!-- <th>{{trans('strings.ID')}}</th> -->
                                            <th>{{trans('strings.tr_name')}}</th>
                                            <th>{{trans('strings.tr_email')}}</th>
                                            <th>{{trans('strings.tr_mobile')}}</th>
                                            <th>{{trans('strings.tr_tel')}}</th>
                                            <th>{{trans('strings.tr_home')}}</th>
                                            <th>{{trans('strings.tr_website')}}</th>
                                            <th>{{trans('strings.tr_university')}}</th>
                                            <th>{{trans('strings.tr_college')}}</th>
                                            <th>{{trans('strings.tr_department')}}</th>
                                            <th>{{trans('strings.tr_specialization')}}</th>
                                            <th>{{trans('strings.tr_countery')}}</th>
                                            <th>{{trans('strings.tr_state')}}</th>
                                            <th>{{trans('strings.tr_regional')}}</th>
                                            <th>{{trans('strings.tr_unit')}}</th>
                                            <th>{{trans('strings.Actions')}}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                         @foreach($contacts as $contact)
                                            <tr>
                                            <!-- <td>{{$loop -> index+1}}</td> -->
                                            <td>{{$contact->teachers->ar_name}}</td>
                                            <td>{{$contact->email}}</td>
                                            <td>{{$contact->mobile_no}}</td>
                                            <td>{{$contact->tel_no}}</td>
                                            <td>{{$contact->home_no}}</td>
                                            <td>{{$contact->tr_web}}</td>
                                            <td>@if($contact->university_id){{$contact->universities->name}} @endif</td>
                                            <td>@if($contact->college_id){{$contact->colleges->name}} @endif</td>
                                            <td>@if($contact->depart_id){{$contact->departments->name}} @endif</td>
                                            <td>@if($contact->special_id){{$contact->specials->name}} @endif</td>
                                            <td>@if($contact->countery_id){{$contact->countreis->name}} @endif</td>
                                            <td>@if($contact->state_id){{$contact->states->name}} @endif</td>
                                            <td>@if($contact->regional_id){{$contact->regionals->name}} @endif</td>
                                            <td>@if($contact->unit_id){{$contact->units->name}} @endif</td>
                                            <td>
                                                <button onclick='update_contacts(this.id)' id="{{$contact->contact_id}}" class="btn btn-default btn-rounded btn-sm"><span class="fa fa-pencil"></span></button>
                                                <button onclick='$("#confirm_delete_contacts").attr("data",this.id);'
                                                    id="{{$contact->contact_id}}"
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
