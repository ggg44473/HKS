
<div class="row">
    @foreach($okr['actions'] as $action)
        @if(!$action->isdone)
        <div class="col-md-2"> 
            {{ $action->finished_at }}
            <span class="badge badge-pill badge-{{$action->priority()->getResults()->color}}">{{$action->priority()->getResults()->priority}}</span>
        </div>
        <div class="col-md-6 mb-1 pt-1" style="border-left: 5px solid {{ $colors[($action->related_kr)%9] }} ">
            <a href="{{ route('actions.show',$action->id) }}">{{ $action->title }}</a>                    
        </div>
        <div class="col-md-2">
                <i class="fas fa-file"></i>
        </div>
        <div class="col-md-1"><i class="far fa-comment-alt"></i></div>
        <div class="col-md-1 btn-group">
            <button type="button" class="btn btn-light btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-pencil-alt"></i>
            </button>
            <div class="dropdown-menu">
                <a class="dropdown-item" href="#" onclick="document.getElementById('doneAct{{ $action->id }}').submit()"><i class="fas fa-check-circle"></i> 完成 Action</a>
                <form method="POST" id="doneAct{{ $action->id }}" action="{{ route('actions.done',$action->id) }}">
                    @csrf
                </form>
                <a class="dropdown-item" href="{{ route('actions.edit',$action->id) }}"><i class="fas fa-pencil-alt"></i> 編輯 Action</a>
                <a class="dropdown-item" href="#" onclick="document.getElementById('deleteAct{{ $action->id }}').submit()"><i class="fas fa-trash"></i> 刪除 Action</a>
                <form method="POST" id="deleteAct{{ $action->id }}" action="{{ route('actions.destroy',$action->id) }}">
                    @csrf
                    {{ method_field('DELETE') }}
                </form>
            </div>                        
        </div>  
    @endif    
    @endforeach
</div>
