@php 
    $lang = Session::get('lang');
    \App::setLocale($lang);
@endphp

@extends('layouts.admin')

@section('title') {{trans('strings.skill_title')}} 
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

        $("#store-skills").submit(function(event){

            $.ajax({
                url: "{{url('/skills/store')}}",
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

         $("#update-skills").submit(function(event){
            var form = $(this)[0];
            var formData = new FormData(form);

            $.ajax({
                url: "{{url('/skills/update')}}/"+form['skill_id'].value,
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

        function destroy_skills(id) {
            $.ajax({
                url: "{{url('/skills/destroy')}}/"+id,
                type: 'POST',
                data: '_token={{csrf_token()}}',
                success: function(res) {
                    refersh();
                }
            });
        }

        function update_degrees(id) {
            $.ajax({
                url: '/skills/edit/'+id,
                type: 'POST',
                data: '_token={{csrf_token()}}',
                success: function(res) {
                    $('#modal-update-skills-form').html(res);
                    $("#editSkillModal").modal();
                }
            });
        }

        function refersh() {
            document.location.href = document.location.href;
        }

        $('#toggle_all_skills').click(function(){
            $('.skills_table_actions').each(function(i,e){
                $(e).prop('checked', false);
            });
        });

       /* $(document).ready(function(){

            $('.role_change').change(function(){
               $.ajax({
                url: /add-role/+this.id,
                type: 'POST',
                data: '_token={{csrf_token()}}',
                success: function(res) {
                  alert("dfsd")
                }
            });
            });
        })*/
        
    </script>  

@endsection

@section('javascript')
    $(document).ready(function(){
});
@endsection

@section('contents')


    <!-- Start Delete Alert -->

    <div class="message-box animated fadeIn" data-sound="alert" id="delete_skills">
            <div class="mb-container">
                @if($lang == 'ar')
                <div class="mb-middle pull-right">
                    <div class="mb-title"><span class="fa fa-sign-out"></span> {{trans('strings.delete')}}<strong>{{trans('strings.skill-input-label')}}</strong> ! </div>
                    <div class="mb-content">
                        <p>{{trans('strings.delete-alert-message-prompt-skill')}}</p>                    
                        <p>{{trans('strings.delete-alert-message-hint')}}.</p>
                    </div>
                    <div class="mb-footer">
                        <div class="pull-right">
                            <button id="confirm_delete_skills" data="" onclick='destroy_skills($(this).attr("data"))'  class="btn btn-success btn-lg">{{trans('strings.yes')}}</button>
                            <button class="btn btn-default btn-lg mb-control-close">{{trans('strings.no')}}</button>
                        </div>
                    </div>
                </div>
                @elseif($lang == 'en')
                <div class="mb-middle">
                    <div class="mb-title"><span class="fa fa-sign-out"></span> {{trans('strings.delete')}} <strong>{{trans('strings.skill-input-label')}}</strong> ?</div>
                    <div class="mb-content">
                        <p>{{trans('strings.delete-alert-message-prompt-skill')}}</p>                    
                        <p>{{trans('strings.delete-alert-message-hint')}}.</p>
                    </div>
                    <div class="mb-footer">
                        <div class="pull-right">
                            <button id="confirm_delete_skills" data="" onclick='destroy_skills($(this).attr("data"))'  class="btn btn-success btn-lg">{{trans('strings.yes')}}</button>
                            <button class="btn btn-default btn-lg mb-control-close">{{trans('strings.no')}}</button>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>

    <!-- End Delete Alert -->

    <!-- Start Modal Frame -->
   
    <!-- End Modal Frame -->

    <!-- Start Modal-Update Frame -->
    
    <!-- Start Modal-Update Frame -->
   
    <!-- End Modal Frame -->
    <!-- End Modal Frame -->

    
                <!-- START BREADCRUMB -->
                <ul class="breadcrumb">
                    <li><a href="/">{{trans('strings.Home')}}</a></li>
                     <li><a href="/skills/index">{{trans('strings.skill-table-title')}}</a></li>
                    <li class="active">{{trans('strings.sc_skill')}}</li>
                </ul>
                <!-- END BREADCRUMB -->
               
                    
                    <!-- START CONTENT FRAME TOP -->
                    <div class="content-frame-top">                        
                        <!-- <div class="page-title">                    
                            <h2><span class="fa fa-image"></span> Gallery</h2>
                        </div>  --> 
                        @if($lang == 'ar')                                    
                        <div class="pull-right" style="margin-left: 10px">
                            <button  data-toggle="modal" data-target="#addDegreeModal" class="btn btn-info"><span class="fa fa-plus"></span>  {{trans('strings.add_skill')}}</button>
                            <!-- <button class="btn btn-default content-frame-right-toggle"><span class="fa fa-bars"></span></button> -->
                        </div>  
                        @elseif($lang =='en')                       
                        <div class="pull-left" style="margin-left:10px">                            
                            <button data-toggle="modal" data-target="#addDegreeModal" class="btn btn-info"><span class="fa fa-plus"></span> {{trans('strings.add_skill')}}</button>
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
                                    <h3 class="panel-title pull-left"><span class="fa fa-opencart"></span>  {{trans('strings.Report of skill')}} <span class="fa fa-eye"></span></h3>
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
                                            <th>#</th>
                                            <th>{{trans('strings.us_name')}}</th>
                                            <th>{{trans('strings.E-Mail Address')}}</th>
                                            <th>{{trans('strings.admin-level')}}</th>
                                            <th>{{trans('strings.Teacher')}}</th>
                                            <th>{{trans('strings.users')}}</th>
                                            <th>{{trans('strings.Actions')}}</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            @foreach($users as $user)
                                            <form method="post" action="add-role-" id="add_role{{$user->id}}">
                                                {{csrf_field()}} 
                                                <input type="hidden" name="email" value="{{ $user -> email }}">
                                            <tr>
                                               <td>{{$user ->id}}</td>
                                               <td>{{$user->name}}</td>
                                                <td>{{$user -> email}}</td>
                                                <td>
                                                   
                                                    <input type="checkbox" class="role_change" id="{{$user->id}}" name="role_admin"  {{ $user->hasRole('Admin') ? 'checked' : ' ' }}>
                                                </td>
                                                <td>
                                                    <input type="checkbox" class="role_change" id="{{$user->id}}" name="role_teacher"  {{ $user->hasRole('Teacher') ? 'checked' : ' ' }}>
                                                </td>
                                                <td>
                                                    <input type="checkbox" class="role_change" id="{{$user->id}}" name="role_user"  {{ $user->hasRole('User') ? 'checked' : ' ' }}>
                                                </td>
                                                <td>
                                                
                                                </td>
                                            </tr>
                                            </form>
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