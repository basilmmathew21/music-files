<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label">Name</label>
        <input class="form-control  {{ $errors->has('name') ? 'is-invalid' : '' }}" name="name" type="text" id="name" value="{{ old('name', optional($tutorenquiry)->name) }}" minlength="1" maxlength="255" required="true" placeholder="Name">
        @if($errors->has('name'))
        <div class="invalid-feedback">
            <strong>{{ $errors->first('name') }}</strong>
        </div>
        @endif
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label">Date of Birth</label>

        <input class="form-control" name="dob" type="text" id="dob" value="{{ old('dob', optional($tutorenquiry)->dob) }}" minlength="1" maxlength="255" required="true" placeholder="dob">
        @if($errors->has('dob'))
        <div class="invalid-feedback">
            <strong>{{ $errors->first('dob') }}</strong>
        </div>
        @endif
    </div>
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label">Email</label>
        <input class="form-control" name="email" type="email" id="email" value="{{ old('email', optional($tutorenquiry)->email) }}" minlength="1" maxlength="255" required="true" placeholder="email">
        @if($errors->has('email'))
        <div class="invalid-feedback">
            <strong>{{ $errors->first('email') }}</strong>
        </div>
        @endif
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label">Phone</label>

        <input class="form-control" name="phone" type="text" id="phone" value="{{ old('phone', optional($tutorenquiry)->phone) }}" minlength="1" maxlength="10" required="true" placeholder="phone">
        @if($errors->has('phone'))
        <div class="invalid-feedback">
            <strong>{{ $errors->first('phone') }}</strong>
        </div>
        @endif
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label">Whatsapp Number</label>Same as Phone: <input type="checkbox" id="checkbox" >
        <input class="form-control {{ $errors->has('whatsapp_number') ? 'is-invalid' : '' }}" name="whatsapp_number" id="whatsapp_number" type="text" value="{{ old('whatsapp_number', optional($tutorenquiry)->whatsapp_number) }}" minlength="1" maxlength="255"  required="true"  placeholder="Enter Whatsapp number without ISD code">

        @if($errors->has('whatsapp_number'))
        <div class="invalid-feedback">
            <strong>{{ $errors->first('whatsapp_number') }}</strong>
        </div>
        @endif
    </div>
</div>


<div class="row">
    <div class="col-md-6 mb-3"> <label class="form-label">Gender</label>

        <select name="gender" class="form-control" required="true">
            <option value="" selected disabled>--Choose gender--</option>
            <option value="Male" @if(old('gender')=="Male" ) selected @endif>Male</option>
            <option value="Female" @if(old('gender')=="Female" ) selected @endif>Female</option>
            <option value="Other" @if(old('gender')=="Other" ) selected @endif>Other</option>
        </select>
        @if($errors->has('gender'))
        <div class="invalid-feedback">
            <strong>{{ $errors->first('gender') }}</strong>
        </div>
        @endif
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label">Address</label>
        <input class="form-control" name="Address" type="Address" id="Address" value="{{ old('Address', optional($tutorenquiry)->Address) }}" minlength="1" maxlength="255" required="true" placeholder="Address">
        @if($errors->has('Address'))
        <div class="invalid-feedback">
            <strong>{{ $errors->first('Address') }}</strong>
        </div>
        @endif
    </div>
</div>




<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label">State</label>
        <input class="form-control" name="state" type="text" id="state" value="{{ old('state', optional($tutorenquiry)->state) }}" minlength="1" maxlength="250" required="true" placeholder="state">
        @if($errors->has('State'))
        <div class="invalid-feedback">
            <strong>{{ $errors->first('State') }}</strong>
        </div>
        @endif
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label">Country</label>
        <select name="country_id" class="form-control">
            @foreach($country as $cntry)
            <option value="{{ $cntry->id }}" @if(old('country_id')==$cntry->id ) selected @endif>{{ $cntry->name }}</option>
            @endforeach
        </select>
        @if($errors->has('country_id'))
        <div class="invalid-feedback">
            <strong>{{ $errors->first('country_id') }}</strong>
        </div>
        @endif
    </div>
</div>




