@php
    $lang = Session::get('lang');
    \App::setLocale($lang);
@endphp

@extends('layouts.admin')

@section('title') {{trans('strings.teachers')}} - {{trans('strings.Experiences and Jobs')}}
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
@endsection

@section('javascript')
$(document).ready(function(){
$("#value").keyup(function(){
form =$(".form-horizontal").serialize();
$.ajax({
url: '/re_experiences/result',
type: 'POST',
data:form,
success: function(result) {
if(result.status==true){
$("#area").html(result.result);
}

}, error: function (errr, exp) {


}

});

})
});
$(document).ready(function(){
$("#institute").keyup(function(){
form =$(".form-horizontal").serialize();
$.ajax({
url: '/re_experiences/result',
type: 'POST',
data:form,
success: function(result) {
if(result.status==true){
$("#area").html(result.result);
}

}, error: function (errr, exp) {


}

});

})
});

$(document).ready(function(){
$("#exp_name").keyup(function(){
form =$(".form-horizontal").serialize();
$.ajax({
url: '/re_experiences/result',
type: 'POST',
data:form,
success: function(result) {
if(result.status==true){
$("#area").html(result.result);
}

}, error: function (errr, exp) {


}

});

})
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
$('#colegeFilter').show();
if(!id){
$('#colegeFilter').hide();
}
$('#departFilter').hide();
$('#specialFilter').hide();
form =$(".form-horizontal").serialize();
$.ajax({
url: '/re_experiences/result',
type: 'POST',
data:form,
success: function(result) {
if(result.status==true){
$("#area").html(result.result);
}

}, error: function (errr, exp) {


}

});

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
$('#departFilter').show();
if(!id){
$('#departFilter').hide();
}
$('#specialFilter').hide();
form =$(".form-horizontal").serialize();
$.ajax({
url: '/re_experiences/result',
type: 'POST',
data:form,
success: function(result) {
if(result.status==true){
$("#area").html(result.result);
}

}, error: function (errr, exp) {


}

});
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
$('#specialFilter').show();
if(!id){
$('#specialFilter').hide();
}
form =$(".form-horizontal").serialize();
$.ajax({
url: '/re_experiences/result',
type: 'POST',
data:form,
success: function(result) {
if(result.status==true){
$("#area").html(result.result);
}

}, error: function (errr, exp) {


}

});
}
});
});
})



$(document).ready(function(){
$('#specialSelect').on('change',function(){
form =$(".form-horizontal").serialize();
$.ajax({
url: '/re_experiences/result',
type: 'POST',
data:form,
success: function(result) {
if(result.status==true){
$("#area").html(result.result);
}

}, error: function (errr, exp) {


}

});
});
})



$(document).ready(function(){
$('#degreeSelect').on('change',function(){
form =$(".form-horizontal").serialize();
$.ajax({
url: '/re_experiences/result',
type: 'POST',
data:form,
success: function(result) {
if(result.status==true){
$("#area").html(result.result);
}

}, error: function (errr, exp) {


}

});
});
})

$(document).ready(function(){
$('#mangejobSelect').on('change',function(){
form =$(".form-horizontal").serialize();
$.ajax({
url: '/re_experiences/result',
type: 'POST',
data:form,
success: function(result) {
if(result.status==true){
$("#area").html(result.result);
}

}, error: function (errr, exp) {


}

});
});
})

