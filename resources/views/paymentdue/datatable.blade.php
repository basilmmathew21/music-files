<form method="POST" action=" {{ route('payments.payments.destroy', $payments->id) }}" accept-charset="UTF-8">
    <input name="_method" value="DELETE" type="hidden">
    {{ csrf_field() }}
    <div class="btn-group btn-group-xs pull-right" role="group">
        <a href=" {{ route('payments.payments.show', $payments->id) }} " class="btn btn-info" title=" {{ trans('payments.show') }}">
            <i class="fas fa-eye"></i>
        </a>
        
        <a href="{{ route('payments.payments.edit', $payments->id) }}" class="btn btn-primary" title="{{ trans('payments.edit') }}">
            <i class="fas fa-edit"></i>
        </a>

        <button type="submit" class="btn btn-danger" title="{{ trans('payments.delete') }}"
            onclick="return confirm('{{ trans('paymenthistory.confirm_delete') }}')">
            <i class="fas fa-trash-alt"></i>
        </button>
        
    </div>
</form>
