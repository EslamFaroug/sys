@php
    $lang = Session::get('lang');
    \App::setLocale($lang);
@endphp
{{csrf_field()}}
<input type="hidden" name="teacher_id" value="{{$teachers->teacher_id}}">
<div class="form-group">
    <label class="col-md-2 control-label">{{trans('teacher.AR_Name')}}</label>
    <div class="col-md-10">
       <input type="text" name="ar_name" class="form-control" value="{{$teachers->ar_name}}" placeholder="{{trans('teacher.Enter arbic name')}}"  />
    </div>
</div>

<div class="form-group">
    <label class="col-md-2 control-label">{{trans('teacher.en_name')}}</label>
        <div class="col-md-10">
            <input type="text" name="en_name" class="form-control" value="{{$teachers->en_name}}" />
        </div>
</div>

<div class="form-group">
    <label class="col-md-2 control-label">{{trans('teacher.card_id')}}</label>
        <div class="col-md-10">
            <input type="text" name="card_id" class="form-control" value="{{$teachers->card_id}}" />
        </div>
</div>

<div class="form-group">
    <label class="col-md-2 control-label">{{trans('teacher.dob')}}</label>
        <div class="col-md-10">
            <input type="text"  name="dob" id="from-datepicker" class="form-control datepicker" value="{{$teachers->dob}}">
        </div>
</div>

<div class="form-group">
    <label class="col-md-2 control-label">{{trans('teacher.pob')}}</label>
    <div class="col-md-10">
        <input type="text" name="pob" class="form-control" value="{{$teachers->pob}}" />
    </div>
</div>

 <div class="form-group">
    <label class="col-md-2 control-label">{{trans('teacher.gender')}}</label>
        <div class="col-md-5">
            <label class="check"><input type="radio" id="female" class="iradio" name="gender" value="2" @if($teachers->gender==2) checked  @endif />  {{trans('teacher.female')}}</label>
        </div>
        <div class="col-md-5">
            <label class="check"><input type="radio" id="male" class="iradio" name="gender" value="1" @if($teachers->gender==1) checked  @endif/>  {{trans('teacher.male')}} </label>
        </div>
</div>

<div class="form-group">
    <label class="col-md-2 control-label">{{trans('teacher.status')}}</label>
        <div class="col-md-10">
           <select id="status" class="form-control js-states" type="text" name="status">
             <optgroup  label="{{trans('teacher.status-label')}}">
               <option style="color: gray" selected="selected" hidden="hidden"> {{trans('teacher.status-label')}} </option>
               @foreach($martialStatus as $key => $mar)
               <option value="{{$key}}" @if($teachers->status==$key) selected @endif>{{$mar}}</option>
               @endforeach
              </optgroup>
           </select>
        </div>
</div>
<div class="form-group">
    <label class="col-md-2 control-label">{{trans('teacher.mother_tounge')}}</label>
       <div class="col-md-10">
          <select id="mother_tounge" class="form-control js-teachers" type="text" name="mother_tounge">
            <optgroup  label="{{trans('teacher.language-label')}}">
                <option style="color: gray" selected="selected" hidden="hidden"> {{trans('teacher.language-label')}} </option>
                @foreach($languages as $key => $language)
                <option value="{{$key}}" @if($teachers->mother_tounge==$key) selected @endif>{{$language}}</option>
                @endforeach
           </optgroup>
         </select>
       </div>
</div>

<div class="form-group">
    <label class="col-md-2 control-label">{{trans('teacher.national_id')}}</label>
        <div class="col-md-10">
            <select id="countrySelect" class="form-control js-teachers" type="text" name="countery_id">
            <optgroup  label="{{trans('teacher.select_national-label')}}">
            @foreach($countreis as $count)
            <option @if($teachers->countery_id==$count->countery_id) selected @endif value="{{$count->countery_id}}">{{$count->name}}</option>
            @endforeach
           </optgroup>
           </select>
        </div>
</div>
<div class="form-group">
    <label class="col-md-2 control-label">{{trans('strings.tr-email')}} </label>
    <div class="col-md-10">
        <input type="email" value="{{$teachers->contacts[0]->email}}" required name="email" class="form-control" placeholder="{{trans('strings.email-input-placeholder')}}"/>
    </div>
</div>
<div class="form-group">
    <label class="col-md-2 control-label">{{trans('teacher.degree')}}</label>
        <div class="col-md-10">
            <select id="degreeSelect" class="form-control js-teachers" type="text" name="degree_id">
            <optgroup  label="{{trans('teacher.select_degree-label')}}">
            @foreach($degrees as $degree)
            <option @if($teachers->degree_id==$degree->degree_id) selected @endif value="{{$degree->degree_id}}">{{$degree->name}}</option>
            @endforeach
            </optgroup>
            </select>
        </div>
</div>

