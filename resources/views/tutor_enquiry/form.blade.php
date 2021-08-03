<div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
    <label for="name" class="col-md-2 control-label">Name</label>
    <div class="col-md-10">
        <input class="form-control" name="name" type="text" id="name" value="{{ old('name', optional($tutorenquiry)->name) }}"
            minlength="1" maxlength="255" required="true" placeholder="Name">
        {!! $errors->first('name', '<p class="text-danger">:message</p>') !!}
    </div>
</div>
<div class="form-group {{ $errors->has('dob') ? 'has-error' : '' }}">
    <label for="dob" class="col-md-2 control-label">Date of Birth</label>
    <div class="col-md-10">
        <input class="form-control" name="dob" type="text" id="dob" value="{{ old('dob', optional($tutorenquiry)->dob) }}"
            minlength="1" maxlength="255" required="true" placeholder="dob">
        {!! $errors->first('dob', '<p class="text-danger">:message</p>') !!}
    </div>
</div>
<div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
    <label for="email" class="col-md-2 control-label">Email</label>
    <div class="col-md-10">
        <input class="form-control" name="email" type="email" id="email" value="{{ old('email', optional($tutorenquiry)->email) }}"
            minlength="1" maxlength="255" required="true" placeholder="email">
        {!! $errors->first('email', '<p class="text-danger">:message</p>') !!}
    </div>
</div>
<div class="form-group {{ $errors->has('phone') ? 'has-error' : '' }}">
    <label for="phone" class="col-md-2 control-label">Phone</label>
    <div class="col-md-10">
        <input class="form-control" name="phone" type="text" id="phone" value="{{ old('phone', optional($tutorenquiry)->phone) }}"
            minlength="1" maxlength="10" required="true" placeholder="phone">
        {!! $errors->first('phone', '<p class="text-danger">:message</p>') !!}
    </div>
</div>
<div class="form-group {{ $errors->has('gender') ? 'has-error' : '' }}">
    <label for="gender" class="col-md-2 control-label">Gender</label>
    <div class="col-md-10">
        <select name="gender" class="form-control">
            <option value="male" @if(old('status') == "male") selected @endif>Male</option>
            <option value="female" @if(old('status') == "female") selected @endif>Female</option>
            <option value="others" @if(old('status') == "others") selected @endif>Others</option>
        </select>
    </div>
</div>
<!-- <div class="form-group {{ $errors->has('phone') ? 'has-error' : '' }}">
    <label for="phone" class="col-md-2 control-label">Phone</label>
    <div class="col-md-10">
        <input class="form-control" name="phone" type="text" id="phone" value="{{ old('phone', optional($tutorenquiry)->phone) }}"
            minlength="1" maxlength="10" required="true" placeholder="phone">
        {!! $errors->first('phone', '<p class="text-danger">:message</p>') !!}
    </div>
</div> -->
<div class="form-group {{ $errors->has('state') ? 'has-error' : '' }}">
    <label for="state" class="col-md-2 control-label">State</label>
    <div class="col-md-10">
        <input class="form-control" name="state" type="text" id="state" value="{{ old('state', optional($tutorenquiry)->state) }}"
            minlength="1" maxlength="250" required="true" placeholder="state">
        {!! $errors->first('state', '<p class="text-danger">:message</p>') !!}
    </div>
</div>
<div class="form-group {{ $errors->has('address') ? 'has-error' : '' }}">
    <label for="address" class="col-md-2 control-label">Address</label>
    <div class="col-md-10">
        <input class="form-control" name="address" type="text" id="address" value="{{ old('address', optional($tutorenquiry)->address) }}"
            minlength="1" required="true" placeholder="address">
        {!! $errors->first('address', '<p class="text-danger">:message</p>') !!}
    </div>
</div>
<div class="form-group {{ $errors->has('gender') ? 'has-error' : '' }}">
    <label for="gender" class="col-md-2 control-label">Country</label>
    <div class="col-md-10">
        <select name="country_id" class="form-control">
            @foreach($country as $cntry)
            <option value="{{ $cntry->id }}" @if(old('country_id') == $cntry->id ) selected @endif>{{ $cntry->name }}</option>
            @endforeach
        </select>
    </div>
</div>
<div class="form-group {{ $errors->has('teaching_stream') ? 'has-error' : '' }}">
    <label for="teaching_stream" class="col-md-2 control-label">Teaching Stream</label>
    <div class="col-md-10">
        <input class="form-control" name="teaching_stream" type="text" id="teaching_stream" value="{{ old('teaching_stream', optional($tutorenquiry)->teaching_stream) }}"
            minlength="1" required="true" placeholder="Teaching Stream">
        {!! $errors->first('teaching_stream', '<p class="text-danger">:message</p>') !!}
    </div>
</div>
<div class="form-group {{ $errors->has('educational_qualification') ? 'has-error' : '' }}">
    <label for="educational_qualification" class="col-md-4 control-label">Educational Qualification</label>
    <div class="col-md-10">
        <input class="form-control" name="educational_qualification" type="text" id="educational_qualification" value="{{ old('educational_qualification', optional($tutorenquiry)->educational_qualification) }}"
            minlength="1" required="true" placeholder="Educational Qualification">
        {!! $errors->first('educational_qualification', '<p class="text-danger">:message</p>') !!}
    </div>
</div>
<div class="form-group {{ $errors->has('teaching_experience') ? 'has-error' : '' }}">
    <label for="teaching_experience" class="col-md-4 control-label">Teaching Experience</label>
    <div class="col-md-10">
        <input class="form-control" name="teaching_experience" type="text" id="teaching_experience" value="{{ old('teaching_experience', optional($tutorenquiry)->teaching_experience) }}"
            minlength="1" required="true" placeholder="Teaching Experience">
        {!! $errors->first('teaching_experience', '<p class="text-danger">:message</p>') !!}
    </div>
</div>
<div class="form-group {{ $errors->has('performance_experience') ? 'has-error' : '' }}">
    <label for="performance_experience" class="col-md-4 control-label">Performance Experience</label>
    <div class="col-md-10">
        <input class="form-control" name="performance_experience" type="text" id="performance_experience" value="{{ old('performance_experience', optional($tutorenquiry)->performance_experience) }}"
            minlength="1" required="true" placeholder="Performance Experience">
        {!! $errors->first('performance_experience', '<p class="text-danger">:message</p>') !!}
    </div>
</div>
<div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
    <label for="profile" class="col-md-2 control-label">Profile Image</label>
    <div class="col-md-10">
    <input name="image" type="file" class="form-control" id="customFile" />
        {!! $errors->first('profile_image', '<p class="text-danger">:message</p>') !!}
    </div>
    <!-- <img id="preview-image" src="https://www.riobeauty.co.uk/images/product_image_not_found.gif" alt="preview image" style="max-width: 250px;height: 175px;"> -->
</div>

<div class="form-group {{ $errors->has('other_details') ? 'has-error' : '' }}">
    <label for="other_details" class="col-md-2 control-label">Other Details</label>
    <div class="col-md-10">
        <textarea class="form-control" name="other_details"  id="other_details"
            value="{{ old('other_details', optional($tutorenquiry)->other_details) }}" row="4" cols="20" required="true"
            placeholder="Other Details">
        {!! $errors->first('other_details', '<p class="text-danger">:message</p>') !!}
    </textarea>
    </div>
</div>




