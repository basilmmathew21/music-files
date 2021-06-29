@extends('adminlte::page')

@section('content_header')
    <h1 class="m-0 text-dark">{{ trans('users.settings') }}</h1>
    <div class="btn-group btn-group-sm pull-right" role="group">

    <a href="{{ route('settings.settings.index') }}" class="btn btn-primary" title="Show All Settings">
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

           
            <form method="POST" action="{{ route('settings.settings.update',$settings['id']) }}" accept-charset="UTF-8" id="update_skill_form" name="update_skill_form" class="form-horizontal">
            {{ csrf_field() }}
            @method("PUT")
            <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                <label for="name" class="col-md-2 control-label">Name</label>
                <div class="col-md-10">
                    <input class="form-control" name="name" type="text" id="name" value="{{$settings->name}}"
                     required="true" placeholder="{{ trans('users.name__placeholder') }}">
                        {!! $errors->first('name', '<p class="text-danger">:message</p>') !!}
               </div>
            </div>

            <div class="form-group {{ $errors->has('value') ? 'has-error' : '' }}">
                <label for="name" class="col-md-2 control-label">Value</label>
                <div class="col-md-10">
                    <input class="form-control" name="value" type="text" id="value" value="{{$settings->value}}"
                     required="true" placeholder="{{ trans('users.value__placeholder') }}">
                        {!! $errors->first('value', '<p class="text-danger">:message</p>') !!}
               </div>
            </div>
            <div class="form-group">
                    <div class="col-md-offset-2 col-md-10">
                        <input class="btn btn-primary" type="submit" value="{{ trans('users.update') }}">
                    </div>
                </div>
            </form>
 </div> </div>
        </div>
    </div>

@endsection
