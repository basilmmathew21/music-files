
<!--
<div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
    <label for="profile" class="col-md-2 control-label">{{ trans('students.profile_image') }}</label>
    <div class="col-md-10">
    <input name="profile_image" type="file" class="form-control" id="customFile" />
        {!! $errors->first('profile_image', '<p class="text-danger">:message</p>') !!}
    </div>
</div>
-->
<div class="form-group">
    <label for="name" class="col-md-2 control-label">{{ trans('classes.student') }}</label>
	<div class="col-md-10">
        <select name="student_user_id" class="form-control">
			
				<option value="4" >aaaaa</option>
			
        </select>
	</div>
</div>



<div class="form-group {{ $errors->has('dob') ? 'has-error' : '' }}">
    <label for="dob" class="col-md-2 control-label">{{ trans('classes.date') }}</label>
    <div class="col-md-10">
        <input class="form-control datepicker" name="date" type="text" id="dob"
            value="{{ old('dob', optional($user)->dob) }}" minlength="1" maxlength="255" required="true"
            placeholder="{{ trans('students.dob__placeholder') }}">
        {!! $errors->first('dob', '<p class="text-danger">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('dob') ? 'has-error' : '' }}">
    <label for="dob" class="col-md-2 control-label">{{ trans('classes.summary') }}</label>
    <div class="col-md-10">
        <textarea class="form-control datepicker" name="summary" id="summary"></textarea> 
		{!! $errors->first('dob', '<p class="text-danger">:message</p>') !!}
    </div>
</div>

<br></br><input type="file" name="attachment[]" multiple><br></br>



	









