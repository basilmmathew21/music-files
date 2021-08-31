@extends('adminlte::page')
@section('content_header')
<h1 class="m-0 text-dark">{{__('dashboard.title')}}</h1>
@stop

@section('content')
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3>{{$classes}}</h3>
                  <p>Total Classes Completed</p>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
              
            </div>
          </div>
          
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3>{{$feesDue}}</h3>

                <p>Fees Due</p>
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
             
              
            </div>
          </div>
         
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3>{{$credits}}</h3>

                <p>Credits</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              
            </div>
          </div>
          <!-- ./col -->
        </div>
        <!-- /.row -->
        <!-- Main row -->
        <div class="row">
          <!-- Left col -->
          
          <section class="col-lg-6 connectedSortable">
            <!-- Custom tabs (Charts with tabs)-->
            <div class="card">
             <div class="card-header">
                <h3 class="card-title">
				           Payment History
				        </h3>
                <div class="container text-right">
                  <a href="{{ URL::to('payments/index')}}" class="small-box-footer">View All <i class="fas fa-arrow-circle-right"></i></a>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0 table-responsive">
                <table class="table table-striped">
                  <thead>
                    <tr>
                      <th style="width: 10px">#</th>
                      <th>Date</th>
                      <th>Amount</th>
					            <th>Classes</th>
                      <th>Status</th>
                    </tr>
                  </thead>
                  <tbody>
                  @if(empty($paymentHistory))
                  <tr class="odd"><td valign="top" colspan="5" class="dataTables_empty">No data available in table</td></tr>
                  @endif
				  <?php foreach($paymentHistory as $key => $history){  ?>
                    <tr>
					  <td>{{ $key + 1 }}</td>
                      <td>{{ $history->payment_date }}</td>
                      <td>{{ $history->amount }}</td>
                      <td>{{ $history->no_of_classes }}</td>
                      <td>{{ $history->status }}</td>
                    </tr>
				  <?php } ?> 
                  </tbody>
                </table>
              </div>
            </div>
            <!-- /.card -->

            <!-- DIRECT CHAT -->
            

            <!-- TO DO List -->

            <!-- /.card -->
          </section>
            
          <!-- /.Left col -->
          <!-- right col (We are only adding the ID to make the widgets sortable)-->
          
          <section class="col-lg-6 connectedSortable">

            <div class="card">
				<div class="card-header">
					<h3 class="card-title">
						Student Class
					</h3>
          <div class="container text-right">
                  <a href="{{ URL::to('tutor/classes')}}" class="small-box-footer">View All <i class="fas fa-arrow-circle-right"></i></a>
        </div>
				</div>
			  
              <!-- /.card-header -->
              <div class="card-body p-0 table-responsive">
                <table class="table table-striped">
                  <thead>
                    <tr>
                      <th style="width: 10px">#</th>                      
                      <th>Date</th>
          					 </tr>
                  </thead>
                  <tbody>
                  @if(empty($tutorClass))
                  <tr class="odd"><td valign="top" colspan="2" class="dataTables_empty">No data available in table</td></tr>
                  @endif          
				  <?php foreach($tutorClass as $key => $tutor){ ?>
                    <tr>
					  <td>{{ $key + 1 }}</td>                      
                      <td>{{ $tutor->date }}</td>
                    </tr>
				  <?php } ?> 
                  </tbody>
                </table>
              </div>
            </div>
            <!-- solid sales graph -->
            <!-- Calendar -->
            <!-- /.card -->
          </section>
          <!-- right col -->
      </div>
		   <div class="row">
          <!-- Left col -->
          
          <section class="col-lg-6 connectedSortable">
            <!-- Custom tabs (Charts with tabs)-->
            <div class="card">
             <div class="card-header">
                <h3 class="card-title">
				          SMS
                </h3>
        <div class="container text-right">
                  <a href="{{ URL::to('sms/inbox')}}" class="small-box-footer">View All <i class="fas fa-arrow-circle-right"></i></a>
        </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0 table-responsive">
                <table class="table table-striped">
                  <thead>
                    <tr>
                      <th style="width: 10px">#</th>
                      <th>Name</th>
                      <th>Message</th>
					            <th>Sent On</th>
                    </tr>
                  </thead>

                  <tbody>
                  @if(empty($sms))
                  <tr class="odd"><td valign="top" colspan="4" class="dataTables_empty">No data available in table</td></tr>
                  @endif 
				  <?php foreach($sms as $key => $sm){  ?>
                    <tr>
					  <td>{{ $key + 1 }}</td>
                      <td>@if($sm->display_name){{ $sm->display_name }}({{ $sm->name }}) @else {{ $sm->name }} @endif</td>
                      <td>{{ $sm->message }}</td>
                      <td>{{ $sm->sent_on }}</td>
                    </tr>
				  <?php } ?> 
                  </tbody>
                </table>
              </div>
            </div>
            <!-- /.card -->
            <!-- DIRECT CHAT -->
            <!-- TO DO List -->
            <!-- /.card -->
          </section>
          <!-- /.Left col -->
        </div>
	     <!-- /.row (main row) -->
      </div><!-- /.container-fluid -->
    </section>

@stop
	