@extends('adminlte::page')

@section('content_header')
    <h1 class="m-0 text-dark">Registered Students</h1>
     
@stop

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
    <div class="panel panel-default">
<div class="card card-primary card-outline">
    <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <form method="POST" id="search-form" class="form-inline" role="form">
                        <div class="form-group ">
                            <label class="mb-2 mr-sm-2">{{ trans('students.filters') }} : </label>
                        </div>                        
                        <div class="form-group">
                            <label for="keyword" class="mb-2 mr-sm-2">{{__('students.keyword_filter')}}</label>
                            <input type="textbox" class="form-control mb-2 mr-sm-2" name="keyword" id="keyword"
                                value="">
                        </div>
                        <button type="submit" class="btn btn-primary mb-2 mr-sm-2">{{ trans('students.search') }}</button>
                    </form>
                </div>
            </div>
        <div class="panel-body panel-body-with-table">
            <div class="table-responsive">

                <table id="dataList" class="display table table-striped">
                    <thead>
                        <tr>
                            <th>{{ trans('students.slno') }}</th>
                            <th>{{ trans('students.name') }}</th>
                            <th>{{ trans('students.email') }}</th>                           
                            <th>{{ trans('students.phone') }}</th>
                            <th>{{ trans('students.country') }}</th>
                            <th>{{ trans('students.course') }}</th>
                            <th>{{ trans('students.credits') }}</th>
                            <th>{{ trans('students.registered') }}</th>
                            <th>{{ trans('students.status') }}</th>
                            <th></th>
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
                    url: "{{ route('students.registered.index') }}",
                    data: function (d) {
                        d.keyword = $('#keyword').val();
                    }
                },
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'name', name: 'name'},
                    {data: 'email', name: 'email'},                    
                    {data:  'phone', name: "phone"},
                    {data:  'country_name', name: "country_name"},
                    {data:  'course', name: "course"},
                    {data:  'credits', name: "credits"},
                    {data:  'is_registered', name: "is_registered"},
                    {data:  'is_active', name: "is_active"},
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
