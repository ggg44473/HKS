<div class="row justify-content-center">
    <div class="col-sm-6">
        <div class="alert alert-info" role="alert">
            邀請您加入 <span class="alert-link">"{{ $invitation->model->name }}"</span> 專案！！
            <a href="{{ route('project.member.invite.agree', [$invitation->model, auth()->user()->id]) }}" class="btn btn-primary">加入</a>
            <a href="{{ route('project.member.invite.reject', [$invitation->model, auth()->user()->id]) }}" class="btn btn-danger">拒絕</a>
        </div>
    </div>
</div>
