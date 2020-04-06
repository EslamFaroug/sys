@php 
    $lang = Session::get('lang');
    \App::setLocale($lang);
@endphp
{{csrf_field()}}    
<input type="hidden" name="college_id" value="{{$colleges->college_id}}">
<div class="form-group">
<label class="col-md-2 control-label">{{trans('strings.college-input-name')}}</label>
    <div class="col-md-10">
        <input type="text" name="name" required="" class="form-control" value="{{$colleges->name}}"/>
    </div>
</div>
<div class="form-group">
    <label class="col-md-2 control-label">{{trans('strings.select_unive')}}</label>
        <div class="col-md-10">
            <select id="univeritySelect" class="form-control js-colleges" type="text" name="university_id">
                <optgroup  label="{{trans('strings.select_college-label')}}">
                    
                    @foreach($universities as $unive)
                    @if($unive->university_id == $colleges->university_id)
                        <option selected="selected" value="{{$unive->university_id}}">{{$unive->name}}</option>
                    @else
                        <option value="{{$unive->university_id}}">{{$unive->name}}</option>
                    @endif
                    @endforeach
                </optgroup>
            </select>
        </div>
</div>