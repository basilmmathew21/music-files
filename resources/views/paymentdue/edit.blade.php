@extends('adminlte::page')

@section('content_header')
    <h1 class="m-0 text-dark">{{ !empty($payment->student_name) ? $payment->student_name : 'User' }}</h1>
    <div class="btn-group btn-group-sm pull-right" role="group">

        <a href="{{ route('payments.payments.index') }}" class="btn btn-primary" title="{{ trans('paymenthistory.show_all') }}">
            <i class="fas fa-list-alt"></i>
        </a>

    </div>
@stop

@section('content')

    <div class="panel panel-default">
    <div class="card card-primary card-outline">
    <div class="card-body">
        <div class="panel-body">
            @if ($errors->any())
                <ul class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            @endif
            <dl class="dl-horizontal">
                    <dt>{{ trans('paymenthistory.name') }}</dt>
                    <dd>{{ $payment->student_name }}</dd>                   
                    <dt>{{ trans('paymenthistory.tutor') }}</dt>
                    <dd>{{ $payment->tutor_name }}</dd>
                    <dt>{{ trans('paymenthistory.amount') }}</dt>
                    <dd>{{ $payment->symbol }}{{ $payment->amount }}</dd>
                    <dt>{{ trans('paymenthistory.status') }}</dt>
                    <dd>{{ $payment->status }}</dd>
                    <dt>{{ trans('paymenthistory.payment_method') }}</dt>
                    <dd>{{ $payment->payment_method }}</dd>
                    <dt>{{ trans('paymenthistory.created_at') }}</dt>
                    <dd>{{ $payment->created_at }}</dd>
                    <dt>{{ trans('paymenthistory.updated_at') }}</dt>
                    <dd>{{ $payment->updated_at }}</dd>

                </dl>

            <form method="POST" action="{{ route('payments.payments.update', $payment->id) }}" id="edit_payment_form" name="edit_payment_form" accept-charset="UTF-8" class="form-horizontal">
            {{ csrf_field() }}
            
            <input name="_method" type="hidden" value="PUT">
            @include ('paymenthistory.edit_form', [
                                        'payment' => $payment,
                                      ])

                <div class="form-group">
                    <div class="col-md-offset-2 col-md-10">
                        <input class="btn btn-primary" type="submit" value="{{ trans('students.update') }}">
                    </div>
                </div>
            </form>
 </div> </div>
        </div>
    </div>

@endsection
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"></script>
