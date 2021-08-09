
<!--
<div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
    <label for="profile" class="col-md-2 control-label">{{ trans('students.profile_image') }}</label>
    <div class="col-md-10">
    <input name="profile_image" type="file" class="form-control" id="customFile" />
        {!! $errors->first('profile_image', '<p class="text-danger">:message</p>') !!}
    </div>
</div>
-->

@if (auth()->user()->roles[0]->id != 3)
	
<div class="form-group">
    <label for="name" class="col-md-2 control-label">{{ trans('classes.tutor') }}<sup style="color:red">*</sup></label>
	<div class="col-md-10">
        <select name="tutor_user_id" id="tutor_id" onchange="getStudents()" class="form-control">
			<option value="" >Select</option>
			@foreach ($tutors as $l => $tutor)
				<option value="{{$l}}" >{{$tutor}}</option>
			@endforeach
        </select>
	</div>
</div>
	
@endif


<div class="form-group">
    <label for="name" class="col-md-2 control-label">{{ trans('classes.student') }}<sup style="color:red">*</sup></label>
	<div class="col-md-10">
        <select name="student_user_id" id="student_user_id" class="form-control">
			<option value="" >Select</option>
			@foreach ($students as $k => $student)
				<option value="{{$k}}" >{{$student}}</option>
			@endforeach
        </select>
	</div>
</div>



<div class="form-group {{ $errors->has('dob') ? 'has-error' : '' }}">
    <label for="dob" class="col-md-2 control-label">{{ trans('classes.date') }}<sup style="color:red">*</sup></label>
    <div class="col-md-10">
        <input class="form-control datepicker" name="date" type="text" id="dob"
            value="{{ old('dob', optional($user)->dob) }}" minlength="1" maxlength="255" required="true"
            placeholder="{{ trans('students.dob__placeholder') }}" readonly>
        {!! $errors->first('dob', '<p class="text-danger">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('dob') ? 'has-error' : '' }}">
    <label for="dob" class="col-md-2 control-label">{{ trans('classes.summary') }}<sup style="color:red">*</sup></label>
    <div class="col-md-10">
        <textarea class="form-control text-editor" name="summary" id="summary"></textarea> 
		{!! $errors->first('dob', '<p class="text-danger">:message</p>') !!}
    </div>
</div>

<br></br><input type="file" name="attachment[]" multiple><br></br>







