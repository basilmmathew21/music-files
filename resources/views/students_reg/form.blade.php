
<!--
<div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
    <label for="profile" class="col-md-2 control-label">{{ trans('students.profile_image') }}</label>
    <div class="col-md-10">
    <input name="profile_image" type="file" class="form-control" id="customFile" />
        {!! $errors->first('profile_image', '<p class="text-danger">:message</p>') !!}
    </div>
</div>
-->

<div class="input-group mb-3">
    
        <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" name="name" type="text" id="name" value="{{ old('name', optional($user)->name) }}"
            minlength="1" maxlength="255" required="true" placeholder="{{ trans('students.name__placeholder') }}" autofocus>
        <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-user {{ config('adminlte.classes_auth_icon', '') }}"></span>
                </div>
        </div>
        @if($errors->has('name'))
                <div class="invalid-feedback">
                    <strong>{{ $errors->first('name') }}</strong>
                </div>
            @endif
  
</div>



<div class="input-group mb-3">
        <input class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" name="email" type="text" id="email"
            value="{{ old('email', optional($user)->email) }}" minlength="1" maxlength="255" required="true"
            placeholder="{{ trans('students.email__placeholder') }}">
        <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-user {{ config('adminlte.classes_auth_icon', '') }}"></span>
                </div>
        </div>
        @if($errors->has('email'))
                <div class="invalid-feedback">
                    <strong>{{ $errors->first('email') }}</strong>
                </div>
            @endif
    
</div>


@if(!$user)
<div class="input-group mb-3">
    <input class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}" name="password" type="password" id="password"
            value="{{ old('password', optional($user)->password) }}" minlength="1" maxlength="255" required="true"
            placeholder="{{ trans('students.password__placeholder') }}">
    <div class="input-group-append">
        <div class="input-group-text">
                    <span class="fas fa-user {{ config('adminlte.classes_auth_icon', '') }}"></span>
        </div>
    </div>
    @if($errors->has('password'))
        <div class="invalid-feedback">
            <strong>{{ $errors->first('password') }}</strong>
        </div>
    @endif
    </div>

@endif



<div class="form-group">
  
    
    <select name="gender" class="form-control"  required="true">
                <option value="" selected disabled>--Choose gender--</option>
		        <option value="Male" @if(old('gender') == "Male") selected @endif>Male</option>
				<option value="Female" @if(old('gender') == "Female") selected @endif>Female</option>
                <option value="Other" @if(old('gender') == "Other") selected @endif>Other</option>
        </select>
		

    
</div>


<div class="form-group mb-3">
        <input class="form-control datepicker {{ $errors->has('dob') ? 'has-error' : '' }}" name="dob" type="text" id="dob"
            value="{{ old('dob', optional($user)->dob) }}" minlength="1" maxlength="255" required="true"
            placeholder="{{ trans('students.dob__placeholder') }}">
            
    @if($errors->has('dob'))
        <div class="invalid-feedback">
            <strong>{{ $errors->first('dob') }}</strong>
        </div>
    @endif
    
</div>


<div class="input-group mb-3">
    
        <input class="form-control {{ $errors->has('phone') ? 'is-invalid' : '' }}" name="phone" id="phone" type="text" value="{{ old('phone', optional($user)->phone) }}"
            minlength="1" maxlength="255" required="true" placeholder="{{ trans('students.phone__placeholder') }}">
        <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-user {{ config('adminlte.classes_auth_icon', '') }}"></span>
                </div>
        </div>
        @if($errors->has('phone'))
                <div class="invalid-feedback">
                    <strong>{{ $errors->first('phone') }}</strong>
                </div>
            @endif
  
</div>

<div class="form-group">

        <select name="course" class="form-control"  required="true">
        <option value="" selected disabled>--Choose Course--</option>
        	@if(isset($courses))
				@foreach ($courses as $id => $course)
				<option value="{{ $id }}"  @if(old('course') == $id) selected @endif>{{ $course }}</option>
				@endforeach
			@endif
        </select>
	
</div>

<div class="form-group">
        <select name="country" class="form-control" required="true">
            <option value="" selected disabled>--Choose Nation--</option>
			@if(isset($nationalities))
				@foreach ($nationalities as $id => $nation)
				<option value="{{ $id }}" @if(old('country') == $id) selected @endif>{{ $nation }}</option>
				@endforeach
			@endif
        </select>
	
</div>

<div class="form-group">
        <select name="currency" class="form-control" required="true">
        <option value="" selected disabled>--Choose Currency--</option>
			@if(isset($currency))
                @foreach ($currency as $curcy)
				<option value="{{ $curcy['id'] }}" @if(old('currency') == $curcy['id']) selected @endif>{{ $curcy->code }}({{$curcy->symbol}})</option>
				@endforeach
			@endif
        </select>
	
</div>


<!--
<div class="form-group {{ $errors->has('class_fee') ? 'has-error' : '' }}">
    <label for="class fee" class="col-md-2 control-label"><span style="color:red">*</span>{{ trans('students.fee') }}</label>
    <div class="col-md-10">
        <input class="form-control" name="class_fee" type="text" id="class_fee" value="{{ old('class_fee', optional($user)->class_fee) }}"
            minlength="1" maxlength="255" required="true" placeholder="{{ trans('students.fee__placeholder') }}">
        {!! $errors->first('class_fee', '<p class="text-danger">:message</p>') !!}
    </div>
</div>
-->

<div class="form-group">
    <input class="form-control {{ $errors->has('state') ? 'has-error' : '' }}" name="state" type="text" id="state" value="{{ old('state', optional($user)->state) }}"
            minlength="1" maxlength="255" placeholder="{{ trans('students.state__placeholder') }}">
            @if($errors->has('state'))
                <div class="invalid-feedback">
                    <strong>{{ $errors->first('state') }}</strong>
                </div>
            @endif
  
</div>

<div class="form-group">
      <textarea class="form-control {{ $errors->has('state') ? 'has-error' : '' }}" name="address" type="text" id="name" value="{{ old('address', optional($user)->address) }}"
            minlength="1" maxlength="255" placeholder="{{ trans('students.address__placeholder') }}">{{ old('address', optional($user)->address) }}
            {!! $errors->first('address', '<p class="text-danger">:message</p>') !!}
        </textarea>
        @if($errors->has('address'))
                <div class="invalid-feedback">
                    <strong>{{ $errors->first('address') }}</strong>
                </div>
            @endif
</div>
<!--
<div class="form-group {{ $errors->has('is_registered') ? 'has-error' : '' }}">
    <label for="class fee" class="col-md-2 control-label">{{ trans('students.reg') }}</label>
    <div class="col-md-10">
  
    <select name="is_registered" class="form-control">
                <option value="">--Select--</option>
                <option value="1" @if(old('is_registered') == "1") selected @endif>Yes</option>
				<option value="0" @if(old('is_registered') == "0") selected @endif>No</option>
        </select>
    </div>
</div>

<div class="form-group">
    <label for="name" class="col-md-2 control-label">{{ trans('students.status') }}</label>
	<div class="col-md-10">
    
        <select name="status" class="form-control">
                <option value="">--Select--</option>
                <option value="1" @if(old('status') == "1") selected @endif>Active</option>
				<option value="0" @if(old('status') == "0") selected @endif>Inactive</option>
        </select>
	</div>
</div>
-->