<div class="row justify-content-center">
    <div class="col-sm-6">
        <div class="alert alert-info" role="alert">
            請您完成 <span class="alert-link">"{{ $invitation->model->title }}"</span> 任務！！
            <a href="{{ route('actions.member.invite.agree', [$invitation->model, auth()->user()->id]) }}" class="btn btn-primary">加入</a>
            <a href="{{ route('actions.member.invite.reject', [$invitation->model, auth()->user()->id]) }}" class="btn btn-danger">拒絕</a>
        </div>
    </div>
</div>
