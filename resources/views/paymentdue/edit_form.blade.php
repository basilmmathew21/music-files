
<div class="form-group {{ $errors->has('status') ? 'has-error' : '' }}">
    <label for="name" class="col-md-2 control-label">{{ trans('paymenthistory.status') }}</label>
    <div class="col-md-10">
        <select name="status" class="form-control">
                <option value="1" @if($payment->status =='pending') selected @endif>Pending</option>
                <option value="2" @if($payment->status =='paid') selected @endif>Paid</option>
                <option value="3" @if($payment->status =='failed') selected @endif>Failed</option>
        </select>
        {!! $errors->first('status', '<p class="text-danger">:message</p>') !!}
    </div>
</div>