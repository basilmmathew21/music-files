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
              <h3>
                  <span id="class_fee_total">
                  ₹0.00
                  </span>
                </h3>

                <p>Fees Due</p>
              </div>
              <div class="icon">
                <i class="ion ion-person-add">
                <button id="sumInr" type="button" class="btn btn-block btn-primary btn-xs">Click to show in INR</button>
                </i>
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
                  @if(count($paymentHistory) == 0)
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
                  @if(count($tutorClass) == 0)
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
                  @if(count($sms) == 0)
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

@section('js')
<script>
  $(document).ready(function() {
    // set endpoint and your access key
    //endpoint = 'latest'
    var feesDue = '<?php echo json_encode($feesDue); ?>';
    var obj = jQuery.parseJSON(feesDue);
    var totalDues = 0;
    var symbol_string = '';
    ratesConv = [];
    $.each(obj, function(key,due) {
     amount     =  due.class_fee;
     invCode    =  due.code;
     console.log(invCode);
     if (amount > 0) {
       indItem  = {};
       indItem[invCode] = amount;
        ratesConv.push(indItem);
        symbol_string  += due.code + ',';
     }
    });
    symbol_string = symbol_string.slice(0,-1);
    

    $("#sumInr").click(function(){
      access_key = '0d0b39254cefb941a64f7838ba522781';
      totSum     =  0;
      $.ajax({
          url: 'https://data.fixer.io/api/latest?access_key=0d0b39254cefb941a64f7838ba522781&base=INR&symbols='+symbol_string+'&format=1',   
          //url: 'https://data.fixer.io/api/' + endpoint + '?access_key=' + access_key + '&from=' + from + '&to=' + to + '&amount=' + amount,
          dataType: 'jsonp',
          success: function(json) {
            console.log(json.rates);
            
            $.each(json.rates, function(key,conv){
              $.each(ratesConv, function(befKey,befCov){
                console.log(key);
                console.log(befKey);
                 $.each(befCov, function(befInKey,befInCov){
                   console.log(befInCov);
                   if(key == befInKey){
                    totSum =  totSum + ((1/parseFloat(conv))*parseFloat(befInCov));
                  }
                 });
                  
              });
            });
            
            //dues    = json.result.toFixed(2)
            doSummativeDues(totSum);
          }
        });
    });

 
      function doSummativeDues(dues)
      {
        //totalDues  = parseFloat(dues)+parseFloat(totalDues);
        $("#class_fee_total").html(dues.toFixed(2));
      }
  });
</script>
@stop