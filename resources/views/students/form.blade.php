<div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
    <label for="name" class="col-md-2 control-label">{{ trans('users.name') }}</label>
    <div class="col-md-10">
        <input class="form-control" name="name" type="text" id="name" value="{{ old('name', optional($user)->name) }}"
            minlength="1" maxlength="255" required="true" placeholder="{{ trans('users.name__placeholder') }}">
        {!! $errors->first('name', '<p class="text-danger">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
    <label for="email" class="col-md-2 control-label">{{ trans('users.email') }}</label>
    <div class="col-md-10">
        <input class="form-control" name="email" type="text" id="email"
            value="{{ old('email', optional($user)->email) }}" minlength="1" maxlength="255" required="true"
            placeholder="{{ trans('users.email__placeholder') }}">
        {!! $errors->first('email', '<p class="text-danger">:message</p>') !!}
    </div>
</div>


@if(!$user)
<div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
    <label for="password" class="col-md-2 control-label">{{ trans('users.password') }}</label>
    <div class="col-md-10">
        <input class="form-control" name="password" type="password" id="password"
            value="{{ old('password', optional($user)->password) }}" minlength="1" maxlength="255" required="true"
            placeholder="{{ trans('users.password__placeholder') }}">
        {!! $errors->first('password', '<p class="text-danger">:message</p>') !!}
    </div>
</div>
@endif
@if($user)
<div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
    <label for="password" class="col-md-2 control-label">{{ trans('users.password') }}</label>
    <div class="col-md-10">
        <input class="form-control" name="password" type="password" id="password"
            value="" minlength="1" maxlength="255" 
            placeholder="{{ trans('users.password_edit__placeholder') }}">
        {!! $errors->first('password', '<p class="text-danger">:message</p>') !!}
    </div>
</div>
@endif

<div class="form-group">
    <label for="gender" class="col-md-2 control-label">{{ trans('students.gender') }}</label>
	<div class="col-md-10">
        <select name="gender" class="form-control">
		        <option value="Male">Male</option>
				<option value="Female">Female</option>
                <option value="Other">Other</option>
        </select>
	</div>
</div>

<div class="form-group {{ $errors->has('dob') ? 'has-error' : '' }}">
    <label for="dob" class="col-md-2 control-label">{{ trans('students.dob') }}</label>
    <div class="col-md-10">
        <input class="form-control" name="dob" type="text" id="email"
            value="{{ old('dob', optional($user)->dob) }}" minlength="1" maxlength="255" required="true"
            placeholder="{{ trans('students.dob__placeholder') }}">
        {!! $errors->first('dob', '<p class="text-danger">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('phone') ? 'has-error' : '' }}">
    <label for="phone" class="col-md-2 control-label">{{ trans('students.phone') }}</label>
    <div class="col-md-10">
        <input class="form-control" name="phone" type="text" id="phone"
            value="{{ old('phone', optional($user)->email) }}" minlength="1" maxlength="255" required="true"
            placeholder="{{ trans('students.phone__placeholder') }}">
        {!! $errors->first('phone', '<p class="text-danger">:message</p>') !!}
    </div>
</div>
<div class="form-group">
    <label for="name" class="col-md-2 control-label">{{ trans('students.course') }}</label>
	<div class="col-md-10">
        <select name="course" class="form-control">
			@if(isset($courses))
				@foreach ($courses as $id => $course)
				<option value="{{ $id }}" <?php if(in_array($id,$courses)) { ?> selected="selected" <?php } ?>>{{ $course }}</option>
				@endforeach
			@endif
        </select>
	</div>
</div>

<div class="form-group">
    <label for="name" class="col-md-2 control-label">{{ trans('students.nation') }}</label>
	<div class="col-md-10">
        <select name="country" class="form-control">
			@if(isset($nationalities))
				@foreach ($nationalities as $id => $nation)
				<option value="{{ $id }}" <?php if(in_array($id,$nationalities)) { ?> selected="selected" <?php } ?>>{{ $nation }}</option>
				@endforeach
			@endif
        </select>
	</div>
</div>

<div class="form-group">
    <label for="name" class="col-md-2 control-label">{{ trans('students.currency') }}</label>
	<div class="col-md-10">
        <select name="currency" class="form-control">
			@if(isset($currency))
				@foreach ($currency as $id => $curcy)
				<option value="{{ $id }}" <?php if(in_array($id,$currency)) { ?> selected="selected" <?php } ?>>{{ $curcy }}</option>
				@endforeach
			@endif
        </select>
	</div>
</div>



<div class="form-group {{ $errors->has('state') ? 'has-error' : '' }}">
    <label for="state" class="col-md-2 control-label">{{ trans('students.state') }}</label>
    <div class="col-md-10">
        <input class="form-control" name="state" type="text" id="state" value="{{ old('state', optional($user)->state) }}"
            minlength="1" maxlength="255" required="true" placeholder="{{ trans('students.name__placeholder') }}">
        {!! $errors->first('name', '<p class="text-danger">:message</p>') !!}
    </div>
</div>

<div class="form-group">
    <label for="address" class="col-md-2 control-label">{{ trans('students.address') }}</label>
    <div class="col-md-10">
        <textarea class="form-control" name="address" type="text" id="name" value="{{ old('address', optional($user)->address) }}"
            minlength="1" maxlength="255" required="true" placeholder="{{ trans('students.address__placeholder') }}">
        {!! $errors->first('address', '<p class="text-danger">:message</p>') !!}
        </textarea>
    </div>
</div>

<div class="form-group">
    <label for="name" class="col-md-2 control-label">{{ trans('students.status') }}</label>
	<div class="col-md-10">
        <select name="status" class="form-control">
		        <option value="1">Active</option>
				<option value="0">Inactive</option>
        </select>
	</div>
</div>
