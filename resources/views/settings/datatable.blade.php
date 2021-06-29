
<form method="POST" action="" accept-charset="UTF-8">
    <input name="_method" value="DELETE" type="hidden">
    {{ csrf_field() }}
    <div class="btn-group btn-group-xs pull-right" role="group">
       
        <a href="{{ route('settings.settings.edit', $settings->id) }}" class="btn btn-primary" title="{{ trans('users.edit') }}">
            <i class="fas fa-edit"></i>
        </a>

       
    </div>
</form>

