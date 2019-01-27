<div class="col-md-4 col-sm-6 u-mb-16">
    <div class="card u-margin-8">
        <div class="card-header">
            {{-- 追蹤 --}}
            <div class="row">
                <div class="col-12 text-right">
                    @if ($project->following())
                    <a href="{{ route('follow.cancel', [get_class($project), $project]) }}" class="text-warning" data-toggle="tooltip" data-placement="right" title="取消追蹤">
                        <i class="fas fa-star" style="font-size: 20px;"></i>
                    </a>
                    @else
                    <a href="{{ route('follow', [get_class($project), $project]) }}" class="text-warning" data-toggle="tooltip" data-placement="right" title="追蹤">
                        <i class="far fa-star" style="font-size: 20px;"></i>
                    </a>
                    @endif
                </div>
            </div>
            {{-- 專案資訊 --}}
            <a href="{{ route('project.okr', $project) }}">
                <div class="row pl-4 pr-4">
                    <div class="col-auto align-self-center pr-0">
                        <img src="{{ $project->getAvatar() }}" alt="" class="avatar-md" style="vertical-align:top;">
                    </div>
                    <div class="col text-truncate">
                        <p class="font-weight-bold text-black-50 mb-0 text-truncate">{{ $project->name }}</p>
                        <div class="text-black-50 text-truncate">{{ $project->description }}</div>
                    </div>
                </div>
            </a>
            {{-- 專案成員 --}}
            <div class="row pt-2">
                <div class="col-12 text-right">
                    @for ($i = 0; $i < count($project->users) && $i < 5; $i++) 
                        <a href="{{ route('user.okr', $project->users[$i]) }}" class="d-inline-block pt-2" data-toggle="tooltip" data-placement="bottom" title="{{ $project->users[$i]->name }}">
                            <img src="{{ $project->users[$i]->getAvatar() }}" alt="" class="avatar-xs">
                        </a>
                        @if (count($project->users)>5 && $i == 4)
                        <a class="d-inline-block pt-2" href="#" data-toggle="tooltip" data-placement="bottom" title="與其他 {{ count($project->users)-5 }} 位成員">
                            <img src="{{ asset('img/icon/more/gray.svg') }}" alt="" class="avatar-xs">
                        </a>
                        @endif
                    @endfor
                    <a href="{{ route('project.member', $project) }}" class="pl-2">
                        <span class="text-black-50" style="font-size:10px;">｜共 {{ count($project->users) }} 位成員</span>
                    </a>
                </div>
            </div>
        </div>
        <a href="{{ route('project.okr', $project) }}">
            <div class="card-body">
                {{-- objective --}}
                @if ($project->okrs)
                @foreach ($project->okrs as $okrs)
                <div class="row justify-content-center mb-1 mt-2 pl-4 pr-4">
                    <div class="col-md-7 col text-black-50 text-truncate">{{ $okrs['objective']->title }}</div>
                    <div class="col-md-5 col">
                        <div class="progress" style="height:14px;">
                            @if($okrs['objective']->getScore()<0) 
                            <div class="progress-bar bg-danger" role="progressbar"
                                style="width:{{ abs($okrs['objective']->getScore()) }}%;" aria-valuenow="25"
                                aria-valuemin="0" aria-valuemax="100">{{ $okrs['objective']->getScore() }}%
                            </div>
                            @else
                            <div class="progress-bar" role="progressbar" style="width:{{ $okrs['objective']->getScore() }}%;"
                                aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">{{ $okrs['objective']->getScore() }}%
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
                @else
                <div class="row justify-content-center mb-1 mt-2">
                    <div class="col-12 text-black-50 text-center text-truncate">當前期間尚未建立OKR !!</div>
                </div>
                @endif
            </div>
        </a>
            
        {{-- 管理員設定 --}}
        <div class="row pr-4">
            <div class="col-12 text-right pb-2">&nbsp
                @if ($project->user_id == auth()->user()->id)
                <a href="{{ route('project.done', $project) }}" data-toggle="tooltip" data-placement="bottom" title="{{ $project->isdone?'取消關閉':'關閉專案'}}"><i class="far fa-check-square u-margin-4"></i></a>                    
                <a href="{{ route('project.member.setting', $project) }}" data-toggle="tooltip" data-placement="bottom" title="新增成員"><i class="fas fa-user-plus u-margin-4"></i></a>
                <a href="#" data-toggle="modal" data-target="#editProject" class="tooltipBtn" data-placement="bottom" title="編輯專案"><i class="fas fa-edit u-margin-4"></i></a>
                <a href="#" data-toggle="dropdown" class="tooltipBtn" data-placement="bottom" title="刪除專案"><i class="fas fa-trash-alt"></i></a>
                <form method="POST" id="projectDelete" action="{{ route('project.destroy', $project) }}">
                    @csrf
                    {{ method_field('DELETE') }}
                    <div class="dropdown-menu u-padding-16">
                        <div class="row justify-content-center mb-2">
                            <div class="col-auto text-danger"><i class="fas fa-exclamation-triangle"></i></div>
                        </div>
                        <div class="row">
                            <div class="col text-center">
                                <div class="">刪除專案後，</div>
                                <div>將失去專案中所有資料！！</div>
                                <div>確認要刪除專案嗎？</div>
                            </div>
                        </div>
                        <div class="row justify-content-center mt-3">
                            <div class="col-auto text-center pr-2"><button class="btn btn-danger pl-4 pr-4" type="submit">刪除</button></div>
                            <div class="col-auto text-center pl-2"><a class="btn btn-secondary text-white pl-4 pr-4">取消</a></div>
                        </div>
                    </div>
                </form>
                @endif
            </div>
        </div>
    </div>
</div>
{{-- 編輯專案Modal --}}
@include('project.edit')
