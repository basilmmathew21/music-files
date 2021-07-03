
<div class="form-group {{ $errors->has('status') ? 'has-error' : '' }}">
    <label for="name" class="col-md-2 control-label">{{ trans('testimonial.status') }}</label>
    <div class="col-md-10">
        <select name="status" class="form-control">
                <option value="1" @if($testimonial->status =='pending') selected @endif>Pending</option>
                <option value="2" @if($testimonial->status =='approved') selected @endif>Approved</option>
                <option value="3" @if($testimonial->status =='rejected') selected @endif>Rejected</option>
        </select>
        {!! $errors->first('status', '<p class="text-danger">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
    <label for="email" class="col-md-2 control-label">{{ trans('testimonial.active') }}</label>
    <div class="col-md-10">
        <select name="is_active" class="form-control">
                <option value="1" <?php if($testimonial->is_active == "1") { ?> selected="selected" <?php } ?> >Active</option>
                <option value="0" <?php if($testimonial->is_active == "0") { ?> selected="selected" <?php } ?>>Inactive</option>
        </select>
        {!! $errors->first('is_active', '<p class="text-danger">:message</p>') !!}
    </div>
</div>
