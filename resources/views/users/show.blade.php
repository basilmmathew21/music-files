@extends('adminlte::page')

@section('content_header')
<h1 class="m-0 text-dark">{{ isset($user->name) ? $user->name : 'User' }}</h1>
<div class="btn-group btn-group-sm pull-right" role="group">
    <form method="POST" action="{!! route('users.user.destroy', $user->id) !!}" accept-charset="UTF-8">
        <input name="_method" value="DELETE" type="hidden">
        {{ csrf_field() }}
        <div class="btn-group btn-group-sm" role="group">
            <a href="{{ route('users.user.index') }}" class="btn btn-primary" title="{{ trans('users.show_all') }}">
                <i class="fas fa-list-alt"></i>
            </a>
            <!--
            <a href="{{ route('users.user.edit', $user->id ) }}" class="btn btn-primary"
                title="{{ trans('users.edit') }}">
                <i class="fas fa-edit"></i>
            </a>
            <button type="submit" class="btn btn-danger" title="{{ trans('users.delete') }}"
                onclick="return confirm('{{ trans('users.confirm_delete') }}')">
                <i class="fas fa-trash-alt"></i>
            </button>
            -->
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
                    <dt>{{ trans('users.name') }}</dt>
                    <dd>{{ $user->name }}</dd>                   
                    <dt>{{ trans('users.email') }}</dt>
                    <dd>{{ $user->email }}</dd>
                    <dt>{{ trans('users.phone') }}</dt>
                    <dd>{{ $user->phone }}</dd>
                    <dt>{{ trans('users.user_type') }}</dt>
                    <dd>{{ $user->user_type }}</dd>
                    <dt>{{ trans('users.gender') }}</dt>
                    <dd>{{ $user->gender }}</dd>
                    <dt>{{ trans('users.dob') }}</dt>
                    <dd>{{ $user->dob }}</dd>
                    <dt>{{ trans('users.country') }}</dt>
                    <dd>{{ $user->country_name }}</dd>
                    <dt>{{ trans('users.state') }}</dt>
                    <dd>{{ $user->state }}</dd>
                    <dt>{{ trans('users.address') }}</dt>
                    <dd>{{ $user->address }}</dd>
                    <dt>{{ trans('users.status') }}</dt>
                    <dd>
                    @if($user->is_active == 1)
                        Yes
                    @else
                        No
                    @endif
                    </dd>
                    <dt>{{ trans('users.created_at') }}</dt>
                    <dd>{{ $user->created_at }}</dd>
                    <dt>{{ trans('users.updated_at') }}</dt>
                    <dd>{{ $user->updated_at }}</dd>

                </dl>
                
            </div>
        </div>
    </div>
</div>

@endsection