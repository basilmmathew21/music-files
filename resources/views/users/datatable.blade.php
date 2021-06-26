@if (auth()->user()->isNot($user) && $user->id != '1' )
<form method="POST" action=" {{ route('users.user.destroy', $user->id) }}" accept-charset="UTF-8">
    <input name="_method" value="DELETE" type="hidden">
    {{ csrf_field() }}
    <div class="btn-group btn-group-xs pull-right" role="group">
        <a href=" {{ route('users.user.show', $user->id) }} " class="btn btn-info" title=" {{ trans('users.show') }}">
            <i class="fas fa-eye"></i>
        </a>
        <a href="{{ route('users.user.edit', $user->id) }}" class="btn btn-primary" title="{{ trans('users.edit') }}">
            <i class="fas fa-edit"></i>
        </a>

        <button type="submit" class="btn btn-danger" title="{{ trans('users.delete') }}"
            onclick="return confirm('{{ trans('users.confirm_delete') }}')">
            <i class="fas fa-trash-alt"></i>
        </button>
    </div>
</form>
@endif
