@if (auth()->user()->isNot($student) && $student->id != '1' )
<form method="POST" action=" {{ route('students.student.destroy', $student->id) }}" accept-charset="UTF-8">
    <input name="_method" value="DELETE" type="hidden">
    {{ csrf_field() }}
    <div class="btn-group btn-group-xs pull-right" role="group">
        <a href=" {{ route('students.student.show', $student->id) }} " class="btn btn-info" title=" {{ trans('students.show') }}">
            <i class="fas fa-eye"></i>
        </a>
        
        <a href="{{ route('students.student.edit', $student->id) }}" class="btn btn-primary" title="{{ trans('students.edit') }}">
            <i class="fas fa-edit"></i>
        </a>

        <button type="submit" class="btn btn-danger" title="{{ trans('students.delete') }}"
            onclick="return confirm('{{ trans('students.confirm_delete') }}')">
            <i class="fas fa-trash-alt"></i>
        </button>
        
    </div>
</form>
@endif
