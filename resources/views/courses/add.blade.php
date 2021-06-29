@extends('adminlte::page')

@section('content_header')
    <h1 class="m-0 text-dark">Courses</h1>
    <div class="btn-group btn-group-sm pull-right" role="group">

    <a href="{{ route('courses.course.index') }}" class="btn btn-primary" title="{{ trans('users.show_all_course') }}">
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

           
            <form method="POST" action="{{ route('courses.course.store') }}" accept-charset="UTF-8" id="addcourse" name="addcourse" class="form-horizontal">
            {{ csrf_field() }}
            @method("POST")
            <div class="form-group {{ $errors->has('course') ? 'has-error' : '' }}">
                <label for="name" class="col-md-2 control-label">Course</label>
                <div class="col-md-10">
                    <input class="form-control" name="course" type="text" id="course" value=""
                     required="true" placeholder="Enter the Course Name Here">
                        {!! $errors->first('name', '<p class="text-danger">:message</p>') !!}
               </div>
            </div>
            <div class="form-group">                                               <label for="name" class="col-sm-2 control-label">Status</label>
                                                <div class="col-md-10">
                                                    <select class="form-control" name="status">
                                                        <option value="1">Active</option>
                                                        <option value="0">Inactive</option>
                                                    </select>
                                                   
                                                </div>
                                            </div>
          
            <div class="form-group">
                    <div class="col-md-offset-2 col-md-10">
                        <input class="btn btn-primary" type="submit" value="{{ trans('users.add') }}">
                    </div>
                </div>
            </form>
 </div> </div>
        </div>
    </div>

@endsection
