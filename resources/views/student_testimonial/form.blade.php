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
