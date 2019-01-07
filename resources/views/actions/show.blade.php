
<div class="container">
    {{-- <div class="modal-body" > --}}
        <div class="row mb-5">
            <div class="col-10">
                <h4>{{$action->title}}</h4>
            </div>
            <div class="col-md-2">
                {{$action->related_kr}}
            </div>
            <div class="col-md-6">
                修改時間:{{$action->updated_at}}
            </div>
            <div class="col-md-3">
                指派人:{{$action->user_id}}
            </div>
            <div class="col-md-3">
                負責人:{{$action->assignee}}
            </div>
            <div class="col-md-6">
                文章:
            </div>
            <div class="col-md-6 bg-primary">
                {{$action->priority}}
            </div>
            <div class="col-md-12">
                <pre>{{$action->content}} </pre>
            </div>
            <div class="col-md-12">
                附件:
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
