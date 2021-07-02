<form method="POST" action=" {{ route('testimonials.testimonial.destroy', $testimonial->id) }}" accept-charset="UTF-8">
    <input name="_method" value="DELETE" type="hidden">
    {{ csrf_field() }}
    <div class="btn-group btn-group-xs pull-right" role="group">
        <a href=" {{ route('testimonials.testimonial.show', $testimonial->id) }} " class="btn btn-info" title=" {{ trans('testimonial.show') }}">
            <i class="fas fa-eye"></i>
        </a>
        
        <a href="{{ route('testimonials.testimonial.edit', $testimonial->id) }}" class="btn btn-primary" title="{{ trans('testimonial.edit') }}">
            <i class="fas fa-edit"></i>
        </a>

        <button type="submit" class="btn btn-danger" title="{{ trans('testimonial.delete') }}"
            onclick="return confirm('{{ trans('testimonial.confirm_delete') }}')">
            <i class="fas fa-trash-alt"></i>
        </button>
        
    </div>
</form>
