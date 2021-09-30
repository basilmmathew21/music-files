@extends('adminlte::page')

@section('content_header')
<h1 class="m-0 text-dark">{{ isset($user->name) ? $user->name : 'User' }}</h1>
<div class="btn-group btn-group-sm pull-right" role="group">
    <form method="POST" action="{!! route('users.user.destroy', $user->id) !!}" accept-charset="UTF-8">
        <input name="_method" value="DELETE" type="hidden">
        {{ csrf_field() }}
        <div class="btn-group btn-group-sm" role="group">
            <a href="{{ route('tutors.tutor.index') }}" class="btn btn-primary" title="{{ trans('users.show_all_tutor') }}">
                <i class="fas fa-list-alt"></i>
            </a>
           
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
                    <dt>{{ trans('users.whatsappnumber') }}</dt>
                    <dd>{{ $user->whatsapp_number }}</dd>
                    <dt>{{ trans('users.gender') }}</dt>
                    <dd>{{ $user->gender }}</dd>
                    <dt>{{ trans('users.dob') }}</dt>
                    <dd>{{ $user->dob }}</dd>
                    @if(count($students) > 0)
                    <dt>Students</dt>
                    <dd>  
                    <div class="row">
                        <div class="col-4">
                        <div class="list-group" id="list-tab" role="tablist">
                            <ul class="list-group">
                                @foreach ($students as $student)
                                    <li class="list-group-item">{{$student->display_name}} ({{$student->name}}) </li>
                                @endforeach
                            </ul>
                        </div>
                        </div>
                    </div>
                    </dd>
                    @endif
                    <dt>{{trans('users.profile_image')}}</dt>
                    <dd>
                    <?php
                         if($user->profile_image)
                            {
                             $image="storage/images/profile/".$user->profile_image;
                            }
                        else
                            $image="";
                    ?>

                      @if(!$image)
                             <img width=200 height=200 id = "preview"  alt = "Preview image" src="https://www.riobeauty.co.uk/images/product_image_not_found.gif" />
                          @else
                                <img width=200 height=200 id = "preview"  alt = "Preview image" src="{{asset($image)}}" />
                           @endif
                    </dd>
                    <dt>{{ trans('users.country') }}</dt>
                    <dd>{{ $user->country_name }}</dd>
                    <dt>{{ trans('users.state') }}</dt>
                    <dd>{{ $user->state }}</dd>
                    <dt>{{ trans('users.address') }}</dt>
                    <dd>{{ $user->address }}</dd>
                    <dt>{{ trans('users.teach_stream') }}</dt>
                    <dd>{{ $user->teaching_stream }}</dd>
                    <dt>{{ trans('users.edu_quali') }}</dt>
                    <dd>{{ $user->educational_qualification }}</dd>
                    <dt>{{ trans('users.teach_exp') }}</dt>
                    <dd>{{ $user->teaching_experience }}</dd>
                    <dt>{{ trans('users.perf_exp') }}</dt>
                    <dd>{{ $user->performance_experience }}</dd>
                    <dt>{{ trans('users.other_det') }}</dt>
                    <dd>{{ $user->other_details }}</dd>
                    <dt>{{ trans('users.status_t') }}</dt>
                    <dd>
                    @if($user->is_active==1)
                        Active
                    @else
                        Inactive
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
    @if($user->is_active==0) <a href="{{ route('tutors.tutor.sendcredentials', $user->id) }}" class="btn btn-success" title=""  onclick="return confirm('{{ trans('users.login_credentials_msg') }}')">Accept and Send Login Credentials
        </a>
       @endif
       <a href="{{ URL::to('tutors/')}}" type="button" class="btn btn-default">{{ trans('users.back') }}</a>
</div>

@endsection