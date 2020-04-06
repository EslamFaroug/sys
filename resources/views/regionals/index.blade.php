@php 
    $lang = Session::get('lang');
    \App::setLocale($lang);
@endphp

@extends('layouts.admin')

@section('title') {{trans('strings.regionlas_title')}} 
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

        $("#store-regionals").submit(function(event){

            $.ajax({
                url: "{{url('/regionals/store')}}",
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

         $("#update-regionals").submit(function(event){
            var form = $(this)[0];
            var formData = new FormData(form);

            $.ajax({
                url: "{{url('/regionals/update')}}/"+form['regional_id'].value,
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

        function destroy_regionals(id) {
            $.ajax({
                url: "{{url('/regionals/destroy')}}/"+id,
                type: 'POST',
                data: '_token={{csrf_token()}}',
                success: function(res) {
                    refersh();
                }
            });
        }

        function update_regionals(id) {
            $.ajax({
                url: '/regionals/edit/'+id,
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

    <div class="message-box animated fadeIn" data-sound="alert" id="delete_regionals">
            <div class="mb-container">
                @if($lang == 'ar')
                <div class="mb-middle pull-right">
                    <div class="mb-title"><span class="fa fa-sign-out"></span> {{trans('strings.delete')}}<strong>{{trans('strings.reg_title')}}</strong> ! </div>
                    <div class="mb-content">
                        <p>{{trans('strings.delete-alert-message-prompt-regional')}}</p>                    
                        <p>{{trans('strings.delete-alert-message-hint')}}.</p>
                    </div>
                    <div class="mb-footer">
                        <div class="pull-right">
                            <button id="confirm_delete_regionals" data="" onclick='destroy_regionals($(this).attr("data"))'  class="btn btn-success btn-lg">{{trans('strings.yes')}}</button>
                            <button class="btn btn-default btn-lg mb-control-close">{{trans('strings.no')}}</button>
                        </div>
                    </div>
                </div>
                @elseif($lang == 'en')
                <div class="mb-middle">
                    <div class="mb-title"><span class="fa fa-sign-out"></span> {{trans('strings.delete')}} <strong>{{trans('strings.reg_title')}}</strong> ?</div>
                    <div class="mb-content">
                        <p>{{trans('strings.delete-alert-message-prompt-regional')}}</p>                    
                        <p>{{trans('strings.delete-alert-message-hint')}}.</p>
                    </div>
                    <div class="mb-footer">
                        <div class="pull-right">
                            <button id="confirm_delete_regionals" data="" onclick='destroy_regionals($(this).attr("data"))'  class="btn btn-success btn-lg">{{trans('strings.yes')}}</button>
                            <button class="btn btn-default btn-lg mb-control-close">{{trans('strings.no')}}</button>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>

    <!-- End Delete Alert -->
    <!-- Start Modal Frame -->
    <form id='store-regionals' action="regionals/store" method="post" enctype="multipart/form-data" class="form-horizontal" role="form">
        <div class="modal fade" id="addRegionalModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle"> {{trans('strings.add-new')}} : {{trans('strings.ADD regional')}}</h5>
                <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: 0px">
                  <span aria-hidden="true">&times;</span>
                </button> -->
              </div>
              <div class="modal-body" id="modal_create_state">

                 {{csrf_field()}}                               
                
                    <div class="form-group">
                        <label class="col-md-2 control-label">{{trans('strings.select_country')}}</label>
                        <div class="col-md-10">
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
                        <label class="col-md-2 control-label">{{trans('strings.select_state')}}</label>
                        <div class="col-md-10">
                            <select disabled id="stateSelect" class="form-control js-regionals" name="state_id">
                                <option selected="selected">{{trans('strings.select_st_first')}}</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                    <label class="col-md-2 control-label">{{trans('strings.regional-input-name')}}</label>
                        <div class="col-md-10">
                             <input type="text" name="name" id="name" required="
                                " class="form-control" placeholder="{{trans('strings.Enter regional name')}}" />
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
     <form id='update-regionals' states method="post" enctype="multipart/form-data" class="form-horizontal" role="form">
        <div class="modal fade" id="editRegionalModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">{{trans('strings.upd-new')}} : {{trans('strings.UPD regional')}}</h5>
                
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
                     <li><a href="/regionals/index">{{trans('strings.regionals')}}</a></li>
                    <li class="active">{{trans('strings.sc_regionals')}}</li>
                </ul>
                <!-- END BREADCRUMB -->
               
                    
                    <!-- START CONTENT FRAME TOP -->
                    <div class="content-frame-top">                        
                        <!-- <div class="page-title">                    
                            <h2><span class="fa fa-image"></span> Gallery</h2>
                        </div>  --> 
                        @if($lang == 'ar')                                    
                        <div class="pull-right" style="margin-left: 10px">
                            <button  data-toggle="modal" data-target="#addRegionalModal" class="btn btn-info"><span class="fa fa-plus"></span>  {{trans('strings.ADD regional')}}</button>
                            <!-- <button class="btn btn-default content-frame-right-toggle"><span class="fa fa-bars"></span></button> -->
                        </div>  
                        @elseif($lang =='en')                       
                        <div class="pull-left" style="margin-left:10px">                            
                            <button data-toggle="modal" data-target="#addRegionalModal" class="btn btn-info"><span class="fa fa-plus"></span> {{trans('strings.ADD regional')}}</button>
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
                                    <h3 class="panel-title pull-left"><span class="fa fa-opencart"></span>  {{trans('strings.Report of Regionals')}} <span class="fa fa-eye"></span></h3>
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
                                                <th>{{trans('strings.Regional Name')}}</th>
                                                <th>{{trans('strings.re_state')}}</th>
                                                <th>{{trans('strings.Actions')}}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                         @foreach($regionals as $regional)
                                            <tr>
                                                <td>{{$loop -> index+1}}</td>
                                                <td>{{$regional->name}}</td>
                                                <td>{{$regional->states->name}}</td>
                                                <td>
                                                <button onclick='update_regionals(this.id)' id="{{$regional->regional_id}}" class="btn btn-success btn-rounded btn-sm"><span class="fa fa-pencil"></span>  {{trans('strings.update')}} </button> 
                                                <button 
                                                    onclick='$("#confirm_delete_regionals").attr("data",this.id);' 
                                                    id="{{$regional->regional_id}}" 
                                                    class="btn btn-danger btn-rounded btn-sm mb-control" 
                                                    data-box="#delete_regionals">
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