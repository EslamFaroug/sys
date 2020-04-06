@php
    $lang = Session::get('lang');
    \App::setLocale($lang);
@endphp

@extends('layouts.admin')

@section('title') {{trans('strings.paper_title')}}
@endsection



<!-- @section('inner-title')
    {{trans('strings.countreis-title')}}
@endsection -->

@section("Style_css")

    <link rel="stylesheet" href="{{asset('plugins/bower_components/bootstrap-daterangepicker/daterangepicker.css')}}">

@endsection



@section('extra-plugins')

    <script type='text/javascript' src="{{asset('/js/plugins/icheck/icheck.min.js')}}"></script>
    <script type='text/javascript' src="{{asset('/js/plugins/moment.min.js')}}"></script>
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
$('.input-daterange').daterangepicker({
format: 'YYYY-MM-DD',
buttonClasses: ['btn', 'btn-sm'],
applyClass: 'btn-danger',
cancelClass: 'btn-inverse'
}, function(start, end, label) {
form =$(".form-horizontal").serialize();
$.ajax({
url: '/re_conferences/result',
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


$("#value").keyup(function(){
form =$(".form-horizontal").serialize();
$.ajax({
url: '/re_papers/result',
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


$("#title").keyup(function(){
form =$(".form-horizontal").serialize();
$.ajax({
url: '/re_papers/result',
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


$("#publish_place").keyup(function(){
form =$(".form-horizontal").serialize();
$.ajax({
url: '/re_papers/result',
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




$("#date").keyup(function(){
form =$(".form-horizontal").serialize();
$.ajax({
url: '/re_papers/result',
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
url: '/re_papers/result',
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
if(filter.value!="degree"){
$('#departFilter').show();
}
if(!id){
$('#departFilter').hide();
}
$('#specialFilter').hide();
form =$(".form-horizontal").serialize();
$.ajax({
url: '/re_papers/result',
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
url: '/re_papers/result',
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
url: '/re_papers/result',
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
url: '/re_papers/result',
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
$('#filter').on('change', function () {

$("#degreeSelect").val("");
$("#universitySelect").val("");
$("#collegeSelect").val("");
$("#departmentSelect").val("");
$("#specialSelect").val("");
$("#title").val("");
$("#publish_place").val("");
$("#date").val("");
$("#value").val("");

if(this.value=="paper"){

$('#publish_placeFilter').show();
$('#degreeFilter').hide();
$('#universityFilter').hide();
$('#colegeFilter').hide();
$('#departFilter').hide();
$('#specialFilter').hide();

}else if(this.value=="univ_title"){
$('#universityFilter').show();
$('#publish_placeFilter').hide();
$('#degreeFilter').hide();
$('#colegeFilter').hide();
$('#departFilter').hide();
$('#specialFilter').hide();
}
else if(this.value=="degree"){
$('#universityFilter').show();
$('#degreeFilter').show();
$('#publish_placeFilter').hide();
$('#colegeFilter').hide();
$('#departFilter').hide();
$('#specialFilter').hide();

}else{
$('#degreeFilter').hide();
$('#publish_placeFilter').hide();
$('#universityFilter').hide();
$('#colegeFilter').hide();
$('#departFilter').hide();
$('#specialFilter').hide();

}
form =$(".form-horizontal").serialize();
$.ajax({
url: '/re_papers/result',
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
    <script>
    </script>

                <!-- START BREADCRUMB -->
                <ul class="breadcrumb">

                    <li><a href="/">{{trans('strings.Home')}}</a></li>
                    <li class="active">{{trans('strings.teachers')}} - {{trans('strings.paper_title')}}</li>
                    <li style="color: green;"><span class="fa fa-users"></span>{{trans('strings.paper_count')}} ({{$papers->count()}})</li>

                </ul>



                <!-- PAGE CONTENT WRAPPER -->
                <div class="page-content-wrap">

                    <div class="row">
                        <div class="col-md-12">

                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <form class="form-horizontal" action="{{url('re_papers/print/papers')}}" method="post">
                                        @csrf
                                        <div class="form-group">
                                            <div class="col-md-3">

                                            <div class="input-group">
                                                    <div class="input-group-addon">
                                                        <span class="fa fa-filter"></span>
                                                    </div>
                                                    <select id="filter" name="filter" class="form-control" >
                                                        <optgroup  label="{{trans('strings.sort_by')}}">
                                                            <option style="color: gray" selected="selected" value=""> {{trans('strings.genaral')}} </option>
                                                            <option value="paper">{{trans('strings.pap_delete')}}</option>
                                                        <option value="univ_title">{{trans('strings.univ_title')}}</option>
                                                        <option value="degree">{{trans('strings.degree_name')}}</option>
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

                                            <div class="col-md-3" style="display: none;  margin-top: 5px;"  id="degreeFilter">
                                                <div class="input-group">
                                                    <div class="input-group-addon">
                                                        <span class="fa fa-filter"></span>
                                                    </div>
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

                                            <div class="col-md-3" style="margin-top: 5px;"   id="titleFilter">
                                                <div class="input-group">
                                                    <div class="input-group-addon">
                                                        <span class="fa fa-search"></span>
                                                    </div>
                                                    <input type="text" id="title" name="title" class="form-control" placeholder="{{trans('strings.paper-input-label')}}"/>

                                                </div>
                                            </div>
                                            <div class="col-md-3" style="display: none; margin-top: 5px;"   id="publish_placeFilter">
                                                <div class="input-group">
                                                    <div class="input-group-addon">
                                                        <span class="fa fa-search"></span>
                                                    </div>
                                                    <input type="text" id="publish_place" name="publish_place" class="form-control" placeholder="{{trans('strings.paper-input-place')}}"/>

                                                </div>
                                            </div>
                                            <div class="col-md-3"  style="margin-top: 5px;"  id="dateFilter">
                                                <div class="input-group">
                                                    <div class="input-group-addon">
                                                        <span class="fa fa-calendar"></span>
                                                    </div>
                                                    <input class="form-control input-daterange" type="text" id="date" name="date" placeholder="{{trans("strings.Time")}}" />
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
                                                <button type="submit" class="btn btn-success btn-block" id="all-print"><span class="fa fa-print"></span> {{trans('strings.print')}} {{trans("strings.paper_title")}}</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="row" id="area">

                        @include("re_papers.rows")

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
