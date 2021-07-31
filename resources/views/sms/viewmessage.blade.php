@extends('adminlte::page')



@section('content')

<div class="panel panel-default">
<section class="content">
      <div class="row">
                <div class="col-md-9">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Read Message</h3>

            </div>
            <!-- /.box-header -->
            <div class="box-body no-padding">
              <div class="mailbox-read-info">
                
                <h5>From: {{$message->fromname}}
                <?php

                  $s = $message->sent_on;
                  $dt = new DateTime($s);

                  $date = $dt->format('d F.Y h:i a');

                  ?>
                  <span class="mailbox-read-time pull-right">{{$date}}</span></h5>
              </div>
              <!-- /.mailbox-read-info -->
              <div class="mailbox-controls with-border text-center">
               
              
              </div>
              <!-- /.mailbox-controls -->
              <div class="mailbox-read-message">
               
                <p> {{$message->message}}</p>

                
              </div>
              <!-- /.mailbox-read-message -->
            </div>
            <!-- /.box-body -->
      
            <a href="{{ URL::to('/sms/sent')}}" type="button" class="btn btn-primary">Back</a>
          </div>
          <!-- /. box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
</div>

@endsection