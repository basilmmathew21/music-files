
<form method="POST" action="{{ route('Sms.sms.deletemessage', $sms->id) }}" accept-charset="UTF-8">
    <input name="_method" value="DELETE" type="hidden">
    {{ csrf_field() }}
    <div class="btn-group btn-group-xs pull-right" role="group">
       
      
    <a href="{{ route('Sms.sms.viewmessage', $sms->id) }} " class="btn btn-info" title=" View Message">
            <i class="fas fa-eye"></i>
        </a>
        <button type="submit" class="btn btn-danger" title="Delete Message"
            onclick="return confirm('Are You Sure ?You want to delete the message')">
            <i class="fas fa-trash-alt"></i>
        </button>
    </div>
</form>

