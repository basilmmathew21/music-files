@extends('adminlte::page')

@section('content_header')
<h1 class="m-0 text-dark">{{ isset($payment->student_name) ? $payment->student_name : 'User' }}</h1>
<div class="btn-group btn-group-sm pull-right" role="group">
    <form method="POST" action="{!! route('payments.payments.destroy', $payment->main_id) !!}" accept-charset="UTF-8">
        <input name="_method" value="DELETE" type="hidden">
        {{ csrf_field() }}
        <div class="btn-group btn-group-sm" role="group">
            <a href="{{ route('payments.payments.index') }}" class="btn btn-primary" title="{{ trans('paymenthistory.show_all') }}">
                <i class="fas fa-list-alt"></i>
            </a>
            
            <a href="{{ route('payments.payments.edit', $payment->main_id ) }}" class="btn btn-primary"
                title="{{ trans('paymenthistory.edit') }}">
                <i class="fas fa-edit"></i>
            </a>
            <button type="submit" class="btn btn-danger" title="{{ trans('paymenthistory.delete') }}"
                onclick="return confirm('{{ trans('paymenthistory.confirm_delete') }}')">
                <i class="fas fa-trash-alt"></i>
            </button>
            
        </div>
    </form>
</div>
@stop

@section('content')

<div class="panel panel-default">
    <div class="card card-primary card-outline">
        <div class="card-body">
            <div class="panel-body">
                <dl class="dl-horizontal">
                    <dt>{{ trans('paymenthistory.name') }}</dt>
                    <dd>{{ $payment->student_name }}</dd>                   
                    <dt>{{ trans('paymenthistory.tutor') }}</dt>
                    <dd>{{ $payment->tutor_name }}</dd>
                    <dt>{{ trans('paymenthistory.fee_type') }}</dt>
                     @if($payment->fee_type == 'registration_fee')
                    <dd>Registration Fee</dd>
                    @else
                    <dd>Class Fee</dd>
                    @endif
                    <dt>{{ trans('paymenthistory.amount') }}</dt>
                    <dd>{{ $payment->symbol }}{{ $payment->amount }}</dd>
                    <dt>{{ trans('paymenthistory.status') }}</dt>
                    <dd>{{ $payment->status }}</dd>
                    <dt>{{ trans('paymenthistory.payment_method') }}</dt>
                    <dd>{{ $payment->payment_method }}</dd>
                    <dt>{{ trans('paymenthistory.payment_date') }}</dt>
                    <dd>{{ $payment->payment_date }}</dd>
                    <dt>{{ trans('paymenthistory.no_of_classes') }}</dt>
                    <dd>{{ $payment->no_of_classes }}</dd>
                    <dt>{{ trans('paymenthistory.created_at') }}</dt>
                    <dd>{{ $payment->created_at }}</dd>
                    <dt>{{ trans('paymenthistory.updated_at') }}</dt>
                    <dd>{{ $payment->updated_at }}</dd>

                </dl>
                
            </div>
        </div>
    </div>
</div>

@endsection