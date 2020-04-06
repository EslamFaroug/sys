@php
    $lang = Session::get('lang');
    \App::setLocale($lang);
@endphp

@extends('layouts.admin')

@section('title') {{trans('strings.research_title')}}
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
    <!-- <script src="{{('/js/bootstrap-datepicker/js/bootstrap-datepicker.js')}}"></script>
    <script src="{{('/js/bootstrap-timepicker/js/bootstrap-timepicker.min.js')}}"></script> -->
    <script>

        function destroy_researches(id) {
            $.ajax({
                url: "{{url('/researches/destroy')}}/"+id,
                type: 'POST',
                data: '_token={{csrf_token()}}',
                success: function(res) {
                    refersh();
                }
            });
        }

        function update_research(id) {
            $.ajax({
                url: '/researches/edit/'+id,
                type: 'POST',
                data: '_token={{csrf_token()}}',
                success: function(res) {
                    $('#modal-update-researches-form-form').html(res);
                    $("#editResearchesModal").modal();
                }
            });
        }
        function view_research(id) {
            $.ajax({
                url: '/researches/view/'+id,
                type: 'POST',
                data: '_token={{csrf_token()}}',
                success: function(res) {
                    $('#modal-view-researches').html(res);
                    $("#viewResearcheModal").modal();
                }
            });
        }

           $("#update-Researches").submit(function(event){
               event.preventDefault();
               var form = $(this)[0];
            var formData = new FormData(form);
               $.ajax({
                url: "{{url('/researches/update')}}/"+form['research_id'].value,
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

        function refersh() {
            document.location.href = document.location.href;
        }
         function displayImageDialog() {
         $("#imgpath_input").trigger("click");
    }

    function displayImage(path) {
        var fReader = new FileReader();
        fReader.readAsDataURL(path.files[0]);
        fReader.onloadend = function(event){
            var img = document.getElementById("imageviewer");
            img.src = event.target.result;
        }

    }
    function getData(id,data) {
        $.ajax({
            url: 'get'+data,
            method: 'post',
            data: 'data='+id+'&_token={{csrf_token()}}',
            success: function(response) {
                $('#'+data).html(response);
                $('#'+data).removeAttr('disabled');
            },
            error: function(d,res) {
                alert('Oops, some thing wrong happen');
            }
        });


    }


    function saveSupervisor() {
        var name = document.getElementById('supname').value;
        var other = document.getElementById('othersupervisorname');
        var hidden = document.getElementById('other_supervisor');
        other.value = name;
        other.innerHTML=name;
        other.setAttribute('selected','selected');
        $('#supervisor_modal').modal('hide');
        hidden.value=1;
    }


    </script>

@endsection

@section('javascript')
    $(document).ready(function(){
});
@endsection

@section('contents')
         <!-- Start Delete Alert -->

    <div class="message-box animated fadeIn" data-sound="alert" id="delete_researches">
        <div class="mb-container">
            @if($lang == 'ar')
            <div class="mb-middle pull-right">
                <div class="mb-title"><span class="fa fa-sign-out"></span> {{trans('strings.delete')}}<strong>{{trans('strings.res_delete')}}</strong> ! </div>
                <div class="mb-content">
                    <p>{{trans('strings.delete-alert-message-prompt-research')}}</p>
                    <p>{{trans('strings.delete-alert-message-hint')}}.</p>
                </div>
                <div class="mb-footer">
                    <div class="pull-right">
                        <button id="confirm_delete_researches" data="" onclick='destroy_researches($(this).attr("data"))'  class="btn btn-success btn-lg">{{trans('strings.yes')}}</button>
                        <button class="btn btn-default btn-lg mb-control-close">{{trans('strings.no')}}</button>
                    </div>
                </div>
            </div>
            @elseif($lang == 'en')
            <div class="mb-middle">
                <div class="mb-title"><span class="fa fa-sign-out"></span> {{trans('strings.delete')}} <strong>{{trans('strings.res_delete')}}</strong> ?</div>
                <div class="mb-content">
                    <p>{{trans('strings.delete-alert-message-prompt-research')}}</p>
                    <p>{{trans('strings.delete-alert-message-hint')}}.</p>
                </div>
                <div class="mb-footer">
                    <div class="pull-right">
                        <button id="confirm_delete_researches" data="" onclick='destroy_researches($(this).attr("data"))'  class="btn btn-success btn-lg">{{trans('strings.yes')}}</button>
                        <button class="btn btn-default btn-lg mb-control-close">{{trans('strings.no')}}</button>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
    <!-- End Delete Alert -->

    <!-- Start Modal Frame -->
    <form id='store-researches' action="/researches/store" method="post" enctype="multipart/form-data" class="form-horizontal" role="form">
        <div class="modal fade" id="addResearchModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle"> {{trans('strings.add-new')}} : {{trans('strings.upd_research')}}</h5>
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
                        <label class="col-md-3 control-label">{{trans('strings.research-input-label')}}</label>
                        <div class="col-md-9">
                            <input type="text" name="title" required="
                                " class="form-control" placeholder="{{trans('strings.research-input-placeholder')}}" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label">{{trans('teacher.degree')}}</label>
                        <div class="col-md-9">
                            <select id="degreeSelect" class="form-control js-teachers" type="text" name="degree_id">
                                <optgroup  label="{{trans('teacher.select_degree-label')}}">
                                    <option style="color: gray" value="" selected="selected" hidden="hidden"> {{trans('teacher.select_degree-label')}} </option>
                                    @foreach($degrees as $degree)
                                    <option value="{{$degree->degree_id}}">{{$degree->name}}</option>
                                    @endforeach
                                </optgroup>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-3" for="degree">{{trans('strings.supper')}}</label>
                            <div class="col-sm-9">
                            <select name="sup_id" id="degree" required="required" class="form-control" placeholder="الدرجة العلمية" >
                            <option disabled="disabled" value="" hidden="hidden" selected="selected">{{trans('strings.tr_supper')}}</option>
                            @foreach($teachers as $tech)
                            <option value="{{$tech->teacher_id}}" >{{$tech->ar_name}}</option>
                            @endforeach
                            </select>
                            </div>
                    </div>
                    <input type="hidden" value="0" id="other_supervisor" name="other_supervisor">
                    <br>
                    <div class="form-group">
                        <label class="col-md-3 control-label">{{trans('strings.publis_date')}}</label>
                            <div class="col-md-9">
                                <input type="text"  name="publish_date" id="from-datepicker" class="form-control datepicker" value="2014-08-04">
                            </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">{{trans('strings.paper-input-place')}}</label>
                        <div class="col-md-9">
                            <input type="text" name="publish_place" required="
                                " class="form-control" placeholder="{{trans('strings.paper-place-placeholder')}}" />
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

    <!-- Start Modal-view Frame -->
         <div class="modal fade" id="viewResearcheModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">{{trans('strings.display')}} : {{trans('strings.upd_research')}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: 0px">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body" id="modal-view-researches">



              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{trans('strings.close')}}</button>
               </div>
            </div>
          </div>
        </div>
     <!-- End Modal Frame -->

         <!-- Start Modal-Update Frame -->
         <form id='update-Researches' papers method="post" enctype="multipart/form-data" class="form-horizontal" role="form">
             <div class="modal fade" id="editResearchesModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                 <div class="modal-dialog modal-dialog-centered" role="document">
                     <div class="modal-content">
                         <div class="modal-header">
                             <h5 class="modal-title" id="exampleModalLongTitle">{{trans('strings.upd-new')}} : {{trans('strings.upd_research')}}</h5>
                             <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: 0px">
                                 <span aria-hidden="true">&times;</span>
                             </button>
                         </div>
                         <div class="modal-body" id="modal-update-researches-form-form">



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


<div class="modal fade" id="supervisor_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form>
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">{{trans('strings.sup_name')}}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

          <div class="form-group">
            <label for="recipient-name" class="form-control-label">{{trans('strings.supr_name')}}</label>
            <input type="text" id="supname" placeholder="{{trans('strings.nams_sup')}}" class="form-control" id="recipient-name">
          </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{trans('strings.close')}}</button>
        <button type="button" onclick='saveSupervisor()' class="btn btn-primary">{{trans('strings.save')}}</button>
      </div>
    </div>
    </form>
  </div>
</div>

    <!-- End Modal Frame -->


                <!-- START BREADCRUMB -->
                <ul class="breadcrumb">
                    <li><a href="/">{{trans('strings.Home')}}</a></li>
                     <li><a href="/researches/index">{{trans('strings.research-table-title')}}</a></li>
                    <li class="active">{{trans('strings.sc_research')}}</li>
                </ul>
                <!-- END BREADCRUMB -->


                    <!-- START CONTENT FRAME TOP -->
                    <div class="content-frame-top">
                        @if($lang == 'ar')
                        <div class="pull-right" style="margin-left: 10px">
                            <button  data-toggle="modal" data-target="#addResearchModal" class="btn btn-info"><span class="fa fa-plus"></span>  {{trans('strings.add_research')}}</button>
                        </div>
                        @elseif($lang =='en')
                        <div class="pull-left" style="margin-left:10px">
                            <button data-toggle="modal" data-target="#addResearchModal" class="btn btn-info"><span class="fa fa-plus"></span> {{trans('strings.add_research')}}</button>
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
                                    <h3 class="panel-title pull-left"><span class="fa fa-opencart"></span>  {{trans('strings.Report of research')}} <span class="fa fa-eye"></span></h3>
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
                                            <th>{{trans('strings.pa_title')}}</th>
                                            <th>{{trans('teacher.tr_degree')}}</th>
                                            <th>{{trans('strings.trr_supper')}}</th>
                                            <th>{{trans('strings.publish_place')}}</th>
                                            <th>{{trans('strings.publis_date')}}</th>
                                            <th>{{trans('strings.Actions')}}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($researches as $research)
                                            <tr>
                                               <td>{{$loop -> index+1}}</td>
                                               <td>{{$research->teachers->ar_name}}</td>
                                                <td>{{$research -> title}}</td>
                                                <td>{{$research->degrees->name}}</td>
                                                <td>
                                                @if($research->supervisor_id !== null)
                                                @foreach($teachers as $teacher)

                                                    @if($teacher->teacher_id == $research->supervisor_id)
                                                    {{$teacher->ar_name}}
                                                    @endif

                                                @endforeach
                                                @else
                                                {{$research ->other_supervisor}}
                                                @endif
                                                </td>
                                                <td>{{$research -> publish_place}}</td>
                                                <td>{{$research -> publish_date}}</td>
                                                <td>
                                                <button onclick='view_research(this.id)'
                                                    id="{{$research->research_id}}"
                                                    class="btn btn-info btn-rounded btn-sm mb-control"><span class="fa fa-eye"></span>
                                                </button>
                                                <button onclick='update_research(this.id)' id="{{$research->research_id}}" class="btn btn-success btn-rounded btn-sm"><span class="fa fa-pencil"></span>
                                                </button>
                                                <button onclick='$("#confirm_delete_researches").attr("data",this.id);'
                                                    id="{{$research->research_id}}"
                                                    class="btn btn-danger btn-rounded btn-sm mb-control"
                                                    data-box="#delete_researches"><span class="fa fa-times"></span>
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
