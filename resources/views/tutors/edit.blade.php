@extends('adminlte::page')

@section('content_header')
    <h1 class="m-0 text-dark">{{ !empty($user->name) ? $user->name : 'User' }}</h1>
    <div class="btn-group btn-group-sm pull-right" role="group">

        <a href="{{ route('tutors.tutor.index') }}" class="btn btn-primary" title="{{ trans('users.show_all_tutor') }}">
            <i class="fas fa-list-alt"></i>
        </a>

        <a href="{{ route('tutors.tutor.create') }}" class="btn btn-success" title="{{ trans('users.create_tutor') }}">
            <i class="fas fa-plus-circle"></i>
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

            <form method="POST" action="{{ route('tutors.tutor.update', $user->id) }}" id="edit_tutor_form" name="edit_tutor_form" accept-charset="UTF-8" class="form-horizontal" enctype='multipart/form-data' >
            {{ csrf_field() }}
            <input name="_method" type="hidden" value="PUT">
            @include ('tutors.form', [
                                        'user' => $user,
                                      ])

                <div class="form-group">
                    <div class="col-md-offset-2 col-md-10">
                        <input class="btn btn-primary" type="submit" value="{{ trans('users.update') }}">
                        <a href="{{ URL::to('tutors/')}}" type="button" class="btn btn-default">{{ trans('users.back') }}</a>
                    </div>
                </div>
            </form>
 </div> </div>
        </div>
    </div>

@endsection
