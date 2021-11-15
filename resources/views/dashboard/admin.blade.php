@extends('adminlte::page')
@section('content_header')
<h1 class="m-0 text-dark">{{__('dashboard.title')}}</h1>
@stop

@section('content')
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->

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
                <h3>
                  <span id="class_fee_total">
                  0.00
                  </span>
                </h3>

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
                <div class="container text-right">
                    <a href="{{ URL::to('students/students')}}" class="small-box-footer">View All <i class="fas fa-arrow-circle-right"></i></a>
                </div>
                
              </div>
              
              <!-- /.card-header -->
              <div class="card-body p-0 table-responsive">
                <table class="table table-striped">
                  <thead>
                    <tr>
                      <th style="width: 10px">#</th>
                      <th>Name</th>
                      <th>Tutor</th>
                      <th>Course</th>
                    </tr>
                  </thead>
                  <tbody>
                  @if(count($studentInfo) == 0)
                  <tr class="odd"><td valign="top" colspan="4" class="dataTables_empty">No data available in table</td></tr>
                  @endif   
				  <?php foreach($studentInfo as $key => $student){  ?>
                    <tr>
					  <td>{{ $key + 1 }}</td>
                      <td>{{$student->display_name}}({{ $student->name }})</td>
                      <td>@if($student->user_type_id == 3){{ $student->tutor_name }} @else NA @endif</td>
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
						Tutors Class
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
                      <th style="width: 10px">No</th>
                      <th>Tutor Name</th>
                      <th>Student Name</th>
                      <th>Course</th>
                      <th>Date</th>
          					 </tr>
                  </thead>
                  <tbody>
                  @if(count($tutorClass) == 0)
                  <tr class="odd"><td valign="top" colspan="5" class="dataTables_empty">No data available in table</td></tr>
                  @endif 
				  <?php foreach($tutorClass as $key => $tutor){ ?>
                    <tr>
					  <td>{{ $key + 1 }}</td>
                      <td>{{ $tutor->tutor_displayname }}</td>
                      <td>{{ $tutor->student_displayname }}</td>
                      <td>{{ $tutor->course }}</td>
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
          
          <section class="col-lg-6 connectedSortable">
            <!-- Custom tabs (Charts with tabs)-->
            <div class="card">
             <div class="card-header">
                <h3 class="card-title">SMS</h3>
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
                  @if(count($sms) == 0)
                  <tr class="odd"><td valign="top" colspan="4" class="dataTables_empty">No data available in table</td></tr>
                  @endif 
				  <?php foreach($sms as $key => $sm){  ?>
                    <tr>
					  <td>{{ $key + 1 }}</td>
                      <td>{{$sm->tutor_displayname}}{{$sm->student_displayname}}({{ $sm->name }})</td>
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
          <!-- right col -->
      </div>
		   
	     <!-- /.row (main row) -->
      </div><!-- /.container-fluid -->
    </section>
    

@stop
	

@section('js')
<script>
  $(document).ready(function() {
    // set endpoint and your access key
    //endpoint = 'latest'
    var feesDue = '<?php echo json_encode($feesDue); ?>';
    var obj = jQuery.parseJSON(feesDue);
    var totalDues = 0;
    $.each(obj, function(key,due) {
      endpoint   = 'convert'
      to         = 'INR'
      from       =  due.code;
      amount     =  due.class_fee;
      access_key = '0d0b39254cefb941a64f7838ba522781';
      if (amount > 0) {
        // get the most recent exchange rates via the "latest" endpoint:
        $.ajax({
          //url: 'http://data.fixer.io/api/' + endpoint + '?access_key=' + access_key,   
          url: 'https://data.fixer.io/api/' + endpoint + '?access_key=' + access_key + '&from=' + from + '&to=' + to + '&amount=' + amount,
          dataType: 'jsonp',
          success: function(json) {
            dues    = json.result.toFixed(2)
            doSummativeDues(dues);
          }
        });
      }
    });
    
      function doSummativeDues(dues)
      {
        totalDues  = parseFloat(dues)+parseFloat(totalDues);
        $("#class_fee_total").html(totalDues.toFixed(2));
      }
  });
</script>
@stop