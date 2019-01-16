<div class="row">
    @foreach($okr['actions'] as $action)
        @if(!$action->isdone)
        <div class="col-md-2"> 
            {{ $action->finished_at }}
            <span class="badge badge-pill badge-{{$action->priority()->getResults()->color}}">{{$action->priority()->getResults()->priority}}</span>
        </div>
        <div class="col-md-7 mb-1" style="border-left: 5px solid {{ $action->keyresult()->getResults()->color()}} ">
            <a href="{{ route('actions.show',$action->id) }}">{{ $action->title }}</a>                    
        </div>
        <div class="col-md-2 text-right">
            <i class="fa fa-file text-primary fa-lg"></i>  {{count($action->getRelatedFiles())}}
            <i class="fa fa-comments text-primary fa-lg ml-4"></i>  {{$action->comments->count()}}
        </div>
        <div class="col-md-1 btn-group">
            <a class="btn-group pl-2 pr-2 text-success" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-pencil-alt"></i></a>
            <div class="dropdown-menu">
                <a class="dropdown-item text-primary" href="#" onclick="document.getElementById('doneAct{{ $action->id }}').submit()"><i class="fas fa-check-circle"></i> 完成 Action</a>
                <form method="POST" id="doneAct{{ $action->id }}" action="{{ route('actions.done',$action->id) }}">
                    @csrf
                </form>
                <a class="dropdown-item text-primary" href="{{ route('actions.edit',$action->id) }}"><i class="fas fa-pencil-alt"></i> 編輯 Action</a>
                <a class="dropdown-item text-danger" href="#" onclick="document.getElementById('deleteAct{{ $action->id }}').submit()"><i class="fas fa-trash"></i> 刪除 Action</a>
                <form method="POST" id="deleteAct{{ $action->id }}" action="{{ route('actions.destroy',$action->id) }}">
                    @csrf
                    {{ method_field('DELETE') }}
                </form>
            </div>                        
        </div>  
    @endif    
    @endforeach
</div>
