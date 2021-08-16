@extends('adminlte::page')

@section('content_header')
<h1 class="m-0 text-dark">{{ isset($testimonial->user->name) ? 'Testimonial By '.$testimonial->user->name : 'Testimonial' }}</h1>
<div class="btn-group btn-group-sm pull-right" role="group">
    <form method="POST" action="{!! route('testimonials.testimonial.destroy', $testimonial->id) !!}" accept-charset="UTF-8">
        <input name="_method" value="DELETE" type="hidden">
        {{ csrf_field() }}
        <div class="btn-group btn-group-sm" role="group">
            <a href="{{ route('testimonials.testimonial.index') }}" class="btn btn-primary" title="{{ trans('testimonial.show_all') }}">
                <i class="fas fa-list-alt"></i>
            </a>
            
            <a href="{{ route('testimonials.testimonial.edit', $testimonial->id ) }}" class="btn btn-primary"
                title="{{ trans('testimonial.edit') }}">
                <i class="fas fa-edit"></i>
            </a>
            <button type="submit" class="btn btn-danger" title="{{ trans('testimonial.delete') }}"
                onclick="return confirm('{{ trans('testimonial.confirm_delete') }}')">
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
                    <dt>{{ trans('testimonial.title') }}</dt>
                    <dd>{{ $testimonial->title }}</dd>                   
                    <dt>{{ trans('testimonial.submitted_by') }}</dt>
                    <dd>{{ $testimonial->user->name }}</dd>
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
                
            </div>
        </div>
    </div>
</div>

@endsection