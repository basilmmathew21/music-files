@extends('adminlte::page')

@section('content_header')
    <h1 class="m-0 text-dark">Inbox</h1>
     <div class="btn-group btn-group-sm pull-right" role="group">
    
    </div>
@stop

@section('content')

    @if(Session::has('success_message') )
        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i>
            {!! session('success_message') !!}
            
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

    <div class="panel panel-default">
<div class="card card-primary card-outline">
    <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <form method="POST" id="search-form" class="form-inline" role="form">
                        <div class="form-group ">
                            <label class="mb-2 mr-sm-2">{{ trans('users.filters') }} : </label>
                        </div>                        
                        <div class="form-group">
                            <label for="keyword" class="mb-2 mr-sm-2">Sender/Recepient Search</label>
                            <input type="textbox" class="form-control mb-2 mr-sm-2" name="keyword" id="keyword"
                                value="">
                        </div>
                        <button type="submit" class="btn btn-primary mb-2 mr-sm-2">{{ trans('users.search') }}</button>
                    </form>
                </div>
            </div>
        <div class="panel-body panel-body-with-table">
            <div class="table-responsive">

                <table id="dataList" class="display table table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Sender</th>
                            <th>Recepient</th>
                            <th>Message</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                </table>

            </div>
        </div>

</div>
        </div>
    </div>
@endsection
@section('plugins.Datatables', true)
@section('js')
<script>
    $(document).ready(function() {
            var table = $('#dataList').DataTable({
                dom: "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'>>" +
                        "<'row'<'col-sm-12'tr>>" +
                        "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('Sms.sms.tutorinbox') }}",
                    data: function (d) {
                        d.keyword = $('#keyword').val();
                    }
                },
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},                 
                    {data: 'fromname', name: 'fromname'},
                    {data: 'toname', name: 'toname'},     
                    {data: 'message', name: 'message'},
                    {data: 'sent_on', name: 'sent_on'},                    
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ]
            });
        $('#search-form').on('submit', function(e) {
            table.draw();
            e.preventDefault();
        });
    } );
</script>
@stop
