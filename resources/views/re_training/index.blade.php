@php
    $lang = Session::get('lang');
    \App::setLocale($lang);
@endphp

@extends('layouts.admin')

@section('title') {{trans('strings.teachers')}} - {{trans('strings.Training and courses')}}
@endsection



<!-- @section('inner-title')
    {{trans('strings.countreis-title')}}
@endsection -->

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
url: '/re_training/result',
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
url: '/re_researches/result',
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
$("#institute").keyup(function(){
form =$(".form-horizontal").serialize();
$.ajax({
url: '/re_training/result',
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
url: '/re_training/result',
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
url: '/re_training/result',
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
url: '/re_training/result',
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
url: '/re_training/result',
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
url: '/re_training/result',
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
$('#countrySelect').on('change',function(){
form =$(".form-horizontal").serialize();
$.ajax({
url: '/re_training/result',
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
$('#trainuing_fieldSelect').on('change',function(){
form =$(".form-horizontal").serialize();
$.ajax({
url: '/re_training/result',
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
$(".datepicker").datepicker({format: 'yyyy-mm-dd'});
$(".dp-3,.dp-4").datepicker(); // Sample


$('#filter').on('change', function () {
$("#countrySelect").val("");
$("#universitySelect").val("");
$("#collegeSelect").val("");
$("#departmentSelect").val("");
$("#specialSelect").val("");
$("#title").val("");
$("#institute").val("");
$("#value").val("");
if(this.value=="training_place"){
$('#countryFilter').show();
$('#trainuing_fieldFilter').hide();
$('#universityFilter').hide();
$('#colegeFilter').hide();
$('#departFilter').hide();
$('#specialFilter').hide();
}else if(this.value=="univ"){
$('#universityFilter').show();
$('#countryFilter').hide();
$('#trainuing_fieldFilter').hide();
}
else if(this.value=="trainuing_field"){
$('#trainuing_fieldFilter').show();
$('#countryFilter').hide();
$('#universityFilter').hide();
$('#colegeFilter').hide();
$('#departFilter').hide();
$('#specialFilter').hide();

}else{
$('#trainuing_fieldFilter').hide();
$('#countryFilter').hide();
$('#universityFilter').hide();
$('#colegeFilter').hide();
$('#departFilter').hide();
$('#specialFilter').hide();

}
form =$(".form-horizontal").serialize();
$.ajax({
url: '/re_training/result',
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
                    <li class="active">{{trans('strings.teachers')}} - {{trans('strings.Training and courses')}}</li>
                    <li style="color: green;"><span class="fa fa-users"></span>{{trans('strings.tranning_count')}} ({{$trainings->count()}})</li>

                </ul>



                <!-- PAGE CONTENT WRAPPER -->
                <div class="page-content-wrap">

                    <div class="row">
                        <div class="col-md-12">

                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <form class="form-horizontal" action="{{url('re_training/trainings/print/')}}" method="post">
                                        @csrf
                                        <div class="form-group">
                                            <div class="col-md-3" style=" margin-top: 5px;">
                                                <div class="input-group">
                                                    <div class="input-group-addon">
                                                        <span class="fa fa-filter"></span>
                                                    </div>
                                                    <select name="filter" class="form-control" id="filter">
                                                        <optgroup  label="{{trans('strings.sort_by')}}">
                                                            <option style="color: gray" selected="selected" value=""> {{trans('strings.sort_by')}} </option>
                                                            <option value="training_place">{{trans('strings.training place')}}</option>
                                                            <option value="univ">{{trans('strings.univ_title')}}</option>
                                                            <option value="trainuing_field">{{trans('strings.trainuing_field')}}</option>
                                                        </optgroup>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-3" style="display: none; margin-top: 5px;" id="countryFilter">
                                                <div class="input-group">
                                                    <div class="input-group-addon">
                                                        <span class="fa fa-filter"></span>
                                                    </div>
                                                    <select  id="countrySelect" class="form-control js-specials" type="text" name="country_id">
                                                        <optgroup  label="{{trans('strings.select_country')}}">
                                                            <option style="color: gray" selected="selected" value=""> {{trans('strings.Countries')}} </option>
                                                            @foreach($countries as $Country)
                                                                <option value="{{$Country->countery_id}}">{{$Country->name}}</option>
                                                            @endforeach
                                                        </optgroup>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-3" style="display: none; margin-top: 5px;" id="trainuing_fieldFilter">
                                                <div class="input-group">
                                                    <div class="input-group-addon">
                                                        <span class="fa fa-filter"></span>
                                                    </div>
                                                    <select  id="trainuing_fieldSelect" class="form-control js-specials" type="text" name="trainuing_field">
                                                        <optgroup  label="{{trans('strings.trainuing_field')}}">
                                                            <option style="color: gray" selected="selected" value=""> {{trans('strings.Specializations')}} </option>
                                                            @foreach($Specializations as $Specialization)
                                                                <option value="{{$Specialization->special_id}}">{{$Specialization->name}}</option>
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


                                            <div class="col-md-3"  style="margin-top: 5px;"  id="titleFilter">
                                                <div class="input-group">
                                                    <div class="input-group-addon">
                                                        <span class="fa fa-search"></span>
                                                    </div>
                                                    <input type="text" id="title" name="title" class="form-control" placeholder="{{trans('strings.title-input-label')}}"/>

                                                </div>
                                            </div>
                                            <div class="col-md-3"  style="margin-top: 5px;"  id="instituteFilter">
                                                <div class="input-group">
                                                    <div class="input-group-addon">
                                                        <span class="fa fa-search"></span>
                                                    </div>
                                                    <input type="text" id="institute" name="institute" class="form-control" placeholder="{{trans('strings.institute-input-label')}}"/>

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
                                                <button type="submit" class="btn btn-success btn-block" id="all-print"><span class="fa fa-print"></span> {{trans('strings.print')}} {{trans("strings.Training and courses")}}</button>
                                            </div>
                                        </div>


                                     </form>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="row" id="area">

                        @include("re_training.row")

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
