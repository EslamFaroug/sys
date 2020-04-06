@php
    $lang = Session::get('lang');
    \App::setLocale($lang);
@endphp

@extends('layouts.admin')

@section('title') {{trans('strings.conf_title')}}
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

         $("#update-conferences").submit(function(event){
            var form = $(this)[0];
            var formData = new FormData(form);

            $.ajax({
                url: "{{url('/conferences/update')}}/"+form['conf_id'].value,
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

        function destroy_conferences(id) {
            $.ajax({
                url: "{{url('/conferences/destroy')}}/"+id,
                type: 'POST',
                data: '_token={{csrf_token()}}',
                success: function(res) {
                    refersh();
                }
            });
        }

        function update_conferences(id) {
            $.ajax({
                url: '/conferences/edit/'+id,
                type: 'POST',
                data: '_token={{csrf_token()}}',
                success: function(res) {
                    $('#modal-update-regionals-form-form').html(res);
                    $("#editRegionalModal").modal();
                }
            });
        }

        function refersh() {
            document.location.href = document.location.href;
        }

        $('#toggle_all_regionals').click(function(){
            $('.states_table_actions').each(function(i,e){
                $(e).prop('checked', false);
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
        })

    </script>

@endsection

@section('javascript')
$(document).ready(function(){
});
@endsection

@section('contents')


     <!-- Start Delete Alert -->

    <div class="message-box animated fadeIn" data-sound="alert" id="delete_conferences">
            <div class="mb-container">
                @if($lang == 'ar')
                <div class="mb-middle pull-right">
                    <div class="mb-title"><span class="fa fa-sign-out"></span> {{trans('strings.delete')}}<strong>{{trans('strings.co_d')}}</strong> ! </div>
                    <div class="mb-content">
                        <p>{{trans('strings.delete-alert-message-prompt-conf_del')}}</p>
                        <p>{{trans('strings.delete-alert-message-hint')}}.</p>
                    </div>
                    <div class="mb-footer">
                        <div class="pull-right">
                            <button id="confirm_delete_conferences" data="" onclick='destroy_conferences($(this).attr("data"))'  class="btn btn-success btn-lg">{{trans('strings.yes')}}</button>
                            <button class="btn btn-default btn-lg mb-control-close">{{trans('strings.no')}}</button>
                        </div>
                    </div>
                </div>
                @elseif($lang == 'en')
                <div class="mb-middle">
                    <div class="mb-title"><span class="fa fa-sign-out"></span> {{trans('strings.delete')}} <strong>{{trans('strings.co_d')}}</strong> ?</div>
                    <div class="mb-content">
                        <p>{{trans('strings.delete-alert-message-prompt-conf_del')}}</p>
                        <p>{{trans('strings.delete-alert-message-hint')}}.</p>
                    </div>
                    <div class="mb-footer">
                        <div class="pull-right">
                            <button id="confirm_delete_conferences" data="" onclick='destroy_conferences($(this).attr("data"))'  class="btn btn-success btn-lg">{{trans('strings.yes')}}</button>
                            <button class="btn btn-default btn-lg mb-control-close">{{trans('strings.no')}}</button>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>

    <!-- End Delete Alert -->
    <!-- Start Modal Frame -->
    <form id='store-conferences' action="/conferences/store" method="post" enctype="multipart/form-data" class="form-horizontal" role="form">
        <div class="modal fade" id="addRegionalModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle"> {{trans('strings.add-new')}} : {{trans('strings.upd_conf')}}</h5>
                <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: 0px">
                  <span aria-hidden="true">&times;</span>
                </button> -->
              </div>
              <div class="modal-body" id="modal_create_state">
                 {{csrf_field()}}
                    <div class="form-group">
                        <label class="col-md-3 control-label">{{trans('strings.t_name')}}</label>
                        <div class="col-md-9">
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
                    <label class="col-md-3 control-label">{{trans('strings.conf-input-name')}}</label>
                        <div class="col-md-9">
                             <input type="text" name="name" id="name" required="
                                " class="form-control" placeholder="{{trans('strings.Enter conf name')}}" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">{{trans('strings.select_country')}}</label>
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
                        <label class="col-md-3 control-label">{{trans('strings.select_state')}}</label>
                        <div class="col-md-9">
                            <select disabled id="stateSelect" class="form-control js-regionals" name="state_id">
                                <option selected="selected">{{trans('strings.select_st_first')}}</option>
                            </select>
                        </div>
                    </div>
                    <!-- <div class="form-group">
                    <label class="col-md-3 control-label">{{trans('strings.participant')}}</label>
                        <div class="col-md-9">
                             <input type="text" name="participant" id="participant" required="
                                " class="form-control" placeholder="{{trans('strings.Enter conf name')}}" />
                        </div>
                    </div> -->
                    <div class="form-group">
                        <label class="col-md-3 control-label">{{trans('strings.participant_type')}}</label>
                            <div class="col-md-4">
                            <label class="check"><input type="radio" id="participants" class="iradio" name="participant" value="2" />  {{trans('strings.participants')}}</label>
                            </div>
                            <div class="col-md-4">
                            <label class="check"><input type="radio" id="member" class="iradio" name="participant" value="1" checked="checked"/>  {{trans('strings.member')}} </label>
                            </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">{{trans('strings.conf_date')}}</label>
                            <div class="col-md-9">
                                <input type="text"  name="conf_date" id="from-datepicker" class="form-control datepicker" value="2014-08-04">
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
     <form id='update-conferences' states method="post" enctype="multipart/form-data" class="form-horizontal" role="form">
        <div class="modal fade" id="editRegionalModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">{{trans('strings.upd-new')}} : {{trans('strings.upd_conf')}}</h5>

              </div>
              <div class="modal-body" id="modal-update-regionals-form-form">



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
                     <li><a href="/conferences/index">{{trans('strings.conferenece')}}</a></li>
                    <li class="active">{{trans('strings.sc_conf')}}</li>
                </ul>
                <!-- END BREADCRUMB -->


                    <!-- START CONTENT FRAME TOP -->
                    <div class="content-frame-top">

                        @if($lang == 'ar')
                        <div class="pull-right" style="margin-left: 10px">
                            <button  data-toggle="modal" data-target="#addRegionalModal" class="btn btn-info"><span class="fa fa-plus"></span>  {{trans('strings.add_conf')}}</button>
                        </div>
                        @elseif($lang =='en')
                        <div class="pull-left" style="margin-left:10px">
                            <button data-toggle="modal" data-target="#addRegionalModal" class="btn btn-info"><span class="fa fa-plus"></span> {{trans('strings.add_conf')}}</button>
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
                                    <h3 class="panel-title pull-left"><span class="fa fa-opencart"></span>  {{trans('strings.conf_view')}} <span class="fa fa-eye"></span></h3>
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
                                                <th>{{trans('strings.conf_nane')}}</th>
                                                <th>{{trans('strings.St_country')}}</th>
                                                <th>{{trans('strings.re_state')}}</th>
                                                <th>{{trans('strings.conf_date')}}</th>
                                                <th>{{trans('strings.participant_type')}}</th>
                                                <th>{{trans('strings.Actions')}}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                         @foreach($conferences as $conf)
                                            <tr>
                                                <td>{{$loop -> index+1}}</td>
                                                <td>{{$conf -> teachers->ar_name}}</td>
                                                <td>{{$conf->name}}</td>
                                                <td>{{$conf->countreis->name}}</td>
                                                <td>{{$conf->states->name}}</td>

                                                <td>{{$conf->conf_date}}</td>
                                                <td>
                                                @if($conf->participant == 1)
                                                    {{trans('strings.member')}}
                                                @elseif($conf->participant == 2)
                                                    {{trans('strings.participants')}}
                                                @endif
                                                </td>
                                                <td>

                                                <button onclick='update_conferences(this.id)' id="{{$conf->conf_id}}" class="btn btn-success btn-rounded btn-sm"><span class="fa fa-pencil"></span>
                                                </button>
                                                <button onclick='$("#confirm_delete_conferences").attr("data",this.id);'
                                                    id="{{$conf->conf_id}}"
                                                    class="btn btn-danger btn-rounded btn-sm mb-control"
                                                    data-box="#delete_conferences"><span class="fa fa-times"></span>
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
