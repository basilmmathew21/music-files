
<!--
<div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
    <label for="profile" class="col-md-2 control-label">{{ trans('students.profile_image') }}</label>
    <div class="col-md-10">
    <input name="profile_image" type="file" class="form-control" id="customFile" />
        {!! $errors->first('profile_image', '<p class="text-danger">:message</p>') !!}
    </div>
</div>
-->
<div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
    <label for="name" class="col-md-2 control-label"><span style="color:red">*</span>{{ trans('students.name') }}</label>
    <div class="col-md-10">
        <input class="form-control" name="name" type="text" id="name" value="{{ old('name', optional($user)->name) }}"
            minlength="1" maxlength="255" required="true" placeholder="{{ trans('students.name__placeholder') }}">
        {!! $errors->first('name', '<p class="text-danger">:message</p>') !!}
    </div>
</div>
<div class="form-group {{ $errors->has('display_name') ? 'has-error' : '' }}">
    <label for="name" class="col-md-2 control-label"><span style="color:red">*</span>{{ trans('students.display_name') }}</label>
    <div class="col-md-10">
        <input class="form-control" name="display_name" type="text" id="display_name" value="{{ old('display_name', optional($user)->display_name) }}"
            minlength="1" maxlength="255" required="true" placeholder="{{ trans('students.displayname__placeholder') }}">
        {!! $errors->first('display_name', '<p class="text-danger">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
    <label for="email" class="col-md-2 control-label"><span style="color:red">*</span>{{ trans('students.email') }}</label>
    <div class="col-md-10">
        <input class="form-control" name="email" type="text" id="email"
            value="{{ old('email', optional($user)->email) }}" minlength="1" maxlength="255" required="true"
            placeholder="{{ trans('students.email__placeholder') }}">
        {!! $errors->first('email', '<p class="text-danger">:message</p>') !!}
    </div>
</div>


@if(!$user)
<div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
    <label for="password" class="col-md-2 control-label"><span style="color:red">*</span>{{ trans('students.password') }}</label>
    <div class="col-md-10">
        <input class="form-control" name="password" type="password" id="password"
            value="{{ old('password', optional($user)->password) }}" minlength="1" maxlength="255" required="true"
            placeholder="{{ trans('students.password__placeholder') }}">
        {!! $errors->first('password', '<p class="text-danger">:message</p>') !!}
    </div>
</div>
@endif
@if($user)
<div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
    <label for="password" class="col-md-2 control-label">{{ trans('students.password') }}</label>
    <div class="col-md-10">
        <input class="form-control" name="password" type="password" id="password"
            value="" minlength="1" maxlength="255" 
            placeholder="{{ trans('students.password_edit__placeholder') }}">
        {!! $errors->first('password', '<p class="text-danger">:message</p>') !!}
    </div>
</div>
@endif

<div class="form-group">
    <label for="gender" class="col-md-2 control-label"><span style="color:red">*</span>{{ trans('students.gender') }}</label>
	<div class="col-md-10">
        <select name="gender" class="form-control"  required="true">
                <option value="">--Select--</option>
		        <option value="Male" @if(old('gender') == "Male") selected @endif>Male</option>
				<option value="Female" @if(old('gender') == "Female") selected @endif>Female</option>
                <option value="Other" @if(old('gender') == "Other") selected @endif>Other</option>
        </select>
	</div>
</div>

<div class="form-group {{ $errors->has('dob') ? 'has-error' : '' }}">
    <label for="dob" class="col-md-2 control-label"><span style="color:red">*</span>{{ trans('students.dob') }}</label>
    <div class="col-md-10">
        <input class="form-control datepicker" name="dob" type="text" id="dob"
            value="{{ old('dob', optional($user)->dob) }}" minlength="1" maxlength="255" required="true"
            placeholder="{{ trans('students.dob__placeholder') }}">
        {!! $errors->first('dob', '<p class="text-danger">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('phone') ? 'has-error' : '' }}">
    <label for="phone" class="col-md-2 control-label"><span style="color:red">*</span>{{ trans('students.phone') }}</label>
    <div class="col-md-10">
        <input class="form-control" name="phone" type="text" id="phone"
            value="{{ old('phone', optional($user)->phone) }}" minlength="1" maxlength="255" required="true"
            placeholder="{{ trans('students.phone__placeholder') }}">
        {!! $errors->first('phone', '<p class="text-danger">:message</p>') !!}
    </div>
</div>
<div class="form-group {{ $errors->has('whatsapp_number') ? 'has-error' : '' }}">
    <label for="phone" class="col-md-2 control-label"><span style="color:red">*</span>{{ trans('users.whatsappnumber') }}</label>
    <div class="col-md-10">
        Same as Phone: <input type="checkbox" id="checkbox" >

        <input class="form-control" name="whatsapp_number" type="text" id="whatsapp_number"
            value="{{ old('whatsapp_number', optional($user)->whatsapp_number) }}" minlength="1" maxlength="255" required="true"
            placeholder="Enter Whatsapp number without ISD code">
        {!! $errors->first('whatsapp_number', '<p class="text-danger">:message</p>') !!}
    </div>
</div>
<div class="form-group">
    <label for="name" class="col-md-2 control-label"><span style="color:red">*</span>{{ trans('students.course') }}</label>
	<div class="col-md-10">
        <select name="course" class="form-control"  required="true">
                <option value="">--Select--</option>
			@if(isset($courses))
				@foreach ($courses as $id => $course)
				<option value="{{ $id }}"  @if(old('course') == $id) selected @endif>{{ $course }}</option>
				@endforeach
			@endif
        </select>
	</div>
</div>

<div class="form-group">
    <label for="name" class="col-md-2 control-label"><span style="color:red">*</span>{{ trans('students.nation') }}</label>
	<div class="col-md-10">
        <select name="country" class="form-control" required="true">
                <option value="">--Select--</option>
			@if(isset($nationalities))
				@foreach ($nationalities as $id => $nation)
				<option value="{{ $id }}" @if(old('country') == $id) selected @endif>{{ $nation }}</option>
				@endforeach
			@endif
        </select>
	</div>
</div>

<div class="form-group">
    <label for="name" class="col-md-2 control-label"><span style="color:red">*</span>{{ trans('students.currency') }}</label>
	<div class="col-md-10">
        <select name="currency" class="form-control" required="true">
                <option value="">--Select--</option>
			@if(isset($currency))
                @foreach ($currency as $curcy)
				<option value="{{ $curcy['id'] }}" @if(old('currency') == $curcy['id']) selected @endif>{{ $curcy->code }}({{$curcy->symbol}})</option>
				@endforeach
			@endif
        </select>
	</div>
</div>


<div class="form-group">
    <label for="gender" class="col-md-2 control-label"><span style="color:red">*</span>Registration Fee Type</label>
    <div class="col-md-10">
        <input type="radio" id="registration_fee_type_paid" name="registration_fee_type" value="Paid" @if(old('registration_fee_type') == 'Paid') checked @endif checked>
          <label>Paid</label>
          <input type="radio" id="registration_fee_type_free" name="registration_fee_type" value="Free"  @if(old('registration_fee_type') == 'Free') checked @endif>
          <label>Free</label>
        <p class="text-danger" id="registration_fee_type_err"></p>
    </div>
</div>



<div class="form-group {{ $errors->has('class_fee') ? 'has-error' : '' }}">
    <label for="class fee" class="col-md-2 control-label"><span style="color:red">*</span>{{ trans('students.fee') }}</label>
    <div class="col-md-10">
        <input class="form-control" name="class_fee" type="text" id="class_fee" value="{{ old('class_fee', optional($user)->class_fee) }}"
            minlength="1" maxlength="255" required="true" placeholder="{{ trans('students.fee__placeholder') }}">
        {!! $errors->first('class_fee', '<p class="text-danger">:message</p>') !!}
    </div>
</div>
<div class="form-group">
    <label for="online_class_link" class="col-md-2 control-label">{{ trans('students.onlineclasslink') }}</label>
    <div class="col-md-10">
        <textarea class="form-control" name="online_class_link" type="text" id="online_class_link" value="{{ old('online_class_link', optional($user)->online_class_link) }}" minlength="1" maxlength="255"  placeholder="Enter Online Class Link here...">{{ old('online_class_link', optional($user)->online_class_link) }}
            {!! $errors->first('online_class_link', '<p class="text-danger">:message</p>') !!}</textarea>
        
    </div>
</div>


<div class="form-group {{ $errors->has('state') ? 'has-error' : '' }}">
    <label for="state" class="col-md-2 control-label">{{ trans('students.state') }}</label>
    <div class="col-md-10">
        <input class="form-control" name="state" type="text" id="state" value="{{ old('state', optional($user)->state) }}"
            minlength="1" maxlength="255" placeholder="{{ trans('students.state__placeholder') }}">
        {!! $errors->first('state', '<p class="text-danger">:message</p>') !!}
    </div>
</div>

<div class="form-group">
    <label for="address" class="col-md-2 control-label">{{ trans('students.address') }}</label>
    <div class="col-md-10">
        <textarea class="form-control" name="address" type="text" id="name" value="{{ old('address', optional($user)->address) }}"
            minlength="1" maxlength="255" placeholder="{{ trans('students.address__placeholder') }}">{{ old('address', optional($user)->address) }}
            {!! $errors->first('address', '<p class="text-danger">:message</p>') !!}
        </textarea>
    </div>
</div>

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
<script>
$(document).ready(function() {
$("#checkbox").on("change",function(){

if (this.checked ) {
        $("#whatsapp_number").val($("#phone").val());

    } else {

        $('#whatsapp_number').val("");
        $("#whatsapp_number").attr("placeholder", "Enter Whatsapp number without ISD code")  ;
      }    

   });

});
</script>