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
         <!-- ./col -->
           <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3>{{$students}}</h3>

                <p>Students</p>
              </div>
              <div class="icon">
                <i class="ion ion-pie-graph"></i>
              </div>
              <!--
              <a href="{{ URL::to('students/students')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
              -->      
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
                <h3 class="card-title">Students
				      	</h3>
               <!--  <div class="container text-right">
                  <a href="{{ URL::to('students/students')}}" class="small-box-footer">View All <i class="fas fa-arrow-circle-right"></i></a>
                </div> -->
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0 table-responsive">
                <table class="table table-striped">
                  <thead>
                    <tr>
                      <th style="width: 10px">#</th>
                      <th>Name</th>
                      <!-- <th>Tutor</th> -->
                      <th>Course</th>
                    </tr>
                  </thead>
                  <tbody>
                  @if(empty($studentInfo))
                  <tr class="odd"><td valign="top" colspan="3" class="dataTables_empty">No data available in table</td></tr>
                  @endif
				  <?php foreach($studentInfo as $key => $student){  ?>
                    <tr>
					  <td>{{ $key + 1 }}</td>
                      <td>{{ $student->display_name }}({{ $student->name }})</td>
                     <!--  <td>{{ $student->tutor_name }}</td> -->
                      <td>{{ $student->course }}</td>
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
						Classes
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
                      <th>Name</th>
                      <th>Date</th>
          					 </tr>
                  </thead>
                  <tbody>
                  @if(empty($tutorClass))
                  <tr class="odd"><td valign="top" colspan="3" class="dataTables_empty">No data available in table</td></tr>
                  @endif
				  <?php foreach($tutorClass as $key => $tutor){ ?>
                    <tr>
					  <td>{{ $key + 1 }}</td>
                      <td>{{$tutor->display_name}}({{ $tutor->name }})</td>
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
                <h3 class="card-title">SMS
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
	