<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label">Educational Qualification</label>

        <input class="form-control" name="educational_qualification" type="text" id="educational_qualification" value="{{ old('educational_qualification', optional($tutorenquiry)->educational_qualification) }}" minlength="1" required="true" placeholder="Educational Qualification">
        @if($errors->has('educational_qualification'))
        <div class="invalid-feedback">
            <strong>{{ $errors->first('educational_qualification') }}</strong>
        </div>
        @endif

    </div>
    <div class="col-md-6 mb-3">

        <label class="form-label">Teaching Stream</label>
        <input class="form-control" name="teaching_stream" type="text" id="teaching_stream" value="{{ old('teaching_stream', optional($tutorenquiry)->teaching_stream) }}" minlength="1" required="true" placeholder="Teaching Stream">
        @if($errors->has('teaching_stream'))
        <div class="invalid-feedback">
            <strong>{{ $errors->first('teaching_stream') }}</strong>
        </div>
        @endif
    </div>
</div>


<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label">Teaching Experience</label>
        <input class="form-control" name="teaching_experience" type="text" id="teaching_experience" value="{{ old('teaching_experience', optional($tutorenquiry)->teaching_experience) }}" minlength="1" required="true" placeholder="Teaching Experience">
        @if($errors->has('teaching_experience'))
        <div class="invalid-feedback">
            <strong>{{ $errors->first('teaching_experience') }}</strong>
        </div>
        @endif

    </div>
    <div class="col-md-6 mb-3">

        <label class="form-label">Performance Experience</label>
        <input class="form-control" name="performance_experience" type="text" id="performance_experience" value="{{ old('performance_experience', optional($tutorenquiry)->performance_experience) }}" minlength="1" required="true" placeholder="Teaching Stream">
        @if($errors->has('performance_experience'))
        <div class="invalid-feedback">
            <strong>{{ $errors->first('performance_experience') }}</strong>
        </div>
        @endif
    </div>
</div>


<div class="row">
    <div class="col-md-12 mb-3">
        <label class="form-label">Other Details</label>

        <textarea class="form-control" name="other_details" id="other_details" value="{{ old('other_details', optional($tutorenquiry)->other_details) }}" row="4" cols="20" required="true" placeholder="Other Details">{!! $errors->first('other_details', '<p class="text-danger">:message</p>') !!}</textarea>
        @if($errors->has('other_details'))
        <div class="invalid-feedback">
            <strong>{{ $errors->first('other_details') }}</strong>
        </div>
        @endif

    </div>
</div>


<!-- <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
    <label for="email" class="col-md-2 control-label">Email</label>
    <div class="col-md-10">
        <input class="form-control" name="email" type="email" id="email" value="{{ old('email', optional($tutorenquiry)->email) }}" minlength="1" maxlength="255" required="true" placeholder="email">
        {!! $errors->first('email', '<p class="text-danger">:message</p>') !!}
    </div>
</div>
<div class="form-group {{ $errors->has('phone') ? 'has-error' : '' }}">
    <label for="phone" class="col-md-2 control-label">Phone</label>
    <div class="col-md-10">
        <input class="form-control" name="phone" type="text" id="phone" value="{{ old('phone', optional($tutorenquiry)->phone) }}" minlength="1" maxlength="10" required="true" placeholder="phone">
        {!! $errors->first('phone', '<p class="text-danger">:message</p>') !!}
    </div>
</div>
<div class="form-group {{ $errors->has('gender') ? 'has-error' : '' }}">
    <label for="gender" class="col-md-2 control-label">Gender</label>
    <div class="col-md-10">
        <select name="gender" class="form-control" required="true">
            <option value="" selected disabled>--Choose gender--</option>
            <option value="Male" @if(old('gender')=="Male" ) selected @endif>Male</option>
            <option value="Female" @if(old('gender')=="Female" ) selected @endif>Female</option>
            <option value="Other" @if(old('gender')=="Other" ) selected @endif>Other</option>
        </select>
    </div>
</div> -->
<!-- <div class="form-group {{ $errors->has('phone') ? 'has-error' : '' }}">
    <label for="phone" class="col-md-2 control-label">Phone</label>
    <div class="col-md-10">
        <input class="form-control" name="phone" type="text" id="phone" value="{{ old('phone', optional($tutorenquiry)->phone) }}"
            minlength="1" maxlength="10" required="true" placeholder="phone">
        {!! $errors->first('phone', '<p class="text-danger">:message</p>') !!}
    </div>
