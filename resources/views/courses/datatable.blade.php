
<form method="POST" action=" {{ route('courses.course.destroy', $courses->id) }}" accept-charset="UTF-8">
    <input name="_method" value="DELETE" type="hidden">
    {{ csrf_field() }}
    <div class="btn-group btn-group-xs pull-right" role="group">
       
        <a href="{{ route('courses.course.edit', $courses->id) }}" class="btn btn-primary" title="{{ trans('users.edit_course') }}">
            <i class="fas fa-edit"></i>
        </a>

        <button type="submit" class="btn btn-danger" title="{{ trans('users.delete_course') }}"
            onclick="return confirm('{{ trans('users.confirm_delete_course') }}')">
            <i class="fas fa-trash-alt"></i>
        </button>
    </div>
</form>

