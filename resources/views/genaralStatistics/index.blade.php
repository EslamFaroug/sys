@php
    $lang = Session::get('lang');
    \App::setLocale($lang);
@endphp

@extends('layouts.admin')

@section('title') {{trans('strings.Genaral_Statistics')}}
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


    <script>

        $("#store-Genaral_Statistics").submit(function(event){
            var form = $(this).serialize();
            $.ajax({
                url: "{{url('/GenaralStatistics/store')}}",
                dataType: "json",
                data: form,
                type: 'post',
                success: function (data) {
                    if (data.status == true) {
                        refersh();



                    }


                }, error: function (errr, exp) {
                    if (errr.status == "419") {

                            window.location.href="{{url('/login')}}";

                    }else {
                        var list = "";
                        $.each(errr.responseJSON.errors, function (index, v) {
                            list +="<li>"+v+"</li>";
                        });
                        $(".label-danger").html(list).show();

                    }

                }


            })

            event.preventDefault();
        });


        function view_genaralStatistic(id) {
            $.ajax({
                url: '/GenaralStatistics/view/',
                type: 'POST',
                data: {_token: '{{csrf_token()}}', id: id},
                success: function(res) {
                    $('#modal-view-Genaral_Statistics').html(res.result);
                    $("#confirm_delete_genaralStatistic").attr("data",id)
                    $("#viewGenaral_Statistics").modal();
                }
            });
        }

        function destroy_Genaral_Statistics(id) {
            $.ajax({
                url: "{{url('/GenaralStatistics/destroy')}}",
                type: 'delete',
                data: {_token: '{{csrf_token()}}', id: id},
                success: function(res) {
                    if(res=="done"){
                        refersh();
                    }
                }
            });
        }


        function visOP(id,op) {
            if(op=="yes"){
                op="no";
            }else{
                op="yes";
            }
            $.ajax({
                url: '/GenaralStatistics/show',
                type: 'POST',
                data: {_token: '{{csrf_token()}}', id: id,show : op},
                success: function(res) {
                    $("#showST"+id).val(res.show);
                    if(res.show=="yes"){

                        $('#visOPArea'+id).removeClass("fa-eye-slash");
                        $('#visOPArea'+id).addClass("fa-eye");
                        if($('#viewShow'+id)){
                            $('#viewShow'+id).removeClass("fa-eye-slash");
                            $('#viewShow'+id).addClass("fa-eye");
                            $('#visOPAreaV'+id).removeClass("fa-eye-slash");
                            $('#visOPAreaV'+id).addClass("fa-eye");
                        }

                    }else{
                        $('#visOPArea'+id).removeClass("fa-eye");
                        $('#visOPArea'+id).addClass("fa-eye-slash");
                        if($('#viewShow'+id)) {
                            $('#viewShow' + id).removeClass("fa-eye");
                            $('#viewShow' + id).addClass("fa-eye-slash");
                            $('#visOPAreaV'+id).removeClass("fa-eye");
                            $('#visOPAreaV'+id).addClass("fa-eye-slash");
                        }
                    }
                }
            });
        }

        function refersh() {
            document.location.href = document.location.href;
        }

        $('#toggle_all_Genaral_Statistics').click(function(){
            $('.Genaral_Statistics_table_actions').each(function(i,e){
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
                 if (Statistic_type.value == "teachers") {
                    $('#universitySelect').attr('disabled', 'disabled');
                    $("#universitySelect").val("");
                    $('#collegeSelect').attr('disabled', 'disabled');
                    $("#collegeSelect").val("");
                    $('#departmentSelect').attr('disabled', 'disabled');
                    $("#departmentSelect").val("");
                    $('#specialSelect').attr('disabled', 'disabled');
                    $("#specialSelect").val("");
                    let uni = $(this).val();
                    let id = typeSelect.value;
                    if (id || uni) {
                        $.ajax({
                            url: '{{url("types_univers/getUniversities")}}',
                            type: 'get',
                            data: {'type': id, 'uni': uni},
                            success: function (response) {
                                $('#universitySelect').html(response);
                                $('#universitySelect').removeAttr('disabled');
                            }
                        });
                    }
                }
            });
        })

        $(document).ready(function(){
            $('#typeSelect').on('change',function() {
                if (Statistic_type.value == "teachers") {
                    $('#universitySelect').attr('disabled', 'disabled');
                $("#universitySelect").val("");
                $('#collegeSelect').attr('disabled', 'disabled');
                $("#collegeSelect").val("");
                $('#departmentSelect').attr('disabled', 'disabled');
                $("#departmentSelect").val("");
                $('#specialSelect').attr('disabled', 'disabled');
                $("#specialSelect").val("");
                let id = $(this).val();
                let uni = countrySelect.value;
                if (id || uni) {
                    $.ajax({
                        url: '{{url("types_univers/getUniversities")}}',
                        type: 'get',
                        data: {'type': id, 'uni': uni},
                        success: function (response) {
                            $('#universitySelect').html(response);
                            $('#universitySelect').removeAttr('disabled');
                            $('#collegeSelect').attr('disabled', 'disabled');
                            $("#collegeSelect").val("");
                            $('#departmentSelect').attr('disabled', 'disabled');
                            $("#departmentSelect").val("");
                            $('#specialSelect').attr('disabled', 'disabled');
                            $("#specialSelect").val("");
                        }
                    });
                }
            }
            });

        })

        $(document).ready(function () {

            $(".Statistic_type").change(function () {
                $("#countrySelect").val("");
                $("#typeSelect").val("");
                $('#universitySelect').attr('disabled','disabled');
                $("#universitySelect").val("");
                $('#collegeSelect').attr('disabled','disabled');
                $("#collegeSelect").val("");
                $('#departmentSelect').attr('disabled','disabled');
                $("#departmentSelect").val("");
                $('#specialSelect').attr('disabled','disabled');
                $("#specialSelect").val("");
                $("#degreeSelect").val("");
                if(this.value=="universities"){
                    $("#Statistic_type").val("universities");
                    $("#countryShow").show();
                    $("#typeShow").show();
                    $("#universityShow").hide();
                    $("#collegeShow").hide();
                    $("#departmentShow").hide();
                    $("#specialShow").hide();
                    $("#degreeShow").hide();
                }else if(this.value=="teachers"){
                    $("#Statistic_type").val("teachers");
                    $("#countryShow").show();
                    $("#typeShow").show();
                    $("#universityShow").show();
                    $("#collegeShow").show();
                    $("#departmentShow").show();
                    $("#specialShow").show();
                    $("#degreeShow").show();
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

    <div class="message-box animated fadeIn" data-sound="alert" id="delete_Genaral_Statistics">
            <div class="mb-container">
                @if($lang == 'ar')
                <div class="mb-middle pull-right">
                    <div class="mb-title"> {{trans('strings.delete')}}  <strong>{{trans('strings.Genaral_Statistic')}}</strong> ! </div>
                    <div class="mb-content">
                        <p>{{trans('strings.delete-alert-message-hint')}}.</p>
                    </div>
                    <div class="mb-footer">
                        <div class="pull-right">
                            <button id="confirm_delete_genaralStatistic" data="" onclick='destroy_Genaral_Statistics($(this).attr("data"))'  class="btn btn-success btn-lg">{{trans('strings.yes')}}</button>
                            <button class="btn btn-default btn-lg mb-control-close">{{trans('strings.no')}}</button>
                        </div>
                    </div>
                </div>
                @elseif($lang == 'en')
                <div class="mb-middle">
                    <div class="mb-title"> {{trans('strings.delete')}}  <strong>{{trans('strings.Genaral_Statistic')}}</strong> ?</div>
                    <div class="mb-content">
                        <p>{{trans('strings.delete-alert-message-hint')}}.</p>
                    </div>
                    <div class="mb-footer">
                        <div class="pull-right">
                            <button id="confirm_delete_Genaral_Statistics" data="" onclick='destroy_Genaral_Statistics($(this).attr("data"))'  class="btn btn-success btn-lg">{{trans('strings.yes')}}</button>
                            <button class="btn btn-default btn-lg mb-control-close">{{trans('strings.no')}}</button>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>

    <!-- End Delete Alert -->
    <!-- Start Modal Frame -->
    <form id='store-Genaral_Statistics' action="GenaralStatistics/store" method="post" enctype="multipart/form-data" class="form-horizontal" role="form">
        <div class="modal fade" id="addSpecialModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle"> {{trans('strings.add-new')}} : {{trans('strings.Genaral_Statistics')}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: 0px">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body" id="modal_create_special">
                  <div class="label-danger" style="display: none;">
                  </div>

                 {{csrf_field()}}


                    <div class="form-group">
                        <label class="col-md-3 control-label" style="text-align: right;">{{trans('strings.Statistic_title')}} </label>
                        <div class="col-md-9">
                        <input type="text" required name="Statistic_title" class="form-control" placeholder="{{trans('strings.Statistic_title')}}"/>
                        </div>
                    </div>
                  <div class="form-group">
                      <label class="col-md-3 control-label" style="text-align: right;">{{trans('strings.visibility')}}</label>
                      <div class="col-md-9">
                          <div class="form-group">
                              <div class="col-lg-4 col-md-4 col-sm-4">
                                  <label class="check"><input type="radio" checked="" required value="yes" class="iradio" name="visibility"/> {{trans('strings.yes')}}</label>
                              </div>
                              <div class="col-lg-4 col-md-4 col-sm-4">
                                  <label class="check"><input type="radio" required value="no" class="iradio" name="visibility" /> {{trans('strings.no')}}</label>
                              </div>
                          </div>
                      </div>
                  </div>

                  <div class="form-group">
                      <label class="col-md-3 control-label" style="text-align: right;">{{trans('strings.Statistic_type')}}</label>
                      <div class="col-md-9">
                          <div class="form-group">
                              <div class="col-lg-4 col-md-4 col-sm-4">
                                  <input type="hidden" id="Statistic_type">
                                  <label class="check"><input type="radio" required value="universities" class="iradio Statistic_type" name="Statistic_type"/> {{trans('strings.Universities')}}</label>
                              </div>
                              <div class="col-lg-4 col-md-4 col-sm-4">
                                  <label class="check"><input type="radio" required value="teachers" class="iradio Statistic_type" name="Statistic_type" /> {{trans('strings.Teachers')}}</label>
                              </div>
                          </div>
                      </div>
                  </div>

                  <div class="form-group"  id="countryShow" style="display: none;">
                      <label class="col-md-3 control-label" style="text-align: right;">{{trans('strings.select_country')}}</label>
                      <div class="col-md-9">
                          <select id="countrySelect" class="form-control js-universities" type="text" name="countery_id">
                              <optgroup  label="{{trans('strings.select_state-label')}}">
                                  <option style="color: gray" value=""> {{trans('strings.select_state-label')}} </option>
                                  @foreach($countreis as $count)
                                      <option value="{{$count->countery_id}}">{{$count->name}}</option>
                                  @endforeach
                              </optgroup>
                          </select>
                      </div>
                  </div>
                  <div class="form-group"  id="typeShow" style="display: none;">
                      <label class="col-md-3 control-label" style="text-align: right;">{{trans('strings.University_type')}}</label>
                      <div class="col-md-9">
                          <select  id="typeSelect" class="form-control js-universities" type="text" name="type_id">
                              <optgroup  label="{{trans('strings.University_type')}}">
                                  <option style="color: gray" selected="selected" value="" > {{trans('strings.select type')}} </option>
                                  @foreach($types as $type)
                                      <option value="{{$type->type_id}}">{{$type->name}}</option>
                                  @endforeach
                              </optgroup>
                          </select>
                      </div>
                  </div>

                  <div class="form-group" id="universityShow" style="display: none;">
                        <label class="col-md-3 control-label" style="text-align: right;">{{trans('strings.select_university')}}</label>
                        <div class="col-md-9">
                            <select disabled id="universitySelect" class="form-control js-specials" type="text" name="university_id">
                                <optgroup  label="{{trans('strings.select_univers-label')}}">
                                    <option style="color: gray" selected="selected" value=""> {{trans('strings.select type')}} </option>
                                </optgroup>
                            </select>
                        </div>
                    </div>
                    <div class="form-group"  id="collegeShow" style="display: none;">
                        <label class="col-md-3 control-label" style="text-align: right;">{{trans('strings.select_college')}}</label>
                        <div class="col-md-9">
                            <select disabled id="collegeSelect" class="form-control js-specials" name="id">
                                <option selected="selected" value="">{{trans('strings.select_college_first')}}</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group"  id="departmentShow" style="display: none;">
                        <label class="col-md-3 control-label" style="text-align: right;">{{trans('strings.special_depart')}}</label>
                        <div class="col-md-9">
                            <select disabled id="departmentSelect" class="form-control js-specials" name="depart_id">
                                <option selected="selected"  value="">{{trans('strings.select_depart_first')}}</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group"  id="specialShow" style="display: none;">
                        <label class="col-md-3 control-label" style="text-align: right;">{{trans('strings.special-input-name')}}</label>
                        <div class="col-md-9">
                            <select disabled id="specialSelect" class="form-control js-specials" name="special_id">
                                <option selected="selected"  value="">{{trans('strings.select_special_first')}}</option>
                            </select>
                        </div>
                    </div>

                  <div class="form-group"  id="degreeShow" style="display: none;">
                      <label class="col-md-3 control-label" style="text-align: right;">{{trans('teacher.degree')}}</label>
                      <div class="col-md-9">
                          <select id="degreeSelect" class="form-control js-teachers" type="text" name="degree_id">
                              <optgroup  label="{{trans('teacher.select_degree-label')}}">
                                  <option style="color: gray" selected="selected" value=""> {{trans('teacher.select_degree-label')}} </option>
                                  @foreach($degrees as $degree)
                                      <option value="{{$degree->degree_id}}">{{$degree->name}}</option>
                                  @endforeach
                              </optgroup>
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
     <div class="modal fade" id="viewGenaral_Statistics" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
         <div class="modal-dialog modal-dialog-centered" role="document">
             <div class="modal-content">
                 <div class="modal-header">
                     <h5 class="modal-title" id="exampleModalLongTitle">{{trans('strings.viw-new')}} : {{trans('strings.Genaral_Statistic')}}</h5>

                 </div>
                 <div class="modal-body" id="modal-view-Genaral_Statistics">
                 </div>
                 <div class="modal-footer">
                     <button type="button"
                             class="btn btn-danger"
                             data-box="#delete_Genaral_Statistics">{{trans('strings.delete')}}</button>
                     <button type="button" class="btn btn-secondary" data-dismiss="modal">{{trans('strings.close')}}</button>

                 </div>
             </div>
         </div>
     </div>
    <!-- End Modal Frame -->

                <!-- START BREADCRUMB -->
                <ul class="breadcrumb">
                    <li><a href="/">{{trans('strings.Home')}}</a></li>
                    <li class="active">{{trans('strings.Genaral_Statistics')}}</li>
                </ul>
                <!-- END BREADCRUMB -->


                    <!-- START CONTENT FRAME TOP -->
                    <div class="content-frame-top">
                        <!-- <div class="page-title">
                            <h2><span class="fa fa-image"></span> Gallery</h2>
                        </div>  -->
                        @if($lang == 'ar')
                        <div class="pull-right" style="margin-left: 10px">
                            <button  data-toggle="modal" data-target="#addSpecialModal" class="btn btn-info"><span class="fa fa-plus"></span>  {{trans('strings.Genaral_Statistics')}}</button>
                        </div>
                        @elseif($lang =='en')
                        <div class="pull-left" style="margin-left:10px">
                            <button data-toggle="modal" data-target="#addSpecialModal" class="btn btn-info"><span class="fa fa-plus"></span> {{trans('strings.Genaral_Statistics')}}</button>
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
                                    <h3 class="panel-title pull-left"><span class="fa fa-opencart"></span>  {{trans('strings.Genaral_Statistics')}} <span class="fa fa-eye"></span></h3>
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
                                            <th>{{trans('strings.Statistic_title')}}</th>
                                            <th>{{trans('strings.Statistic_type')}}</th>
                                            <th>{{trans('strings.visibility')}}</th>
                                            <th>{{trans('strings.countery-title')}}</th>
                                            <th>{{trans('strings.University_type')}}</th>
                                            <th>{{trans('strings.degree')}}</th>
                                            <th>{{trans('strings.Actions')}}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($genaralStatistics as $genaralStatistic)
                                            <tr>
                                                <td style="text-align: center;">{{$loop -> index+1}}</td>
                                                <td style="text-align: center;">{{$genaralStatistic->title}}</td>
                                                <td  style="text-align: center;">
                                                    @if($genaralStatistic->Type=="teachers")
                                                    {{trans("strings.Teachers")}}
                                                        @else
                                                        {{trans("strings.Universities")}}
                                                    @endif

                                                </td>
                                                <td  style="text-align: center;" id="show{{$genaralStatistic->id}}">
                                                     <input type="hidden" id="showST{{$genaralStatistic->id}}" value="{{$genaralStatistic->show}}">
                                                        <button class="btn btn-default btn-rounded btn-sm mb-control" onclick="visOP(this.id,showST{{$genaralStatistic->id}}.value)" id="{{$genaralStatistic->id}}" ><i id="visOPArea{{$genaralStatistic->id}}" class="fa @if($genaralStatistic->show=="yes") fa-eye @else fa-eye-slash @endif"></i></button>

                                                </td>
                                                <td  style="text-align: center;">@if($genaralStatistic->countery_id) {{$genaralStatistic->countery->name}} @else  {{trans("strings.All_Countries")}} @endif</td>
                                                <td  style="text-align: center;">@if($genaralStatistic->type_id) {{$genaralStatistic->type->name}}  @else  {{trans("strings.All_Universities_type")}} @endif</td>
                                                <td  style="text-align: center;">@if($genaralStatistic->degree_id) {{$genaralStatistic->degree->name}}  @else  {{trans("strings.All_Degrees")}} @endif</td>
                                                <td  style="text-align: center;">
                                                    <button onclick='view_genaralStatistic(this.id)'
                                                            id="{{$genaralStatistic->id}}"
                                                            class="btn btn-info btn-rounded btn-sm mb-control"><i class="fa fa-list"></i></button>
                                                    <button
                                                        onclick='$("#confirm_delete_genaralStatistic").attr("data",this.id);'
                                                        id="{{$genaralStatistic->id}}"
                                                        class="btn btn-danger btn-rounded btn-sm mb-control"
                                                        data-box="#delete_Genaral_Statistics"><i class="fa fa-times"></i></button>
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
