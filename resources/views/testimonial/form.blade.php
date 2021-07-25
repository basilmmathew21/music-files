
<!--
<div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
    <label for="profile" class="col-md-2 control-label">{{ trans('students.profile_image') }}</label>
    <div class="col-md-10">
    <input name="profile_image" type="file" class="form-control" id="customFile" />
        {!! $errors->first('profile_image', '<p class="text-danger">:message</p>') !!}
    </div>
</div>
-->
<div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
    <label for="title" class="col-md-2 control-label">{{ trans('testimonial.title') }}</label>
    <div class="col-md-10">
        <input class="form-control" name="title" type="text" id="title" value=""
            minlength="1" maxlength="255" required="true" placeholder="{{ trans('testimonial.title__placeholder') }}">
        {!! $errors->first('title', '<p class="text-danger">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('description') ? 'has-error' : '' }}">
    <label for="description" class="col-md-2 control-label">{{ trans('testimonial.description') }}</label>
    <div class="col-md-10">
        <textarea class="form-control" name="description"  id="description"
            value="" row="4" cols="20" required="true"
            placeholder="{{ trans('testimonial.description__placeholder') }}">
        {!! $errors->first('description', '<p class="text-danger">:message</p>') !!}
    </textarea>
    </div>
</div>


<!-- <div class="form-group">
    <label for="status" class="col-md-2 control-label">{{ trans('testimonial.status') }}</label>
	<div class="col-md-10">
        <select name="gender" class="form-control">
		        <option value="1" @if(old('status') == "pending") selected @endif>Pending</option>
				<option value="2" @if(old('status') == "approved") selected @endif>Approved</option>
                <option value="3" @if(old('status') == "rejected") selected @endif>Rejected</option>
        </select>
	</div>
</div>
<div class="form-group">
    <label for="name" class="col-md-2 control-label">{{ trans('testimonial.active') }}</label>
    <div class="col-md-10">
    
        <select name="is_active" class="form-control">
                <option value="1" @if(old('is_active') == "1") selected @endif>Active</option>
                <option value="0" @if(old('is_active') == "0") selected @endif>Inactive</option>
        </select>
    </div>
</div> -->

