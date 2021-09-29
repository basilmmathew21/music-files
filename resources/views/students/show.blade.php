@extends('adminlte::page')

@section('content_header')
<h1 class="m-0 text-dark">{{ isset($user->name) ? $user->name : 'User' }}</h1>
<div class="btn-group btn-group-sm pull-right" role="group">
    <form method="POST" action="{!! route('students.student.destroy', $user->id) !!}" accept-charset="UTF-8">
        <input name="_method" value="DELETE" type="hidden">
        {{ csrf_field() }}
        <div class="btn-group btn-group-sm" role="group">
            @if(session()->has('student_user'))
            <a href="{{ route('students.registered.index') }}" class="btn btn-primary" title="{{ trans('students.show_all') }}">
                <i class="fas fa-list-alt"></i>
            </a>
            @else
            <a href="{{ route('students.student.index') }}" class="btn btn-primary" title="{{ trans('students.show_all') }}">
                <i class="fas fa-list-alt"></i>
            </a>
            @endif
            <a href="{{ route('students.student.edit', $user->id ) }}" class="btn btn-primary"
                title="{{ trans('students.edit') }}">
                <i class="fas fa-edit"></i>
            </a>
            <button type="submit" class="btn btn-danger" title="{{ trans('students.delete') }}"
                onclick="return confirm('{{ trans('students.confirm_delete') }}')">
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
                    <dt>{{ trans('students.name') }}</dt>
                    <dd>{{ $user->name }}</dd>                   
                    <dt>{{ trans('students.email') }}</dt>
                    <dd>{{ $user->email }}</dd>
                    <dt>{{ trans('students.phone') }}</dt>
                    <dd>{{ $user->phone }}</dd>
                    <dt>{{ trans('users.whatsappnumber') }}</dt>
                    <dd>{{ $user->whatsapp_number }}</dd>
                    <dt>{{ trans('students.user_type') }}</dt>
                    <dd>{{ $user->user_type }}</dd>
                    <dt>{{ trans('students.gender') }}</dt>
                    <dd>{{ $user->gender }}</dd>
                    <dt>{{ trans('students.course') }}</dt>
                    <dd>{{ $user->course }}</dd>
                    <dt>{{ trans('students.dob') }}</dt>
                    <dd>{{ $user->dob }}</dd>
                    <dt>{{ trans('students.country') }}</dt>
                    <dd>{{ $user->country_name }}</dd>
                    <dt>{{ trans('students.currency') }}</dt>
                    <dd> {{ $user->code }}({{$user->symbol}})</dd>
                    <dt>{{ trans('students.fee') }}</dt>
                    <dd>{{ $user->class_fee }}</dd>
                    <dt>{{ trans('students.credits') }}</dt>
                    <dd>{{ $user->credits }}</dd>
                    <dt>{{ trans('students.onlineclasslink') }}</dt>
                    <dd>{{ $user->online_class_link }}</dd>
                    <dt>{{ trans('students.state') }}</dt>
                    <dd>{{ $user->state }}</dd>
                    <dt>{{ trans('students.address') }}</dt>
                    <dd>{{ $user->address }}</dd>
                    <dt>{{ trans('students.is_registered') }}</dt>
                    <dd>
                    
                    @if($user->is_registered == 'Reg')
                        Registered
                    @else
                        Not Registered
                    @endif
                    </dd>
                    <dt>{{ trans('students.status') }}</dt>
                    <dd>
                    @if($user->is_active == 'Active')
                        Yes
                    @else
                        No
                    @endif
                    </dd>
                    <dt>{{ trans('students.created_at') }}</dt>
                    <dd>{{ $user->created_at }}</dd>
                    <dt>{{ trans('students.updated_at') }}</dt>
                    <dd>{{ $user->updated_at }}</dd>

                </dl>
                
            </div>
        </div>
    </div>
</div>

@endsection