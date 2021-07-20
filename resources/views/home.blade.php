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
                <h3>{{$credits}}</h3>

                <p>Fees Collected</p>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
              <a href="#" class="small-box-footer"><i class="fas"></i></a>
            </div>
          </div>
          
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3>{{$users}}</h3>

                <p>User Registrations</p>
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
              <a href="{{ route('users.user.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>

              
            </div>
          </div>

          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3>{{$tutors}}</h3>

                <p>Tutors</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="{{ route('tutors.tutor.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
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
              <a href="{{ URL::to('students/students')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    
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
				 <a href="{{ route('students.student.index') }}">Student Registrations
				</a>
				</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0">
                <table class="table table-striped">
                  <thead>
                    <tr>
                      <th style="width: 10px">#</th>
                      <th>Name</th>
                      <th>Email</th>
					  <th>Gender</th>
                      <th>Course</th>
                    </tr>
                  </thead>
                  <tbody>
				  <?php foreach($studentInfo as $key => $student){ ?>
                    <tr>
					  <td>{{ $key + 1 }}</td>
                      <td>{{ $student->name }}</td>
                      <td>{{ $student->email }}</td>
                      <td>{{ $student->gender }}</td>
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
						<a href="{{ route('tutors.tutor.index') }}">Tutors Information
						</a>
					</h3>
				</div>
			  
              <!-- /.card-header -->
              <div class="card-body p-0">
                <table class="table table-striped">
                  <thead>
                    <tr>
                      <th style="width: 10px">#</th>
                      <th>Name</th>
                      <th>Email</th>
					  <th>Gender</th>
                     
                    </tr>
                  </thead>
                  <tbody>
				  <?php foreach($tutorInfo as $key => $tutor){ ?>
                    <tr>
					  <td>{{ $key + 1 }}</td>
                      <td>{{ $tutor->name }}</td>
                      <td>{{ $tutor->email }}</td>
                      <td>{{ $tutor->gender }}</td>
                      
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
        <!-- /.row (main row) -->
      </div><!-- /.container-fluid -->
    </section>

@stop
	