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
    width: 400px;
    border-radius: 15px;
	height:590px;
	padding-bottom: 10px;
    box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19)
}

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
    border: 1.5px solid #78b9ff;
    color: #000;
    background-color: #eaf4ff
}

.second {
    border-radius: 8px;
    border: 1px solid #acacb0;
    color: #000;
    background-color: #fff
}

.dot {}

.head {
    color: #137ff3;
    font-size: 12px
}

.dollar {
    font-size: 18px;
    color: #097bf7
}

.amount {
    color: #007bff;
    font-weight: bold;
    font-size: 18px
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

             
<div class="container d-flex justify-content-center mt-5">
    <div class="main-body">

    <div class="card">
        <div>
		<form method="POST" action="{{ route('feepayment.fee.update',$user->id) }}" accept-charset="UTF-8" id="update_fee_form" name="update_fee_form" class="form-horizontal">
            {{ csrf_field() }}
            @method("PUT")
            <div class="d-flex pt-3 pl-3">
                <div><img src="https://img.icons8.com/ios-filled/50/000000/visa.png" width="60" height="80" /></div>
                <div class="mt-3 pl-2"><span class="name">{{$user->name}}</span>
                </div>
            </div>

            @if($isSuperAdmin)
            <div class="py-2 px-3">
                <div class="second pl-2 d-flex py-2">
                <div class="form-check"><span style="display:none;" id="one_class_fee">@if($user->class_fee) {{$user->class_fee}} @else 0 @endif</span></div>
                    <div class="border-left pl-2"><span class="head">Student</span>
                        <div class="d-flex">
                            <select name="student_user_id" id="student_user_id" class="form-control">
                                <option value="" >Select</option>
                                @foreach ($students as  $student)
				                    <option value="{{$student->id}}" >{{$student->name}}</option>
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



            <div class="py-2 px-3">
                <div class="first pl-2 d-flex py-2">
                    <div class="form-check"> </div>
                    <div class="border-left pl-2"><span class="head">Total credits</span>
                        <div><span class="dollar">{{$user->symbol}}</span><span class="amount" id="amount">{{ $user->credits}}</span></div>
                    </div>
                </div>
            </div>
            <div class="py-2 px-3">
                <div class="first pl-2 d-flex py-2">
                    <div class="form-check"> </div>
                    <div class="border-left pl-2"><span class="head">Total amount due</span>
                        <div><span class="dollar">{{$user->symbol}}</span><span class="amount" id="payment">{{$payment * $user->class_fee}}</span></div>
                    </div>
                </div>
            </div>
 
            <div class="py-2 px-3">
                <div class="second pl-2 d-flex py-2">
                <div class="form-check"><span style="display:none;" id="one_class_fee">@if($user->class_fee) {{$user->class_fee}} @else 0 @endif</span></div>
                    <div class="border-left pl-2"><span class="head">No of classes</span>
                        <div class="d-flex">
                            <select id="no_of_classes" name="no_of_classes" class="form-control ml-1" required="true">
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
                    @if($user->class_fee == 0) <p class="text-danger">The course fee for the student has not updated</p>  @endif
                    </span>
					{!! $errors->first('no_of_classes', '<p class="text-danger">:message</p>') !!}
				</div>
            </div>

            <div class="py-2 px-3">
                <div class="second pl-2 d-flex py-2">
                    <div class="form-check"></div>
                    <div class="border-left pl-2"><span class="head">Pay amount</span>
                        <div class="d-flex"><span class="dollar"  style="padding-top:5px;">{{$user->symbol}}</span>
						    <input type="text" id="class_fee" name="class_fee" class="form-control ml-1" required="true" readonly placeholder="0">
						</div>
                    </div>
				</div>
				<div>
					{!! $errors->first('class_fee', '<p class="text-danger">:message</p>') !!}
				</div>
            </div>
            <div class="d-flex justify-content-between px-3 pt-4 pb-3">
                <div class="col-md-offset-2 col-md-10">  
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
    $(document).ready(function() {
            $("#no_of_classes").change(function(){
                var one_class_fee = parseInt($("#one_class_fee").text());
                var no_of_classes = parseInt($(this).val());
                var class_fee     = one_class_fee*no_of_classes;
                $("#class_fee").val(class_fee);
            });
    });
</script>

<script type="text/javascript">
            $(document).ready(function() {
            
            $('#student_user_id').change(function(){
                
                var student_user_id = $(this).val();
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
                    
					$("#amount").html(response.user.credits);
                    $(".dollar").html(response.user.symbol);
                    $("#one_class_fee").html(response.user.class_fee);
                    var one_class_fee = response.user.class_fee;
                    var payment       = response.payment;
                    $("#payment").html(payment*one_class_fee);
                    $("#class_fee").val(0);
                    $("#no_of_classes").val('');
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
            });
            
        });
</script>
@stop



        