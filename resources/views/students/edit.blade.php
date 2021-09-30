@extends('adminlte::page')

@section('content_header')
    <h1 class="m-0 text-dark">{{ !empty($user->name) ? $user->name : 'User' }}</h1>
    <div class="btn-group btn-group-sm pull-right" role="group">
        @if(session()->has('student_user'))
        <a href="{{ route('students.registered.index') }}" class="btn btn-primary" title="{{ trans('students.show_all') }}">
            <i class="fas fa-list-alt"></i>
        </a>
        @else
        <a href="{{ route('students.student.index') }}" class="btn btn-primary" title="{{ trans('students.show_all') }}">
            <i class="fas fa-list-alt"></i>
        </a>
        @endif
        @if(!session()->has('student_user'))
        <a href="{{ route('students.student.create') }}" class="btn btn-success" title="{{ trans('students.create') }}">
            <i class="fas fa-plus-circle"></i>
        </a>
        @endif
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

            <form method="POST" action="{{ route('students.student.update', $user->id) }}" id="edit_student_form" name="edit_student_form" accept-charset="UTF-8" class="form-horizontal">
            {{ csrf_field() }}
            <input name="_method" type="hidden" value="PUT">
            @include ('students.edit_form', [
                                        'user' => $user,
                                      ])

                <div class="form-group">
                    <div class="col-md-offset-2 col-md-10">
                        <input class="btn btn-primary" type="submit" value="{{ trans('students.update') }}">
                        @if(session()->has('student_user'))
                        <a href="{{ URL::to('students/registered')}}" type="button" class="btn btn-default">{{ trans('students.back') }}</a>
                        @else
                        <a href="{{ URL::to('students/students')}}" type="button" class="btn btn-default">{{ trans('students.back') }}</a>
                        @endif
                    </div>
                </div>
            </form>
 </div> </div>
        </div>
    </div>

@endsection
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"></script>
<link id="bsdp-css" href="https://unpkg.com/bootstrap-datepicker@1.9.0/dist/css/bootstrap-datepicker3.min.css" rel="stylesheet">
<script src="https://unpkg.com/bootstrap-datepicker@1.9.0/dist/js/bootstrap-datepicker.min.js"></script>
<script type="text/javascript">
                $(function () {
                    $('#dob').datepicker({
                        format: "dd-mm-yyyy",
                        autoclose: true,
                        todayHighlight: true, 
                    });
                });
                $( document ).ready(function() {
                    $(".sidebar").height(1295);  
                });
</script>