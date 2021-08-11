@extends('adminlte::page')

@section('content_header')
<h1 class="m-0 text-dark">Testimonial</h1>
@if($testimonial)
<div class="btn-group btn-group-sm pull-right" role="group">
    <form method="POST" action="{!! route('student.testimonial.destroy', $testimonial->id) !!}" accept-charset="UTF-8">
        <input name="_method" value="DELETE" type="hidden">
        {{ csrf_field() }}
        <div class="btn-group btn-group-sm" role="group">
            <button type="submit" class="btn btn-danger" title="{{ trans('testimonial.delete') }}" onclick="return confirm('{{ trans('testimonial.confirm_delete') }}')">
                <i class="fas fa-trash-alt"></i>
            </button>

        </div>
    </form>
</div>
@endif
@stop

@section('content')

<div class="panel panel-default">
    <div class="card card-primary card-outline">
        <div class="card-body">
            <div class="panel-body">

                @if($testimonial)
                <dl class="dl-horizontal">
                    <dt>{{ trans('testimonial.title') }}</dt>
                    <dd>{{ $testimonial->title }}</dd>
                    <dt>{{ trans('testimonial.description') }}</dt>
                    <dd>{{ $testimonial->description }}</dd>
                    <dt>{{ trans('testimonial.status') }}</dt>
                    <dd>{{ ucfirst($testimonial->status) }}</dd>
                    <dt>{{ trans('testimonial.is_active') }}</dt>
                    @if($testimonial->is_active == 0)
                    <dd>Inactive</dd>
                    @else
                    <dd>Active</dd>
                    @endif
                    <dt>{{ trans('testimonial.created_at') }}</dt>
                    <dd>{{ $testimonial->created_at }}</dd>
                    <dt>{{ trans('testimonial.updated_at') }}</dt>
                    <dd>{{ $testimonial->updated_at }}</dd>

                </dl>
                @else
                <p> You have not added the testimonial. Please add.</p>
                <div class="form-group">
                    <div class="col-md-offset-2 col-md-10">
                        <a href="{!! route('student.testimonial.create') !!}"><input class="btn btn-primary" type="button" value="{{ trans('testimonial.add') }}"></a>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection