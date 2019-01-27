<div class="col-md-4 col-lg-3">
    <div class="card u-mt-16 u-margin-4">
        <div class="card-header pb-0">
            <div class="row">
                <div class="col-12 text-right">
                    @if ($department->following())
                    <a href="{{ route('follow.cancel', [get_class($department), $department]) }}" class="text-warning" data-toggle="tooltip" data-placement="right" title="取消追蹤">
                        <i class="fas fa-star" style="font-size: 20px;"></i>
                    </a>
                    @else
                    <a href="{{ route('follow', [get_class($department), $department]) }}" class="text-warning" data-toggle="tooltip" data-placement="right" title="追蹤">
                        <i class="far fa-star" style="font-size: 20px;"></i>
                    </a>
                    @endif
                </div>
            </div>
            <a href="{{ count($department->children)>0? route('department.index', $department):route('department.okr', $department) }}">
                <div class="row pl-4 pr-4">
                    <div class="col-auto align-self-center">
                        <img src="{{ $department->getAvatar() }}" alt="" class="avatar-md" style="vertical-align:top;">
                    </div>
                    <div class="col text-truncate">
                        <p class="font-weight-bold text-black-50 mb-0 text-truncate">{{ $department->name }}</p>
                        <div class="text-black-50 text-truncate">{{ $department->description }}</div>
                    </div>
                </div>
            </a>
            <div class="row pt-2">
                <div class="col-12 text-right">
                    @if (count($department->children)>0)
                        <a href="{{ route('department.index', $department) }}">
                            <span class="text-black-50" style="font-size:10px;">{{ count($department->children) }} 子部門</span>
                        </a>
                    @endif
                    <a href="{{ route('department.member', $department) }}" class="pl-2">
                        <span class="text-black-50" style="font-size:10px;">{{ count($department->users) }} 位成員</span>
                    </a>
                </div>
            </div>
        </div>

        <div class="card-body">
            @if ($department->okrs)
            @foreach ($department->okrs as $okrs)
            <div class="row justify-content-center mb-1 mt-2">
                <div class="col-12 text-black-50 text-center text-truncate">{{ $okrs['objective']->title }}</div>
            </div>
            <div class="row mb-3">
                <div class="col-12">
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
        
        <div class="row pr-4">
            <div class="col-12 text-right pb-2">&nbsp
                @if ($department->user_id == auth()->user()->id)
                <a href="{{ route('department.create', $department->id) }}" data-toggle="tooltip" data-placement="bottom"
                    title="新增部門"><i class="fas fa-plus-circle u-margin-4"></i></a>
                <a href="{{ route('department.member.setting', $department) }}" data-toggle="tooltip" data-placement="bottom"
                    title="新增成員"><i class="fas fa-user-plus u-margin-4"></i></a>
                <a href="{{ route('department.edit', $department->id) }}" data-toggle="tooltip" data-placement="bottom"
                    title="編輯部門"><i class="fas fa-edit u-margin-4"></i></a>
                <a href="#" onclick="document.getElementById('departmentDelete{{ $department->id }}').submit()" data-toggle="tooltip"
                    data-placement="bottom" title="刪除部門"><i class="fas fa-trash-alt"></i></a>
                <form method="POST" id="departmentDelete{{ $department->id }}" action="{{ route('department.destroy', $department->id) }}">
                    @csrf
                    {{ method_field('DELETE') }}
                </form>
                @endif
            </div>
        </div>
    </div>
</div>
