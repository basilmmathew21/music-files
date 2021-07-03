
<form method="POST" action=" {{ route('tutors.tutor.destroy', $tutor->id) }}" accept-charset="UTF-8">
    <input name="_method" value="DELETE" type="hidden">
    {{ csrf_field() }}
    <div class="btn-group btn-group-xs pull-right" role="group">
        <a href=" {{ route('tutors.tutor.show', $tutor->id) }} " class="btn btn-info" title=" {{ trans('users.show_tutor') }}">
            <i class="fas fa-eye"></i>
        </a>
        
        <a href="{{ route('tutors.tutor.edit', $tutor->id) }}" class="btn btn-primary" title="{{ trans('users.edit_tutor') }}">
            <i class="fas fa-edit"></i>
        </a>

        <button type="submit" class="btn btn-danger" title="{{ trans('users.delete_tutor') }}"
            onclick="return confirm('{{ trans('users.confirm_delete_tutor') }}')">
            <i class="fas fa-trash-alt"></i>
        </button>
        
    </div>
</form>

