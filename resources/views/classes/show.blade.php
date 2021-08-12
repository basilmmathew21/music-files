@extends('adminlte::page')

@section('content_header')
<h1 class="m-0 text-dark">{{ isset($classes->name) ? $classes->name : 'User' }}</h1>
<div class="btn-group btn-group-sm pull-right" role="group">
    <form method="POST" action="{!! route('tutor.classes.destroy', $classes->id) !!}" accept-charset="UTF-8">
        <input name="_method" value="DELETE" type="hidden">
        {{ csrf_field() }}
        <div class="btn-group btn-group-sm" role="group">
            <a href="{{ route('tutor.classes.index') }}" class="btn btn-primary" title="{{ trans('classes.show_all') }}">
                <i class="fas fa-list-alt"></i>
            </a>

            <a href="{{ route('tutor.classes.edit', $classes->id ) }}" class="btn btn-primary" title="{{ trans('classes.edit') }}">
                <i class="fas fa-edit"></i>
            </a>
            <button type="submit" class="btn btn-danger" title="{{ trans('classes.delete') }}" onclick="return confirm('{{ trans('classes.confirm_delete') }}')">
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
                    <dt>{{ trans('classes.student') }}</dt>
                    <dd>{{ $classes->name }}</dd>

                    <dt>{{ trans('classes.date') }}</dt>
                    <dd>{{ $classes->date }}</dd>


                    <dt>{{ trans('classes.summary') }}</dt>
                    <dd><strong>{!! $classes->summary !!}</strong></dd>

                    <dt>{{ trans('classes.files') }}</dt>
                    @foreach ($files as $file)
                    <dd><a href="{{asset('uploads/files_'.$classes->id.'/'.$file)}}" download>{{ $file }}</a></dd>
                    @endforeach

                </dl>

            </div>
        </div>
    </div>
</div>

@endsection