</div> -->
<!-- <div class="form-group {{ $errors->has('state') ? 'has-error' : '' }}">
    <label for="state" class="col-md-2 control-label">State</label>
    <div class="col-md-10">
        <input class="form-control" name="state" type="text" id="state" value="{{ old('state', optional($tutorenquiry)->state) }}" minlength="1" maxlength="250" required="true" placeholder="state">
        {!! $errors->first('state', '<p class="text-danger">:message</p>') !!}
    </div>
</div> -->
<!-- <div class="form-group {{ $errors->has('address') ? 'has-error' : '' }}">
    <label for="address" class="col-md-2 control-label">Address</label>
    <div class="col-md-10">
        <input class="form-control" name="address" type="text" id="address" value="{{ old('address', optional($tutorenquiry)->address) }}" minlength="1" required="true" placeholder="address">
        {!! $errors->first('address', '<p class="text-danger">:message</p>') !!}
    </div>
</div> -->
<!-- <div class="form-group {{ $errors->has('gender') ? 'has-error' : '' }}">
    <label for="gender" class="col-md-2 control-label">Country</label>
    <div class="col-md-10">
        <select name="country_id" class="form-control">
            @foreach($country as $cntry)
            <option value="{{ $cntry->id }}" @if(old('country_id')==$cntry->id ) selected @endif>{{ $cntry->name }}</option>
            @endforeach
        </select>
    </div>
</div> -->
<!-- <div class="form-group {{ $errors->has('teaching_stream') ? 'has-error' : '' }}">
    <label for="teaching_stream" class="col-md-2 control-label">Teaching Stream</label>
    <div class="col-md-10">
        <input class="form-control" name="teaching_stream" type="text" id="teaching_stream" value="{{ old('teaching_stream', optional($tutorenquiry)->teaching_stream) }}" minlength="1" required="true" placeholder="Teaching Stream">
        {!! $errors->first('teaching_stream', '<p class="text-danger">:message</p>') !!}
    </div>
</div>
<div class="form-group {{ $errors->has('educational_qualification') ? 'has-error' : '' }}">
    <label for="educational_qualification" class="col-md-4 control-label">Educational Qualification</label>
    <div class="col-md-10">
        <input class="form-control" name="educational_qualification" type="text" id="educational_qualification" value="{{ old('educational_qualification', optional($tutorenquiry)->educational_qualification) }}" minlength="1" required="true" placeholder="Educational Qualification">
        {!! $errors->first('educational_qualification', '<p class="text-danger">:message</p>') !!}
    </div>
</div> -->
<!-- <div class="form-group {{ $errors->has('teaching_experience') ? 'has-error' : '' }}">
    <label for="teaching_experience" class="col-md-4 control-label">Teaching Experience</label>
    <div class="col-md-10">
        <input class="form-control" name="teaching_experience" type="text" id="teaching_experience" value="{{ old('teaching_experience', optional($tutorenquiry)->teaching_experience) }}" minlength="1" required="true" placeholder="Teaching Experience">
        {!! $errors->first('teaching_experience', '<p class="text-danger">:message</p>') !!}
    </div>
</div>
<div class="form-group {{ $errors->has('performance_experience') ? 'has-error' : '' }}">
    <label for="performance_experience" class="col-md-4 control-label">Performance Experience</label>
    <div class="col-md-10">
        <input class="form-control" name="performance_experience" type="text" id="performance_experience" value="{{ old('performance_experience', optional($tutorenquiry)->performance_experience) }}" minlength="1" required="true" placeholder="Performance Experience">
        {!! $errors->first('performance_experience', '<p class="text-danger">:message</p>') !!}
    </div>
</div> -->

<!-- 
<div class="form-group {{ $errors->has('other_details') ? 'has-error' : '' }}">
    <label for="other_details" class="col-md-2 control-label">Other Details</label>
    <div class="col-md-10">
        <textarea class="form-control" name="other_details" id="other_details" value="{{ old('other_details', optional($tutorenquiry)->other_details) }}" row="4" cols="20" required="true" placeholder="Other Details">
        {!! $errors->first('other_details', '<p class="text-danger">:message</p>') !!}
    </textarea>
    </div>
</div> -->
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