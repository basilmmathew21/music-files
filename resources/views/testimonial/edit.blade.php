@extends('adminlte::page')

@section('content_header')
    <h1 class="m-0 text-dark">{{ !empty($testimonial->user->name) ? 'Testimonial By '.$testimonial->user->name : 'Testimonial' }}</h1>
    <div class="btn-group btn-group-sm pull-right" role="group">

        <a href="{{ route('testimonials.testimonial.index') }}" class="btn btn-primary" title="{{ trans('testimonial.show_all') }}">
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

            <form method="POST" action="{{ route('testimonials.testimonial.update', $testimonial->id) }}" id="edit_testimonial_form" name="edit_testimonial_form" accept-charset="UTF-8" class="form-horizontal">
            {{ csrf_field() }}
            <input name="_method" type="hidden" value="PUT">
            @include ('testimonial.edit_form', [
                                        'testimonial' => $testimonial,
                                      ])

                <div class="form-group">
                    <div class="col-md-offset-2 col-md-10">
                        <input class="btn btn-primary" type="submit" value="{{ trans('testimonial.update') }}">
                    </div>
                </div>
            </form>
 </div> </div>
        </div>
    </div>

@endsection
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"></script>
