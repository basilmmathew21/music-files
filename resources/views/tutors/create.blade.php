@extends('adminlte::page')

@section('content_header')
    <h1 class="m-0 text-dark">{{ trans('users.create_tutor') }}</h1>
    <div class="btn-group btn-group-sm pull-right" role="group">
        <a href="{{ route('tutors.tutor.index') }}" class="btn btn-primary" title="{{ trans('users.show_all_tutor') }}">
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
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif


            <form method="POST" action="{{ route('tutors.tutor.store') }}" accept-charset="UTF-8" id="create_user_form" name="create_user_form" class="form-horizontal" enctype='multipart/form-data' onsubmit="return isValidDate();">
            {{ csrf_field() }}
            @include ('tutors.form', [
                                        'user' => null,
                                      ])

                <div class="form-group">
                    <div class="col-md-offset-2 col-md-10">
                        <input class="btn btn-primary" type="submit" value="{{ trans('users.add') }}">
                        <a href="{{ URL::to('tutors/')}}" type="button" class="btn btn-default">{{ trans('users.back') }}</a>
                    </div>
                </div>

            </form>

        </div>
    </div>
    </div>
    </div>

@endsection


