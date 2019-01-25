<div class="row">
    @foreach($okr['actions'] as $action)
    @if(!$action->isdone)
    <div class="col-md-3">
        <a href="{{ route('user.okr', $action->user->id) }}" title="{{$action->user->name}}">
            <img src="{{ $action->user->getAvatar() }}" class="avatar-xs mr-1">
        </a>
        {{ $action->finished_at }}
        <span class="badge badge-pill badge-{{$action->priority()->getResults()->color}}">{{$action->priority()->getResults()->priority}}</span>
    </div>
    <div class="col-md-6 mb-1" style="border-left: 5px solid {{ $action->keyresult->color()}} ">
        <a href="{{ route('actions.show',$action->id) }}">{{ $action->title }}</a>
    </div>
    <div class="col-md-3 text-right">
        <i class="fa fa-file text-primary fa-lg"></i> {{count($action->getRelatedFiles())}}
        <i class="fa fa-comments text-primary fa-lg ml-4"></i> {{$action->comments->count()}}
    </div>
    @endif
    @endforeach
</div>
