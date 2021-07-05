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


            <form method="POST" action="{{ route('tutors.tutor.store') }}" accept-charset="UTF-8" id="create_user_form" name="create_user_form" class="form-horizontal" enctype='multipart/form-data'>
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

<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"></script>
<link id="bsdp-css" href="https://unpkg.com/bootstrap-datepicker@1.9.0/dist/css/bootstrap-datepicker3.min.css" rel="stylesheet">
<script src="https://unpkg.com/bootstrap-datepicker@1.9.0/dist/js/bootstrap-datepicker.min.js"></script>
<script type="text/javascript">
                $(function () {
                    $('#dob').datepicker({
                        format: "dd-mm-yy",
                        calendarWeeks: true,
                        autoclose: true,
                        todayHighlight: true, 
                        orientation: "auto"
                    });
                });
</script>
