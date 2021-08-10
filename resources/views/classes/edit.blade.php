@extends('adminlte::page')

@section('content_header')
    <h1 class="m-0 text-dark">{{ !empty($classes->name) ? 'Class-'.$classes->name : 'User' }}</h1>
    <div class="btn-group btn-group-sm pull-right" role="group">

        <a href="{{ route('tutor.classes.index') }}" class="btn btn-primary" title="{{ trans('classes.show_all') }}">
            <i class="fas fa-list-alt"></i>
        </a>

        <a href="{{ route('tutor.classes.create') }}" class="btn btn-success" title="{{ trans('classes.create') }}">
            <i class="fas fa-plus-circle"></i>
        </a>

    </div>
@stop

@section('content')

    <div class="panel panel-default">
    <div class="card card-primary card-outline">
    <div class="card-body">
        <div class="panel-body">
            @if ($errors->any())
                <ul class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            @endif

            <form method="POST" action="{{ route('tutor.classes.update', $classes->id) }}" id="edit_student_form" name="edit_student_form" accept-charset="UTF-8" class="form-horizontal" enctype="multipart/form-data">
            {{ csrf_field() }}
            <input name="_method" type="hidden" value="PUT">
            @include ('classes.edit_form', [
                                        'user' => $classes,
                                      ])

                <div class="form-group">
                    <div class="col-md-offset-2 col-md-10">
                        <input class="btn btn-primary" type="submit" value="{{ trans('students.update') }}">
                    </div>
                </div>
            </form>
 </div> </div>
        </div>
    </div>

@endsection

@section('js')
<script type="text/javascript">
   $(function () {
    $('.text-editor').summernote({
        height: 100,
        toolbar: [
            [ 'style', [ 'style' ] ],
            [ 'font', [ 'bold', 'italic', 'underline', 'clear'] ],
            [ 'fontname', [ 'fontname' ] ],
            [ 'fontsize', [ 'fontsize' ] ],
            [ 'color', [ 'color' ] ],
            [ 'para', [ 'ol', 'ul', 'paragraph' ] ],
            [ 'insert', [ 'link'] ],
            [ 'view', [ 'undo', 'redo', 'fullscreen', 'codeview', 'help' ] ]
        ]
    });
  })
</script>
@endsection

<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"></script>
<link id="bsdp-css" href="https://unpkg.com/bootstrap-datepicker@1.9.0/dist/css/bootstrap-datepicker3.min.css" rel="stylesheet">
<script src="https://unpkg.com/bootstrap-datepicker@1.9.0/dist/js/bootstrap-datepicker.min.js"></script>
<script type="text/javascript">
                $(function () {
                    $('#dob').datepicker({
                        format: "dd-mm-yy",
                        calendarWeeks: true,
                        autoclose: true,
                        todayHighlight: true, 
                        orientation: "auto"
                    });
                });
				
				
				
				function getStudents() {
		jQuery(function ($) {
			//jQuery('#loader').show();
			var tutor_id = jQuery('#tutor_id').val();
			
			jQuery.ajax({
				beforeSend: function (xhr) { // Add this line
								xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val());
				 },
				url: '{{ URL::to("/ajaxTutorStudents")}}',
				type: "POST",
				//data: '&country_id='+country_id,
				 data: {'tutor_id': tutor_id,"_token": "{{ csrf_token() }}"},

				success: function (res) {
					res=JSON.parse(res);
					//console.log(res);
					var i;
					var showData = [];
					for (i = 0; i < res.length; ++i) {
						var j = i + 1;
						showData[i] = "<option value=''>Select</option><option value='"+res[i].id+"'>"+res[i].name+"</option>";
					}
					
					jQuery("#student_user_id").html(showData);
					//jQuery('#loader').hide();
				},
			});
		});
};
</script>