@extends('adminlte::page')

@section('content_header')
<h1 class="m-0 text-dark">{{ isset($tutor->name) ? $tutor->name : 'User' }}</h1>
<div class="btn-group btn-group-sm pull-right" role="group">   
        <div class="btn-group btn-group-sm" role="group">
            <a href="{{ route('tutorenquiries.tutorenquiry.index') }}" class="btn btn-primary" title="{{ trans('users.show_all_enquiry') }}">
                <i class="fas fa-list-alt"></i>
            </a>
           
        </div>
  
</div>
@stop

@section('content')

<div class="panel panel-default">
    <div class="card card-primary card-outline">
        <div class="card-body">
            <div class="panel-body">
                <dl class="dl-horizontal">
                    <dt>{{ trans('users.name') }}</dt>
                    <dd>{{ $tutor->name }}</dd>                   
                    <dt>{{ trans('users.email') }}</dt>
                    <dd>{{ $tutor->email }}</dd>
                    <dt>{{ trans('users.phone') }}</dt>
                    <dd>{{ $tutor->phone }}</dd>
                    <dt>{{ trans('users.gender') }}</dt>
                    <dd>{{ $tutor->gender }}</dd>
                    <dt>{{ trans('users.dob') }}</dt>
                    <dd>{{ $tutor->dob }}</dd>
                    <dt>{{ trans('users.country') }}</dt>
                    <dd>{{ $tutor->country_name }}</dd>
                    <dt>{{ trans('users.state') }}</dt>
                    <dd>{{ $tutor->state }}</dd>
                    <dt>{{ trans('users.address') }}</dt>
                    <dd>{{ $tutor->address }}</dd>
                    <dt>{{ trans('users.teach_stream') }}</dt>
                    <dd>{{ $tutor->teaching_stream }}</dd>
                    <dt>{{ trans('users.edu_quali') }}</dt>
                    <dd>{{ $tutor->educational_qualification }}</dd>
                    <dt>{{ trans('users.teach_exp') }}</dt>
                    <dd>{{ $tutor->teaching_experience }}</dd>
                    <dt>{{ trans('users.perf_exp') }}</dt>
                    <dd>{{ $tutor->performance_experience }}</dd>
                    <dt>{{ trans('users.other_det') }}</dt>
                    <dd>{{ $tutor->other_details }}</dd>
                    <dt>{{ trans('users.status_t') }}</dt>
                    <dd>{{ $tutor->status}}</dd>
                    <dt>{{ trans('users.date_of_enquiry') }}</dt>
                    <dd>{{ $tutor->date_of_enquiry}}</dd>
                    <dt>{{ trans('users.created_at') }}</dt>
                    <dd>{{ $tutor->created_at }}</dd>
                    <dt>{{ trans('users.updated_at') }}</dt>
                    <dd>{{ $tutor->updated_at }}</dd>

                </dl>
                
            </div>
        </div>
    </div>
</div>

@endsection