$(document).ready(function() {
$('#filter').on('change', function () {
$("#universitySelect").val("");
$("#collegeSelect").val("");
$("#departmentSelect").val("");
$("#specialSelect").val("");
$("#degreeSelect").val("");
$("#mangejobSelect").val("");
$("#exp_name").val("");
$("#institute").val("");
$("#value").val("");
if(this.value=="teach"){
$('#universityFilter').show();
$('#degreeFilter').show();
$('#mangejobFilter').hide();
$('#exp_nameFilter').hide();
$('#instituteFilter').hide();
}else if(this.value=="mange"){
$('#universityFilter').show();
$('#mangejobFilter').show();
$('#degreeFilter').hide();
$('#exp_nameFilter').hide();
$('#instituteFilter').hide();
}
else if(this.value=="exp"){
$('#exp_nameFilter').show();
$('#instituteFilter').show();
$('#universityFilter').hide();
$('#colegeFilter').hide();
$('#departFilter').hide();
$('#specialFilter').hide();
$('#degreeFilter').hide();
$('#mangejobFilter').hide();

}else{
$('#exp_nameFilter').hide();
$('#instituteFilter').hide();
$('#universityFilter').hide();
$('#colegeFilter').hide();
$('#departFilter').hide();
$('#specialFilter').hide();
$('#degreeFilter').hide();
$('#mangejobFilter').hide();

}
form =$(".form-horizontal").serialize();
$.ajax({
url: '/re_experiences/result',
type: 'POST',
data:form,
success: function(result) {
if(result.status==true){
$("#area").html(result.result);
}

}, error: function (errr, exp) {


}

});

});
});
@endsection

