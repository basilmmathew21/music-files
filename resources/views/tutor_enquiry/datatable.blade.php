

    <div class="btn-group btn-group-xs pull-right" role="group">
        <a href=" {{ route('tutorenquiries.tutorenquiry.show', $tutor->id) }} " class="btn btn-info" title=" {{ trans('users.show_enquiry') }}">
            <i class="fas fa-eye"></i>
        </a>
       @if($tutor->status!='accepted') <a href="{{ route('tutorenquiries.tutorenquiry.accept', $tutor->id) }}" class="btn btn-success" title="Accept the enquiry and register as a Tutor" onclick="return confirm('{{ trans('users.accept_enquiry_msg') }}')">
            Accept and Register as a Tutor
        </a>@endif
        @if($tutor->status!='accepted' && $tutor->status!='rejected' )  <a href="{{ route('tutorenquiries.tutorenquiry.reject', $tutor->id) }}" class="btn btn-danger" title="Reject the enquiry" onclick="return confirm('{{ trans('users.reject_enquiry_msg') }}')">
            Reject
        </a>@endif
        
    </div>

