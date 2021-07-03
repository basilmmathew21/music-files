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
      <input type="radio" id="gender_male" name="gender" value="Male"  <?php if(optional($user)->gender=='Male') { ?> checked <?php } ?> >
      <label >Male</label>
      <input type="radio" id="gender_female" name="gender" value="Female" <?php if(optional($user)->gender=='Female') { ?> checked <?php } ?>>
      <label >Female</label>
      <input type="radio" id="gender_others" name="gender" value="Others" <?php if(optional($user)->gender=='Others') { ?> checked <?php } ?>>
      <label >Others</label>
	</div>
</div>

<div class="form-group {{ $errors->has('dob') ? 'has-error' : '' }}">
    <label for="phone" class="col-md-2 control-label">{{ trans('students.dob') }}</label>
    <div class="col-md-10">
        <input class="form-control" name="dob" type="text" id="dob"
            value="{{ old('dob', optional($user)->dob) }}" minlength="1" maxlength="255" required="true"
            placeholder="{{ trans('users.date_info')}}">
        {!! $errors->first('dob', '<p class="text-danger">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('phone') ? 'has-error' : '' }}">
    <label for="phone" class="col-md-2 control-label">{{ trans('students.phone') }}</label>
    <div class="col-md-10">
        <input class="form-control" name="phone" type="text" id="phone"
            value="{{ old('phone', optional($user)->phone) }}" minlength="1" maxlength="255" required="true"
            placeholder="{{ trans('students.phone__placeholder') }}">
        {!! $errors->first('phone', '<p class="text-danger">:message</p>') !!}
    </div>
</div>


<div class="form-group">
    <label for="name" class="col-md-2 control-label">{{ trans('students.nation') }}</label>
	<div class="col-md-10">
        <select name="country" class="form-control">
			@if(isset($nationalities))
				@foreach ($nationalities as $id => $nation)
				<option value="{{ $id }}" <?php if(optional($user)->country_id==$id) { ?> selected="selected" <?php } ?>>{{ $nation }}</option>
				@endforeach
			@endif
        </select>
	</div>
</div>





<div class="form-group {{ $errors->has('state') ? 'has-error' : '' }}">
    <label for="state" class="col-md-2 control-label">{{ trans('students.state') }}</label>
    <div class="col-md-10">
        <input class="form-control" name="state" type="text" id="state" value="{{ old('state', optional($user)->state) }}"
            minlength="1" maxlength="255"  placeholder="Enter State here...">
        {!! $errors->first('name', '<p class="text-danger">:message</p>') !!}
    </div>
</div>
<div class="form-group {{ $errors->has('profile_image') ? 'has-error' : '' }}">
    <label for="state" class="col-md-2 control-label">Profile Image</label>
    <div class="col-md-10">
    @php  $image=""; @endphp

@if($user)
    @php
        if($user->profile_image)
        {
         $image="storage/images/profile/".$user->profile_image;
        }
        else
        $image="";
    @endphp
@endif
 
    
    
        <input  name="profile_image" type="file" id="profile_image" value="">
        <img id = "preview"  alt = "Preview image"  src="{{asset($image)}}"   />
        {!! $errors->first('profile_image', '<p class="text-danger">:message</p>') !!}
    </div>
</div>

<div class="form-group">
    <label for="address" class="col-md-2 control-label">{{ trans('students.address') }}</label>
    <div class="col-md-10">
        <textarea class="form-control" name="address" type="text" id="name" value="{{ old('address', optional($user)->address) }}"
            minlength="1" maxlength="255"  placeholder="Enter Address here...">
        {!! $errors->first('address', '<p class="text-danger">:message</p>') !!}
        </textarea>
    </div>
</div>
<div class="form-group">
    <label for="address" class="col-md-2 control-label">Teaching Stream</label>
    <div class="col-md-10">
        <textarea class="form-control" name="teaching_stream" type="text" id="teaching_stream" value=""
            minlength="1" maxlength="255"  placeholder="">
            @if(isset($tutor) && !empty($tutor)) {{ optional($tutor[0])->teaching_stream}} @endif
        {!! $errors->first('teaching_stream', '<p class="text-danger">:message</p>') !!}
        </textarea>
    </div>
</div>
<div class="form-group">
    <label for="address" class="col-md-2 control-label">Educational Qualification</label>
    <div class="col-md-10">
        <textarea class="form-control" name="educational_qualification" type="text" id="educational_qualification" value=""
            minlength="1" maxlength="255"  placeholder="">
            @if(isset($tutor) && !empty($tutor))  {{ optional($tutor[0])->educational_qualification }} @endif
        {!! $errors->first('educational_qualification', '<p class="text-danger">:message</p>') !!}
        </textarea>
    </div>
</div>
<div class="form-group">
    <label for="address" class="col-md-2 control-label">Teaching Experience</label>
    <div class="col-md-10">
        <textarea class="form-control" name="teaching_experience" type="text" id="teaching_experience" value=""
            minlength="1" maxlength="255"  placeholder=""> @if(isset($tutor) && !empty($tutor)) {{ optional($tutor[0])->teaching_experience}} @endif
        {!! $errors->first('teaching_experience', '<p class="text-danger">:message</p>') !!}
        </textarea>
    </div>
</div>
<div class="form-group">
    <label for="address" class="col-md-2 control-label">Performance Experience</label>
    <div class="col-md-10">
        <textarea class="form-control" name="performance_experience" type="text" id="performance_experience" value=""
            minlength="1" maxlength="255"  placeholder="">@if(isset($tutor) && !empty($tutor)) {{ optional($tutor[0])->performance_experience}} @endif
        {!! $errors->first('performance_experience', '<p class="text-danger">:message</p>') !!}
        </textarea>
    </div>
</div>
<div class="form-group">
    <label for="address" class="col-md-2 control-label">Other Details</label>
    <div class="col-md-10">
        <textarea class="form-control" name="other_details" type="text" id="other_details" value=""
            minlength="1" maxlength="255" placeholder=""> @if(isset($tutor) && !empty($tutor)) {{optional($tutor[0])->other_details}} @endif
        {!! $errors->first('other_details', '<p class="text-danger">:message</p>') !!}
        </textarea>
    </div>
</div>



@if(!$user)
<div class="form-group">
    <label for="students" class="col-md-2 control-label">Students</label>
    <div class="col-md-10">
        <select class="form-control" multiple="true" id="studentpicker" name="students[]" >
            <option value="">--Select--</option>
            @foreach ($students as $id => $stud)
            <option value="{{ $id }}">{{ $stud }}</option>
          @endforeach

        </select>
    </div>
</div>
@endif
@if($user)
<div class="form-group">
    <label for="students" class="col-md-2 control-label">Students</label>
    <div class="col-md-10">
        <select class="form-control" multiple="true" id="studentpicker" name="students[]" >
            <option value="">--Select--</option>
            @if($selected)
             @foreach($students as $id => $stud)
                 <option value="{{ $id }}" @if(in_array( $id ,$selected)) selected @endif >{{ $stud }}</option>
             @endforeach
            @endif
            @if(!$selected)
            @foreach($students as $id => $stud)
                 <option value="{{ $id }}" >{{ $stud }}</option>
             @endforeach
            
             @endif

        </select>
    </div>
</div>
@endif
<div class="form-group">
    <label for="name" class="col-md-2 control-label">{{ trans('students.status') }}</label>
	<div class="col-md-10">
        <select name="status" class="form-control">
		        <option value="1" <?php if(optional($user)->is_active=='1') { ?> echo "selected" <?php } ?>>Active</option>
				<option value="0" <?php if(optional($user)->is_active=='0') { ?> echo "selected" <?php } ?>>Inactive</option>
        </select>
	</div>
</div>
@section('css')
<link rel="stylesheet" href="{{ URL::asset('vendor/select2/css/select2.min.css') }}"  />
<link rel="stylesheet" href="{{ URL::asset('vendor/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}" />  
@stop

@section('js')

<script type="text/javascript" src="{{ URL::asset('vendor/bootstrap/js/bootstrap.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('vendor/jquery/jquery.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('vendor/select2/js/select2.min.js') }}"></script>

<script>
 $(document).ready(function() {
    
          $('#studentpicker').select2();
         
        });
$("#profile_image").change(function() {
            display(this);
});
 function display(input) {
   if (input.files && input.files[0]) {
      var reader = new FileReader();
      reader.onload = function(event) {
         $('#preview').show();

         $('#preview').attr('src', event.target.result);
      }
      reader.readAsDataURL(input.files[0]);
   }
}
        </script>
@stop
