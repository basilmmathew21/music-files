
<div class="form-group">
    <label for="name" class="col-md-2 control-label">{{ trans('classes.student') }}</label>
	<div class="col-md-10">
        <select name="student_user_id" class="form-control">
			
				<option value="4" @if($classes->gender =='Male') selected @endif>aaaaa</option>
			
        </select>
	</div>
</div>



<div class="form-group {{ $errors->has('dob') ? 'has-error' : '' }}">
    <label for="dob" class="col-md-2 control-label">{{ trans('classes.date') }}</label>
    <div class="col-md-10">
        <input class="form-control datepicker" name="date" type="text" id="dob"
            value="{{ old('dob', optional($classes)->date) }}" minlength="1" maxlength="255" required="true"
            placeholder="{{ trans('students.dob__placeholder') }}">
        {!! $errors->first('dob', '<p class="text-danger">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('dob') ? 'has-error' : '' }}">
    <label for="dob" class="col-md-2 control-label">{{ trans('classes.summary') }}</label>
    <div class="col-md-10">
        <textarea class="form-control datepicker" name="summary" id="summary">{{ old('summary', optional($classes)->summary) }}</textarea> 
		{!! $errors->first('dob', '<p class="text-danger">:message</p>') !!}
    </div>
</div>

<br></br><input type="file" name="attachment[]" multiple><br></br>

<h3>{{ trans('classes.files') }}</h3>
                    @foreach ($files as $file)
                            <a href="#">{{ $file }}</a>
                        @endforeach

<br></br>













