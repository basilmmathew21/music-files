@extends('adminlte::page')

@section('content_header')
    <h1 class="m-0 text-dark">{{ trans('users.fee_collection') }}</h1>
     
@stop
<style>

body {
    background-color: #ffffff
}

.container {
    width: 600px;
   /* background-color: #fff;*/
    padding-top: 3px;
    padding-bottom: 10px;
    height:510px;
}

.card {
    background-color: #fff;
    width: 500px;
    border-radius: 15px;
	height:auto;
	padding-bottom: 10px;
    box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19)
}
.card h2{ font-weight:600; color:#764830 ;}

.name {
    font-size: 15px;
    color: #403f3f;
    font-weight: bold
}

.cross {
    font-size: 11px;
    color: #b0aeb7
}

.pin {
    font-size: 14px;
    color: #b0aeb7
}

.first {
   border-radius: 8px;
    border: 1.5px solid #eea838;
    color: #000;
    background-color: #eea83829;
}

.second {
    border-radius: 8px;
    border: 1px solid #acacb0;
    color: #000;
    background-color: #fff
}

.dot {}

.head {
    color: #000;
    font-size: 16px;
        font-weight: 600;
}

.dollar {
    font-size: 22px;
    color: #764830
}

.amount {
    color: #764830;
    font-weight: 600;
    font-size: 22px
}

.form-control {
    font-size: 18px;
    font-weight: bold;
    width: 60px;
    height: 28px
}

.back {
    color: #aba4a4;
    font-size: 15px;
    line-height: 73px;
    font-weight: 400
}

.button {
    width: 150px;
    height: 60px;
    border-radius: 8px;
    font-size: 17px
}
</style>
@section('content')

    @if(Session::has('success_message') or Session::has('error_message'))
        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i>
            {!! session('success_message') !!}
            {!! session('error_message') !!}
            <button type="button" class="close" data-dismiss="alert" aria-label="close">
                <span aria-hidden="true">&times;</span>
            </button>

        </div>
    @endif
    @if(Session::has('error_message'))
        <div class="alert alert-danger">
            <i class="fas fa-check-circle"></i>
            {!! session('error_message') !!}
            <button type="button" class="close" data-dismiss="alert" aria-label="close">
                <span aria-hidden="true">&times;</span>
            </button>

        </div>
    @endif

             
<div class="container d-flex justify-content-center mt-3">
    <div class="main-body">

    <div class="card">
        <div>
		<form method="POST" action="{{ route('feepayment.fee.update',$user->id) }}" accept-charset="UTF-8" id="update_fee_form" name="update_fee_form" class="form-horizontal">
            {{ csrf_field() }}
            @method("PUT")
            <div class="d-flex pt-3 pl-3">
                <div><img src="/images/visa-icon.png" width="auto" height="32" /></div>
                <div class="pl-2">      <h2>{{$user->name}} </h2>
                </div>
            </div>

            @if($isSuperAdmin)
            <div class="py-2 px-3">
                <div class="second py-2">
                <div class="form-check">
            </div>
                    <div class="pl-2 pr-2"><span class="head">Student</span>
                        <div class="d-flex">
                            <select name="student_user_id" id="student_user_id" class="form-control">
                                <option value="" >Select</option>
                                @foreach ($students as  $student)
				                    <option value="{{$student->id}}" @if($selectedUser && $selectedUser == $student->id) selected @endif>{{$student->name}}</option>
			                    @endforeach
                            </select>
                        </div>
                    </div>
				 </div>
				<div>
					{!! $errors->first('student_user_id', '<p class="text-danger">:message</p>') !!}
				</div>
            </div>
            @endif
            <div class=" px-3">
                <div class="firstpy-2">
                    <div class="pl-2 pr-2"><span class="head">Total credits</span>
                        <div><span class="dollar">₹</span><span class="amount" id="amount">{{$user->credits}}@if($user->credits == "") 0.00 @endif</span></div>
                    </div>
                </div>
            </div>
            <div class="py-2 px-3">
                <div class="first py-2">
                    <div class="pl-2 pr-2"><span class="head">Total amount due</span>
                        <div><span class="dollar">₹</span><span class="amount" id="payment">0.00</span></div>
                    </div>
                </div>
            </div>
 
            <div class="py-2 px-3">
                  <div class="second py-2">
               
                    <div class="pl-2 pr-2"><span class="head">No of classes</span>
                        <div class="d-flex">
                            <select id="no_of_classes" name="no_of_classes" class="form-control " required="true">
                                <option value="">--Select--</option>
                                <?php for($i=1;$i<=10;$i++) { ?>
                                <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
				 </div>
				<div>
                    <span id="no_class_fee_msg">
                    </span>
					{!! $errors->first('no_of_classes', '<p class="text-danger">:message</p>') !!}
				</div>
            </div>

            <div class="py-2 px-3">
                <div class="second py-2">
                  
                    <div class="pl-2 pr-2"><span class="head">Pay amount</span>
                        <div class="d-flex"><span class="dollar"  style="padding-top:5px;">₹</span>
						    <input type="text" id="class_fee" name="class_fee" class="form-control" required="true" readonly placeholder="0">
						</div>
                    </div>
				</div>
				<div>
					{!! $errors->first('class_fee', '<p class="text-danger">:message</p>') !!}
				</div>
            </div>
            <div class="d-flex justify-content-between px-3  ">
                <div class="col-md-offset-2 col-md-10 p-0">  
                    <input class="btn btn-primary" type="submit" value="{{ trans('users.paynow') }}">
                </div>
            </div>
		</form>
        </div>
        </div>
    </div>
</div>

@endsection
@section('js')
<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<script type="text/javascript">
    var one_class_fee;
   $(document).ready(function() {
            $("#no_of_classes").change(function(){
                if($('#student_user_id').val() != ""){
                    var no_of_classes = parseInt($(this).val());
                    var class_fee     = one_class_fee*no_of_classes;
                    $("#class_fee").val(class_fee);
                }
            });
    });
</script>

<script type="text/javascript">
            $(document).ready(function() {
            var returnAmount;
            $('#student_user_id').change(function(){
                changeStudent();
            });

            $(function () {
                changeStudent();
            });
            function changeStudent() {
                var student_user_id = $('#student_user_id').val();
                if(student_user_id != ''){
                    $.ajax({
                    beforeSend: function (xhr) { // Add this line
                        xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val());
                    },
                    url: '{{ URL::to("/ajaxFeePayment")}}',
                    type: "POST",
                    data: {'student_user_id': student_user_id,"_token": "{{ csrf_token() }}"},
                    success: function (response) {
                        response =   JSON.parse(response);
                        $("#no_class_fee_msg").html('');
                        console.log(response.user.mode_of_remittance);
                        if(response.user.mode_of_remittance == "Indian"){
                            to              =  'INR'
                            from            =  'INR';
                            amount          =   response.user.credits;
                            if(amount < 0){
                                amount  =   amount * -1;
                            }
                            currencyConverter(to,from,amount,'credits');
                            var payment   = response.payment;
                            currencyConverter(to,from,payment,'payment');
                            one_class_fee = response.user.class_fee;
                            currencyConverter(to,from,one_class_fee,'one_class_fee');
                        }else if(response.user.mode_of_remittance == "International"){
                            to              =  'INR'
                            from            =  'INR';
                            amount          =   response.user.credits;
                            if(amount < 0){
                                amount  =   amount * -1;
                            }
                            currencyConverter(to,from,amount,'credits');
                            var payment     =   response.payment;
                            from            =   response.user.code;
                            currencyConverter(to,from,payment,'payment');
                            one_class_fee = response.user.class_fee;
                            currencyConverter(to,from,one_class_fee,'one_class_fee');
                        }
                        $(".dollar").html('₹');
                        $("#class_fee").val(0);
                        $("#no_of_classes").val("");
                        if(response.user.class_fee == 0){
                            $("#no_class_fee_msg").html('<p class="text-danger">The course fee for the student has not updated</p>');
                            $(".content-wrapper").height(935);
                            $(".card").height(630);
                        }
                        else{
                            $(".content-wrapper").height(915);
                        }
                        
                    },
                    });
                }
            }
            
            function currencyConverter(to,from,amount,mode)
            {
                endpoint   = 'convert'
                access_key = '0d0b39254cefb941a64f7838ba522781';
                // get the most recent exchange rates via the "latest" endpoint:
                returnAmount = $.ajax({
                    url: 'https://data.fixer.io/api/' + endpoint + '?access_key=' + access_key + '&from=' + from + '&to=' + to + '&amount=' + amount,
                    dataType: 'jsonp',
                    success: function(json) {
                    dues            = json.result.toFixed(2);
                    //console.log('hi');
                    //console.log(mode);
                    showConvertedAmount(dues,mode);
                    }
                });
            }
            
            function showConvertedAmount(amount,mode)
            {
                if(mode == 'credits'){
                    $("#amount").html(amount);
                }
                if(mode == 'payment'){
                    $("#payment").html(amount);
                }
                if(mode == 'one_class_fee'){
                    one_class_fee   =   amount;
                }
            }
        });
</script>
@stop



        