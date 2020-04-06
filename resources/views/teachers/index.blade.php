@php
    $lang = Session::get('lang');
    \App::setLocale($lang);
@endphp

@extends('layouts.admin')

@section('title') {{trans('teacher.teacher_title')}}
@endsection


<!-- @section('inner-title')
    {{trans('teacher.countreis-title')}}
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

        $("#store-teachers").submit(function(event){

            $.ajax({
                url: "{{url('/teachers/store')}}",
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

         $("#update-teachers").submit(function(event){
            var form = $(this)[0];
            var formData = new FormData(form);

            $.ajax({
                url: "{{url('/teachers/update')}}/"+form['teacher_id'].value,
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

        function destroy_teachers(id) {
            $.ajax({
                url: "{{url('/teachers/destroy')}}/"+id,
                type: 'POST',
                data: '_token={{csrf_token()}}',
                success: function(res) {
                    refersh();
                }
            });
        }

        function update_teachers(id) {
            $.ajax({
                url: '/teachers/edit/'+id,
                type: 'POST',
                data: '_token={{csrf_token()}}',
                success: function(res) {
                    $('#modal-update-teachers-form').html(res);
                    $("#editTeacherModal").modal();
                }
            });
        }

        function refersh() {
            document.location.href = document.location.href;
        }

        $('#toggle_all_teachers').click(function(){
            $('.teachers_table_actions').each(function(i,e){
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

    <div class="message-box animated fadeIn" data-sound="alert" id="delete_teachers">
            <div class="mb-container">
                @if($lang == 'ar')
                <div class="mb-middle pull-right">
                    <div class="mb-title"><span class="fa fa-sign-out"></span> {{trans('strings.delete')}}<strong>{{trans('strings.tech_title')}}</strong> ! </div>
                    <div class="mb-content">
                        <p>{{trans('strings.delete-alert-message-prompt-tech')}}</p>
                        <p>{{trans('strings.delete-alert-message-hint')}}.</p>
                    </div>
                    <div class="mb-footer">
                        <div class="pull-right">
                            <button id="confirm_delete_teachers" data="" onclick='destroy_teachers($(this).attr("data"))'  class="btn btn-success btn-lg">{{trans('strings.yes')}}</button>
                            <button class="btn btn-default btn-lg mb-control-close">{{trans('strings.no')}}</button>
                        </div>
                    </div>
                </div>
                @elseif($lang == 'en')
                <div class="mb-middle">
                    <div class="mb-title"><span class="fa fa-sign-out"></span> {{trans('strings.delete')}} <strong>{{trans('strings.tech_title')}}</strong> ?</div>
                    <div class="mb-content">
                        <p>{{trans('strings.delete-alert-message-prompt-tech')}}</p>
                        <p>{{trans('strings.delete-alert-message-hint')}}.</p>
                    </div>
                    <div class="mb-footer">
                        <div class="pull-right">
                            <button id="confirm_delete_teachers" data="" onclick='destroy_teachers($(this).attr("data"))'  class="btn btn-success btn-lg">{{trans('strings.yes')}}</button>
                            <button class="btn btn-default btn-lg mb-control-close">{{trans('strings.no')}}</button>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>

    <!-- End Delete Alert -->

    <!-- Start Modal Frame -->
    <form id='store-teachers'  method="post" enctype="multipart/form-data" class="form-horizontal" role="form">
        <div class="modal fade" id="addTeacherModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle"> {{trans('strings.add-new')}} : {{trans('teacher.ADD te_basic')}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: 0px">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body" id="modal_create_countery">

                        {{csrf_field()}}
                        <div class="form-group">
                        <label class="col-md-3 control-label">{{trans('teacher.AR_Name')}}</label>
                        <div class="col-md-9">
                            <input type="text" name="ar_name" required="
                                " class="form-control" placeholder="{{trans('teacher.Enter arbic name')}}" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label">{{trans('teacher.en_name')}}</label>
                        <div class="col-md-9">
                            <input type="text" name="en_name" required="
                                " class="form-control" placeholder="{{trans('teacher.Enter englisg name')}}" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label">{{trans('teacher.card_id')}}</label>
                        <div class="col-md-9">
                            <input type="text" name="card_id" required="
                                " class="form-control" placeholder="{{trans('teacher.Enter card name')}}" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label">{{trans('teacher.dob')}}</label>
                            <div class="col-md-9">
                                <input type="text"  name="dob" id="from-datepicker" class="form-control datepicker" value="2014-08-04">
                            </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label">{{trans('teacher.pob')}}</label>
                        <div class="col-md-9">
                            <input type="text" name="pob" required="
                                " class="form-control" placeholder="{{trans('teacher.Enter pob name')}}" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label">{{trans('teacher.gender')}}</label>
                            <div class="col-md-4">
                            <label class="check"><input type="radio" id="female" class="iradio" name="gender" value="2" />  {{trans('teacher.female')}}</label>
                            </div>
                            <div class="col-md-4">
                            <label class="check"><input type="radio" id="male" class="iradio" name="gender" value="1" checked="checked"/>  {{trans('teacher.male')}} </label>
                            </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">{{trans('teacher.status')}}</label>
                        <div class="col-md-9">
                            <select id="status" class="form-control js-states" type="text" name="status">
                                <optgroup  label="{{trans('teacher.status-label')}}">
                                    <option style="color: gray" selected="selected" hidden="hidden"> {{trans('teacher.status-label')}} </option>
                                    @foreach($martialStatus as $key => $mar)
                                    <option value="{{$key}}">{{$mar}}</option>
                                    @endforeach
                                </optgroup>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label">{{trans('teacher.mother_tounge')}}</label>
                        <div class="col-md-9">
                            <select id="mother_tounge" class="form-control js-teachers" type="text" name="mother_tounge">
                                <optgroup  label="{{trans('teacher.language-label')}}">
                                    <option style="color: gray" selected="selected" hidden="hidden"> {{trans('teacher.language-label')}} </option>
                                    @foreach($languages as $key => $language)
                                    <option value="{{$key}}">{{$language}}</option>
                                    @endforeach
                                </optgroup>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label">{{trans('teacher.national_id')}}</label>
                        <div class="col-md-9">
                            <select id="countrySelect" class="form-control js-teachers" type="text" name="countery_id">
                                <optgroup  label="{{trans('teacher.select_national-label')}}">
                                    <option style="color: gray" selected="selected" hidden="hidden"> {{trans('teacher.select_national-label')}} </option>
                                    @foreach($countreis as $count)
                                    <option value="{{$count->countery_id}}">{{$count->name}}</option>
                                    @endforeach
                                </optgroup>
                            </select>
                        </div>
                    </div>
                  <div class="form-group">
                      <label class="col-md-3 control-label">{{trans('strings.tr-email')}} </label>
                      <div class="col-md-9">
                          <input type="email" required name="email" class="form-control" placeholder="{{trans('strings.email-input-placeholder')}}"/>
                      </div>
                  </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">{{trans('teacher.degree')}}</label>
                        <div class="col-md-9">
                            <select id="degreeSelect" class="form-control js-teachers" type="text" name="degree_id">
                                <optgroup  label="{{trans('teacher.select_degree-label')}}">
                                    <option style="color: gray" selected="selected" hidden="hidden"> {{trans('teacher.select_degree-label')}} </option>
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

    <!-- Start Modal-Update Frame -->

    <!-- Start Modal-Update Frame -->
    <form id='update-teachers' teachers method="post" enctype="multipart/form-data" class="form-horizontal" role="form">
        <div class="modal fade" id="editTeacherModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">{{trans('strings.upd-new')}} : {{trans('teacher.tec_rec')}}</h5>
                <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: 0px">
                  <span aria-hidden="true">&times;</span>
                </button> -->
              </div>
              <div class="modal-body" id="modal-update-teachers-form">



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
                <li><a href="/teachers/index">{{trans('teacher.teachers')}}</a></li>
                <li class="active">{{trans('teacher.sc_teachers')}}</li>
                </ul>
                <!-- END BREADCRUMB -->


                    <!-- START CONTENT FRAME TOP -->
                    <div class="content-frame-top">
                        <!-- <div class="page-title">
                            <h2><span class="fa fa-image"></span> Gallery</h2>
                        </div>  -->
                        @if($lang == 'ar')
                        <div class="pull-right" style="margin-left: 10px">
                            <button  data-toggle="modal" data-target="#addTeacherModal" class="btn btn-info"><span class="fa fa-plus"></span>{{trans('teacher.ADD basic')}}</button>
                        </div>
                        @elseif($lang =='en')
                        <div class="pull-left" style="margin-left:10px">
                            <button data-toggle="modal" data-target="#addTeacherModal" class="btn btn-info"><span class="fa fa-plus"></span>{{trans('teacher.ADD basic')}}</button>
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
                                    <h3 class="panel-title pull-left"><span class="fa fa-opencart"></span>  {{trans('teacher.Report of basic teacher')}} <span class="fa fa-eye"></span></h3>
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
                                            <th>{{trans('teacher.AR_Name')}}</th>
                                            <th>{{trans('teacher.en_name')}}</th>
                                            <th>{{trans('teacher.card_id')}}</th>
                                            <th>{{trans('teacher.dob')}}</th>
                                            <th>{{trans('teacher.pob')}}</th>
                                            <th>{{trans('teacher.gender')}}</th>
                                            <th>{{trans('teacher.status')}}</th>
                                            <th>{{trans('teacher.mother_tounge')}}</th>
                                            <th>{{trans('teacher.national_id')}}</th>
                                            <th>{{trans('teacher.tr_degree')}}</th>
                                            <th>{{trans('teacher.Actions')}}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                         @foreach($teachers as $teacher)
                                            <tr>
                                                <td>{{$loop -> index+1}}</td>
                                                <td>{{$teacher->ar_name}}</td>
                                                <td>{{$teacher->en_name}}</td>
                                                <td>{{$teacher->card_id}}</td>
                                                <td>{{$teacher->dob}}</td>
                                                <td>{{$teacher->pob}}</td>

                                                 <td>
                                                @if($teacher->gender == 1)
                                                    {{trans('teacher.gender_m')}}
                                                @elseif($teacher->gender == 2)
                                                    {{trans('teacher.gender_f')}}
                                                @endif
                                                </td>

                                                <td>@if($teacher->status == 1){{trans('teacher.Single')}}
                                                @elseif($teacher->status == 2){{trans('teacher.Married')}}
                                                @elseif($teacher->status == 3){{trans('teacher.Divorced')}}
                                                @elseif($teacher->status == 4){{trans('teacher.widow')}}
                                                @endif</td>

                                                <td>@if($teacher->mother_tounge == 1){{trans('teacher.Arabic')}}
                                                @elseif($teacher->mother_tounge == 2){{trans('teacher.English')}}
                                                @elseif($teacher->mother_tounge == 3){{trans('teacher.French')}}
                                                @elseif($teacher->mother_tounge == 4){{trans('teacher.German')}}
                                                @elseif($teacher->mother_tounge == 5){{trans('teacher.Swahili')}}
                                                @elseif($teacher->mother_tounge == 6){{trans('teacher.Italian')}}
                                                @endif
                                                </td>

                                                <td>{{$teacher->countreis->name}}</td>
                                                <td>{{$teacher->degrees->name}}</td>
                                                <td>
                                                <button onclick='$("#confirm_delete_certificates").attr("data",this.id);'
                                                    id="{{$teacher->teacher_id}}"
                                                    class="btn btn-info btn-rounded btn-sm mb-control"
                                                    data-box="#"><span class="fa fa-eye"></span>
                                                </button>
                                                <button onclick='update_teachers(this.id)' id="{{$teacher->teacher_id}}" class="btn btn-success btn-rounded btn-sm"><span class="fa fa-pencil"></span>
                                                </button>
                                                <button
                                                    onclick='$("#confirm_delete_teachers").attr("data",this.id);'
                                                    id="{{$teacher->teacher_id}}"
                                                    class="btn btn-danger btn-rounded btn-sm mb-control"
                                                    data-box="#delete_teachers"><span class="fa fa-times"></span></button>
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
