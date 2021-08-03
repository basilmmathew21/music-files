@extends('adminlte::page')

@section('content_header')
    <h1 class="m-0 text-dark">Tutor Enquiry</h1>
    <!-- <div class="btn-group btn-group-sm pull-right" role="group">
        <a href="{{ route('testimonials.testimonial.index') }}" class="btn btn-primary" title="{{ trans('testimonial.show_all') }}">
            <i class="fas fa-list-alt"></i>
        </a>
    </div> -->
@stop

@section('content')

    <div class="panel panel-default">

<div class="card card-primary card-outline">
    <div class="card-body">

        <div class="panel-body">

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
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


            <form method="POST" action="{{ route('tutorenquiries.tutorenquiry.store') }}" accept-charset="UTF-8" id="create_user_form" name="create_user_form" class="form-horizontal">
            {{ csrf_field() }}
            @include ('tutor_enquiry.form', [
                                        'tutorenquiry' => null,
                                        'files' => true
                                      ])

                <div class="form-group">
                    <div class="col-md-offset-2 col-md-10">
                        <input class="btn btn-primary" type="submit" value="{{ trans('testimonial.add') }}">
                    </div>
                </div>

            </form>

        </div>
    </div>
    </div>
    </div>

@endsection

<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script type="text/javascript">
 $('#customFile').change(function(){
    let reader = new FileReader();
    reader.onload = (e) => { 
    $('#preview-image').attr('src', e.target.result); 
    }
    reader.readAsDataURL(this.files[0]); 
   });
</script>
<link id="bsdp-css" href="https://unpkg.com/bootstrap-datepicker@1.9.0/dist/css/bootstrap-datepicker3.min.css" rel="stylesheet">
<script src="https://unpkg.com/bootstrap-datepicker@1.9.0/dist/js/bootstrap-datepicker.min.js"></script>
<script type="text/javascript">
    $(function () {
        $('#dob').datepicker({
            format: "dd-mm-yyyy",
            autoclose: true,
            todayHighlight: true,
            endDate: "today",
        });
    });
</script>
