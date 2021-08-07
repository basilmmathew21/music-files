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

 <!-- Students Registration fee -->
  @if(Session::has('success_message') or Session::has('error_message'))
        <div class="row">
            <div class="col-lg-6 col-12">
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i>
                    {!! session('success_message') !!}
                    {!! session('error_message') !!}
                    <button type="button" class="close" data-dismiss="alert" aria-label="close">
                        <span aria-hidden="true">&times;</span>
                    </button>

                </div>
            </div>
        </div>
        @endif
        @if(Session::has('error_message'))
        <div class="row">
            <div class="col-lg-6 col-12">
                <div class="alert alert-danger">
                    <i class="fas fa-check-circle"></i>
                    {!! session('error_message') !!}
                    <button type="button" class="close" data-dismiss="alert" aria-label="close">
                        <span aria-hidden="true">&times;</span>
                    </button>

                </div>
            </div>
        </div>
        @endif
        @unlessrole('super-admin|admin|student|tutor')
        <div class="row">
            <div class="col-lg-6 col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            Pay your registration fee
                        </h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body p-0 table-responsive">
                        <br />
                        <form method="POST" action="{{ route('regfee.paynow') }}" accept-charset="UTF-8" id="paynow" name="paynow" class="form-horizontal">
                            {{ csrf_field() }}
                            @method("POST")
                            <div class="form-group">
                                <div class="col-md-12 text-center">
                                    Fees : 500
                                    <input class="form-control" name="regfee" type="hidden" id="regfee" value="500">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-12 text-center">
                                    <input class="btn btn-primary" type="submit" value="{{ trans('students.paynow') }}">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endunlessrole
<!-- Students Registration fee -->

    <!-- Small boxes (Stat box) -->
    <div class="row">
      @if($isAdmin)
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
      @endif
      @if($isAdmin)
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
      @endif

      @if($isAdmin)
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
      @endif
      <!-- ./col -->
      @if($isTutor || $isAdmin)

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
      @endif

      <!-- ./col -->
    </div>
    <!-- /.row -->
    <!-- Main row -->
    <div class="row">
      <!-- Left col -->
      @if($isTutor || $isAdmin)
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
          <div class="card-body p-0 table-responsive">
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
                <?php foreach ($studentInfo as $key => $student) {  ?>
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
      @endif
      <!-- /.Left col -->
      <!-- right col (We are only adding the ID to make the widgets sortable)-->
      @if($isTutor || $isAdmin)
      <section class="col-lg-6 connectedSortable">

        <div class="card">
          <div class="card-header">
            <h3 class="card-title">
              <a href="{{ route('tutors.tutor.index') }}">Tutors Class
              </a>
            </h3>
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
                <?php foreach ($tutorClass as $key => $tutor) { ?>
                  <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $tutor->name }}</td>
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
      @endif
      <!-- right col -->
    </div>



    <div class="row">
      <!-- Left col -->
      @if($isTutor || $isAdmin)
      <section class="col-lg-6 connectedSortable">
        <!-- Custom tabs (Charts with tabs)-->
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">
              <a href="{{ route('students.student.index') }}">SMS
              </a>
            </h3>
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
                <?php foreach ($sms as $key => $sm) {  ?>
                  <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $sm->name }}</td>
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
      @endif
      <!-- /.Left col -->

    </div>


    <!-- /.row (main row) -->
  </div><!-- /.container-fluid -->
</section>

@stop