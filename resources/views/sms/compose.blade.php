@extends('adminlte::page')

@section('content_header')
    <h1 class="m-0 text-dark">Compose New Message</h1>
    <div class="btn-group btn-group-sm pull-right" role="group">

    </div>
@stop

@section('content')
@if(Session::has('success_message'))
        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i>
            {!! session('success_message') !!}
            <button type="button" class="close" data-dismiss="alert" aria-label="close">
                <span aria-hidden="true">&times;</span>
            </button>

        </div>
    @endif

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

           
            <form method="POST" action="{{ route('Sms.sms.insert') }}" accept-charset="UTF-8" id="addcourse" name="addcourse" class="form-horizontal">
            {{ csrf_field() }}
            @method("POST")
            <div class="form-group">
                <select class="form-control" name="to_user" required >
                    <option>--Select--</option>
                    @foreach($users as $user)
                        <option value='{{$user->id}} '>{{$user->name}}</option>
                    @endforeach
                </select>
              </div>
           
              <div class="form-group" >
               <textarea class="form-control" name="message" required></textarea>
              </div>
          
            <div class="form-group">
                    <div class="col-md-offset-2 col-md-10">
                        <input class="btn btn-primary" type="submit" value="Send">
                        <a href="{{ URL::to('/sms/sent')}}" type="button" class="btn btn-primary">Back</a>
                    </div>
                   
                </div>
            </form>
 </div> </div>
        </div>
    </div>

@endsection
