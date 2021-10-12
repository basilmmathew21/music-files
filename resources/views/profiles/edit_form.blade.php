

<div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
    <label for="profile" class="col-md-2 control-label">{{ trans('users.profile_image') }}</label>
    <div class="col-md-10">
    <input name="profile_image" type="file" class="form-control" id="customFile" />
        {!! $errors->first('profile_image', '<p class="text-danger">:message</p>') !!}
    </div>
</div>
<div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
    <label for="name" class="col-md-2 control-label"><span style="color:red">*</span>{{ trans('users.name') }}</label>
    <div class="col-md-10">
        <input class="form-control" name="name" type="text" id="name" value="{{ old('name', optional($user)->name) }}"
            minlength="1" maxlength="255" required="true" placeholder="{{ trans('students.name__placeholder') }}">
        {!! $errors->first('name', '<p class="text-danger">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
    <label for="email" class="col-md-2 control-label"><span style="color:red">*</span>{{ trans('users.email') }}</label>
    <div class="col-md-10">
        <input class="form-control" name="email" type="text" id="email"
            value="{{ old('email', optional($user)->email) }}" minlength="1" maxlength="255" required="true"
            placeholder="{{ trans('students.email__placeholder') }}">
        {!! $errors->first('email', '<p class="text-danger">:message</p>') !!}
    </div>
</div>


@if(!$user)
<div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
    <label for="password" class="col-md-2 control-label"><span style="color:red">*</span>{{ trans('users.password') }}</label>
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
    <label for="password" class="col-md-2 control-label">{{ trans('users.password') }}</label>
    <div class="col-md-10">
        <input class="form-control" name="password" type="password" id="password"
            value="" minlength="1" maxlength="255" 
            placeholder="{{ trans('students.password_edit__placeholder') }}">
        {!! $errors->first('password', '<p class="text-danger">:message</p>') !!}
    </div>
</div>
@endif

<div class="form-group">
    <label for="gender" class="col-md-2 control-label"><span style="color:red">*</span>{{ trans('users.gender') }}</label>
	<div class="col-md-10">
        <select name="gender" class="form-control" required="true">
                <option value="">--Select--</option>
		        <option value="Male" @if($user->gender =='Male') selected @endif>Male</option>
				<option value="Female" @if($user->gender =='Female') selected @endif>Female</option>
                <option value="Other" @if($user->gender =='Other') selected @endif>Other</option>
        </select>
	</div>
</div>

<div class="form-group {{ $errors->has('dob') ? 'has-error' : '' }}">
    <label for="dob" class="col-md-2 control-label"><span style="color:red">*</span>{{ trans('users.dob') }}</label>
    <div class="col-md-10">
        <input class="form-control" name="dob" type="text" id="dob"
            value="{{ old('dob', optional($user)->dob) }}" minlength="1" maxlength="255" required="true"
            placeholder="{{ trans('students.dob__placeholder') }}">
        {!! $errors->first('dob', '<p class="text-danger">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('phone') ? 'has-error' : '' }}">
    <label for="phone" class="col-md-2 control-label"><span style="color:red">*</span>{{ trans('users.phone') }}</label>
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
    <label for="name" class="col-md-2 control-label"><span style="color:red">*</span>{{ trans('users.nation') }}</label>
	<div class="col-md-10">
        <select name="country" class="form-control" required="true">
        <option value="">--Select--</option>
			@if(isset($nationalities))
				@foreach ($nationalities as $id => $nation)
				<option value="{{ $id }}" @if($user->country_id == $id) selected @endif>{{ $nation }}</option>
				@endforeach
			@endif
        </select>
	</div>
</div>
<!--
<div class="form-group">
    <label for="name" class="col-md-2 control-label"><span style="color:red">*</span>{{ trans('students.currency') }}</label>
	<div class="col-md-10">
        <select name="currency" class="form-control" required="true">
        <option value="">--Select--</option>
			@if(isset($currency))
				@foreach ($currency as $curcy)
				<option value="{{ $curcy['id'] }}" @if($curcy->id == $id) selected @endif>  {{ $curcy->code }}({{$curcy->symbol}})</option>
				@endforeach
			@endif
        </select>
	</div>
</div>
-->


<div class="form-group {{ $errors->has('state') ? 'has-error' : '' }}">
    <label for="state" class="col-md-2 control-label">{{ trans('users.state') }}</label>
    <div class="col-md-10">
        <input class="form-control" name="state" type="text" id="state" value="{{ old('state', optional($user)->state) }}"
            minlength="1" maxlength="255" placeholder="{{ trans('students.name__placeholder') }}">
        {!! $errors->first('name', '<p class="text-danger">:message</p>') !!}
    </div>
</div>

<div class="form-group">
    <label for="address" class="col-md-2 control-label">{{ trans('users.address') }}</label>
    <div class="col-md-10">
        <textarea class="form-control" name="address" type="text" id="name" value="{{ old('address', optional($user)->address) }}"
            minlength="1" maxlength="255" placeholder="{{ trans('students.address__placeholder') }}">{{ old('address', optional($user)->address) }}
            {!! $errors->first('address', '<p class="text-danger">:message</p>') !!}
        </textarea>
    </div>
</div>

<!--
<div class="form-group">
    <label for="name" class="col-md-2 control-label">{{ trans('students.status') }}</label>
	<div class="col-md-10">
    
        <select name="status" class="form-control">
        <option value="">--Select--</option>
		        <option value="1" <?php if($user->is_active == "Active") { ?> selected="selected" <?php } ?> >Active</option>
				<option value="0" <?php if($user->is_active == "Inactive") { ?> selected="selected" <?php } ?>>Inactive</option>
        </select>
	</div>
</div>
-->
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