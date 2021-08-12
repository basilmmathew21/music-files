
<form method="POST" action=" {{ route('tutor.classes.destroy', $student->id) }}" accept-charset="UTF-8">
    <input name="_method" value="DELETE" type="hidden">
    {{ csrf_field() }}
    <div class="btn-group btn-group-xs pull-right" role="group">
        <a href=" {{ route('tutor.classes.show', $student->id) }} " class="btn btn-info" title=" {{ trans('classes.show') }}">
            <i class="fas fa-eye"></i>
        </a>
        
       
        
    </div>
</form>

