
<div class="container">
    <div class="row mb-2">
        <div class="col-md-6 mb-2">
                <span class="badge badge-pill badge-{{$action->priority()->getResults()->color}}">{{$action->priority()->getResults()->priority}}</span><br/>
            <span class="badge badge-pill badge-secondary">關聯KR : {{$action->keyresult()->getResults()->title}}</span>
        </div>
        <div class="col align-self-end mb-3 text-right">
                <small>Updated : {{$action->updated_at}}</small><br/>
                | <small>執行者:{{$action->user()->getResults()->name}}</small> | 
                <small>指派者:{{$action->assignee()->getResults()->name}}</small> | 
                <small>Started : {{$action->started_at}}</small> | 
                <small>Finished : {{$action->finished_at}}</small> |
        </div>
        <div class="col-md-12 text-center alert alert-success">
            <h4>{{$action->title}}</h4>
        </div>
        <div class="col-md-12 align-self-end mb-2 text-right">
        </div>
        <div class="col-md-1 ml-4">
            文章
        </div>
        <div class="col-md-10 bg-light mr-4">
            <pre>{{$action->content}} </pre>
        </div>
        <div class="col-md-12 ml-4 ">
            附件
            @if(!empty($files))
                @foreach($files as $file)
                    <a href="{{ route('download',['file'=>$file,'action_id'=>$action->id]) }}" >
                    {{$file}}
                    </a>
                    <a href="{{ route('actions.destroyFile',['id'=>$action->id,'file_path'=>$file])}}">[X]</a>
                @endforeach
            @endif
        </div>
    </div>
    @comments(['model' => $action])
    @endcomments
</div>
