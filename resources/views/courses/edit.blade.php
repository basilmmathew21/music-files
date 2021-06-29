@extends('adminlte::page')

@section('content_header')
    <h1 class="m-0 text-dark">Courses</h1>
    <div class="btn-group btn-group-sm pull-right" role="group">

    <a href="{{ route('courses.course.index') }}" class="btn btn-primary" title="Show All Courses">
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

           
            <form method="POST" action="{{ route('courses.course.update',$course->id) }}" accept-charset="UTF-8" id="editcourse" name="editcourse" class="form-horizontal">
            {{ csrf_field() }}
            {!! Form::hidden('id',  $course->id , array('class'=>'form-control', 'id'=>'id')) !!}
            @method("PUT")
            <div class="form-group {{ $errors->has('course') ? 'has-error' : '' }}">
                <label for="name" class="col-md-2 control-label">Course</label>
                <div class="col-md-10">
                    <input class="form-control" name="course" type="text" id="course" value="{{ $course->course }}"
                     required="true" placeholder="Enter the Course Name Here">
                        {!! $errors->first('name', '<p class="text-danger">:message</p>') !!}
               </div>
            </div>
            <div class="form-group">
                                                <label for="name" class="col-sm-2 control-label">Status</label>
                                                <div class="col-md-10">
                                                    <select class="form-control" name="status">
                                                        <option value="1"  @if($course->is_active=='1') selected @endif>Active</option>
                                                        <option value="0" @if($course->is_active=='0') selected @endif>InActive</option>
                                                    </select>
                                                   

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
