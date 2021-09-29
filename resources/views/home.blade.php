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
                  <?php
                  // set API Endpoint and API key 
                  
$endpoint = 'latest';
$access_key = '0d0b39254cefb941a64f7838ba522781';

// Initialize CURL:
$ch = curl_init('http://data.fixer.io/api/'.$endpoint.'?access_key='.$access_key.'');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// Store the data:
$json = curl_exec($ch);
curl_close($ch);

// Decode JSON response:
$exchangeRates = json_decode($json, true);

// Access the exchange rate values
$Inr_Euro=$exchangeRates['rates']['INR'];
$fees=500;
$fee_euro=round(($fees/$Inr_Euro),2);
$student_currency_rate=round(($exchangeRates['rates'][$student_currency]),2);
$student_pay_amount=$fee_euro*$student_currency_rate;
echo "Fees : ".round($student_pay_amount,2);


                  ?>
                
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

    <!-- /.row (main row) -->
  </div><!-- /.container-fluid -->
</section>

@stop