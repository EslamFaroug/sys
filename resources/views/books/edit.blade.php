@php
    $lang = Session::get('lang');
    \App::setLocale($lang);
@endphp
<script type="text/javascript" src="{{asset('/js/plugins/fileinput/fileinput.min.js')}}"></script>
<script type="text/javascript" src="{{asset('/js/plugins/filetree/jqueryFileTree.js')}}"></script>
<script type='text/javascript' src="{{('/js/plugins/icheck/icheck.min.js')}}"></script>
<script type="text/javascript" src="{{('/js/plugins/mcustomscrollbar/jquery.mCustomScrollbar.min.js')}}"></script>
<script type="text/javascript" src="{{('/js/plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script type='text/javascript' src="{{('/js/plugins/bootstrap/bootstrap-datepicker.js')}}"></script>

{{csrf_field()}}
<input type="hidden" name="book_id" value="{{$books->book_id}}">

<div class="form-group">
    <label class="col-md-2 control-label">{{trans('strings.t_name')}}</label>
        <div class="col-md-10">
            <select id="departmentSelect" class="form-control js-specials" name="teacher_id">
                <optgroup  label="{{trans('strings.select_depart_first')}}">
                    <option style="color: gray" value="" selected="selected" hidden="hidden"> {{trans('strings.select_tr_name')}} </option>
                @foreach($teachers as $tr)
                        <option value="{{$tr->teacher_id}}"  @if($tr->teacher_id == $books->teacher_id) selected @endif>{{$tr->ar_name}}</option>
                     @endforeach
                </optgroup>
            </select>
        </div>
</div>
<div class="form-group">
    <label class="col-md-2 control-label">{{trans('strings.book-input-label')}}</label>
    <div class="col-md-10">
    <input type="text" name="title" required="
                                " class="form-control" value="{{$books->title}}" />
    </div>
</div>
<div class="form-group">
<label class="col-md-2 control-label">{{trans('strings.book-input-isbn')}}</label>
    <div class="col-md-10">
        <input type="text" name="isbn" required="
                                " class="form-control" value="{{$books->isbn}}" />
    </div>
</div>
<div class="form-group">
<label class="col-md-2 control-label">{{trans('strings.book-input-publish')}}</label>
    <div class="col-md-10">
        <input type="text" name="publisher" required="
                                " class="form-control" value="{{$books->publisher}}" />
    </div>
</div>
<div class="form-group">
    <label class="col-md-2 control-label">{{trans('strings.f_edition')}}</label>
        <div class="col-md-10">
                                <input type="text"  name="f_edition" id="from-datepicker" class="form-control datepicker" value="{{$books->f_edition}}">
        </div>
</div>
<div class="form-group">
    <label class="col-md-2 control-label">{{trans('strings.l_edition')}}</label>
        <div class="col-md-10">
                                <input type="text"  name="l_edition" id="from-datepicker" class="form-control datepicker" value="{{$books->l_edition}}">
        </div>
</div>
<div class="form-group">
    <div class="col-md-12">
        <label>{{trans('strings.paper_file')}}:  <span style="color: red">{{trans('strings.info_p')}} </span></label>
        <input id="certificat-upload-field" type="file" class="file" data-preview-file-type="any" name="file" value="{{$books->book_file}}" />
    </div>
</div>