@section('contents')

                <!-- START BREADCRUMB -->
                <ul class="breadcrumb">

                    <li><a href="/">{{trans('strings.Home')}}</a></li>
                    <li class="active">{{trans('strings.teachers')}} - {{trans('strings.Experiences and Jobs')}}</li>
                    <li style="color: green;"><span class="fa fa-users"></span>{{trans('strings.exp_count')}} ({{$experiences->count()}})</li>

                </ul>



                <!-- PAGE CONTENT WRAPPER -->
                <div class="page-content-wrap">

                    <div class="row">
                        <div class="col-md-12">

                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <form class="form-horizontal" action="{{url('re_experiences/experiences/print/')}}" method="post">
                                        @csrf
                                        <div class="form-group">
                                            <div class="col-md-3" style=" margin-top: 5px;">
                                                <div class="input-group">
                                                    <div class="input-group-addon">
                                                        <span class="fa fa-filter"></span>
                                                    </div>
                                                    <select name="filter" class="form-control" id="filter">
                                                        <optgroup  label="{{trans('strings.job_type')}}">
                                                            <option style="color: gray" selected="selected" value=""> {{trans('strings.all-Job')}} </option>
                                                            <option value="teach">{{trans('strings.teach')}}</option>
                                                        <option value="mange">{{trans('strings.mange')}}</option>
                                                        <option value="exp">{{trans('strings.exp')}}</option>
                                                        </optgroup>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-3" style=" margin-top: 5px;" id="countryFilter">
                                                <div class="input-group">
                                                    <div class="input-group-addon">
                                                        <span class="fa fa-filter"></span>
                                                    </div>
                                                    <select  id="countrySelect" class="form-control js-specials" type="text" name="country_id">
                                                        <optgroup  label="{{trans('strings.select_country')}}">
                                                            <option style="color: gray" selected="selected" value=""> {{trans('strings.Countries')}} </option>
                                                            @foreach($countries as $Country)
                                                                <option value="{{$Country->country_id}}">{{$Country->name}}</option>
                                                            @endforeach
                                                        </optgroup>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-3" style="display: none; margin-top: 5px;" id="universityFilter">
                                                <div class="input-group">
                                                    <div class="input-group-addon">
                                                        <span class="fa fa-filter"></span>
                                                    </div>
                                                    <select onchange="getColleges(this.value())" id="universitySelect" class="form-control js-specials" type="text" name="university_id">
                                                        <optgroup  label="{{trans('strings.select_univers-label')}}">
                                                            <option style="color: gray" selected="selected" value=""> {{trans('strings.universities')}} </option>
                                                            @foreach($universities as $unive)
                                                                <option value="{{$unive->university_id}}">{{$unive->name}}</option>
                                                            @endforeach
                                                        </optgroup>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-3" style="display: none; margin-top: 5px;" id="colegeFilter">
                                                <div class="input-group">
                                                    <div class="input-group-addon">
                                                        <span class="fa fa-filter"></span>
                                                    </div>
                                                    <select disabled id="collegeSelect" class="form-control js-specials" name="college_id">
                                                        <option selected="selected">{{trans('strings.tr_college')}}</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-3" style="display: none; margin-top: 5px;" id="departFilter">
                                                <div class="input-group">
                                                    <div class="input-group-addon">
                                                        <span class="fa fa-filter"></span>
                                                    </div>
                                                    <select disabled id="departmentSelect" class="form-control js-specials" name="depart_id">
                                                        <option selected="selected">{{trans('strings.special_depart')}}</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-3" style="display: none; margin-top: 5px;" id="specialFilter">
                                                <div class="input-group">
                                                    <div class="input-group-addon">
                                                        <span class="fa fa-filter"></span>
                                                    </div>
                                                    <select disabled id="specialSelect" class="form-control js-specials" name="special_id">
                                                        <option selected="selected">{{trans('strings.special_name')}}</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-3" style="display: none;margin-top: 5px;"  id="degreeFilter">
                                                <div class="input-group">
                                                    <div class="input-group-addon">
                                                        <span class="fa fa-filter"></span>
                                                    </div>
                                                    <select id="degreeSelect" class="form-control js-teachers" type="text" name="degree_id">
                                                        <optgroup  label="{{trans('strings.job_teach')}}">
                                                            <option style="color: gray" selected="selected" value=""> {{trans('strings.job_teach')}} </option>
                                                            @foreach($degrees as $degree)
                                                                <option value="{{$degree->degree_id}}">{{$degree->name}}</option>
                                                            @endforeach
                                                        </optgroup>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-3" style="display: none;margin-top: 5px;"  id="mangejobFilter">
                                                <div class="input-group">
                                                    <div class="input-group-addon">
                                                        <span class="fa fa-filter"></span>
                                                    </div>
                                                    <select id="mangejobSelect" class="form-control js-teachers" type="text" name="mangejob_id">
                                                        <optgroup  label="{{trans('strings.job_mange')}}">
                                                            <option style="color: gray" selected="selected" value=""> {{trans('strings.job_mange')}} </option>
                                                            @foreach($mangejobs as $mangejob)
                                                                <option value="{{$mangejob->mangejob_id}}">{{$mangejob->name}}</option>
                                                            @endforeach
                                                        </optgroup>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-3"  style="display: none;margin-top: 5px;"  id="exp_nameFilter">
                                                <div class="input-group">
                                                    <div class="input-group-addon">
                                                        <span class="fa fa-search"></span>
                                                    </div>
                                                    <input type="text" id="exp_name" name="exp_name" class="form-control" placeholder="{{trans('strings.exp_name')}}"/>

                                                </div>
                                            </div>
                                            <div class="col-md-3"  style="display: none;margin-top: 5px;"  id="instituteFilter">
                                                <div class="input-group">
                                                    <div class="input-group-addon">
                                                        <span class="fa fa-search"></span>
                                                    </div>
                                                    <input type="text" id="institute" name="institute" class="form-control" placeholder="{{trans('strings.exp_institute')}}"/>

                                                </div>
                                            </div>
                                            <div class="col-md-3" style="margin-top: 5px;"   id="valueFilter">
                                                <div class="input-group">
                                                    <div class="input-group-addon">
                                                        <span class="fa fa-search"></span>
                                                    </div>
                                                    <input type="text" id="value" name="value" class="form-control" placeholder="{{trans('strings.who search')}}"/>

                                                </div>
                                            </div>

                                            <div class="col-md-3" style="margin-top: 5px;">
                                                <button type="submit" class="btn btn-success btn-block" id="all-print"><span class="fa fa-print"></span> {{trans('strings.print')}} {{trans("strings.Experiences and Jobs")}}</button>
                                            </div>
                                        </div>

                                     </form>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="row" id="area">

                        @include("re_experiences.row")

                    </div>
                   <!--  <div class="row">
                        <div class="col-md-12">
                            <ul class="pagination pagination-sm pull-right push-down-10 push-up-10">
                                <li class="disabled"><a href="#">«</a></li>
                                <li class="active"><a href="#">1</a></li>
                                <li><a href="#">2</a></li>
                                <li><a href="#">3</a></li>
                                <li><a href="#">4</a></li>
                                <li><a href="#">»</a></li>
                            </ul>
                        </div>
                    </div> -->

                </div>
                <!-- END PAGE CONTENT WRAPPER -->

@endsection
