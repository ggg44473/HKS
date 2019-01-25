<div class="row justify-content-center">
    <a href="{{ $department->parent? route('department.index', $department->parent):route('company.index') }}" class="text-black-50" style="position:absolute; top:60px; left:50px;">
        <i class="fas fa-chevron-left"></i> 返回
    </a>
    <div class="col-md-3 u-padding-16">
        <div class="row">
            <a class="u-ml-8 u-mr-8" href="{{ route('department.okr', $department) }}">
                <img src="{{ $department->getAvatar() }}" alt="" class="avatar text-center bg-white">
            </a>
            <div class="u-ml-16 u-mr-8 align-self-center">
                <a href="{{ route('department.okr', $department) }}">
                    <span class="mb-0 font-weight-bold text-black-50 d-inline-block text-truncate" style="max-width: 120px;">{{ $department->name }}</span><br>
                    <span class="mb-0 text-black-50 d-inline-block text-truncate" style="max-width: 120px;">{{ $department->description }}</span><br>
                </a>
                @for ($i = 0; $i < count($department->users) && $i < 3; $i++) 
                    <a href="{{ route('user.okr', $department->users[$i]) }}" class="d-inline-block pt-2" data-toggle="tooltip" data-placement="bottom" title="{{ $department->users[$i]->name }}">
                        <img src="{{ $department->users[$i]->getAvatar() }}" alt="" class="avatar-xs">
                    </a>
                    @if (count($department->users)>5 && $i == 2)
                    <a class="d-inline-block pt-2" href="{{ route('department.member', $department) }}" data-toggle="tooltip" data-placement="bottom" title="與其他 {{ count($department->users)-3 }} 位成員">
                        <img src="{{ asset('img/icon/more/gray.svg') }}" alt="" class="avatar-xs">
                    </a>
                    @endif
                @endfor
            </div>
        </div>
    </div>
    <div class="col-md-5 u-padding-16">
        <div class="row justify-content-md-center">
            @if ($department->okrs)
                @for ($i = 0; $i < 4 && $i < count($department->okrs); $i++)
                <div class="col-3 align-self-center">
                    <div class="circle" data-value="{{ $department->okrs[$i]['objective']->getScore()/100 }}">
                        <div>{{ $department->okrs[$i]['objective']->getScore() }}%</div>
                    </div>
                    <div class="circle-progress-text">{{ $department->okrs[$i]['objective']->title }}</div>
                </div>
                @endfor
            @endif
        </div>
    </div>
    <div class="col-md-2 u-pt-16">
        <div class="row">
            <div class="col-12 text-right">
                @if ($department->following())
                <a href="{{ route('follow.cancel', [get_class($department), $department]) }}" class="text-warning" data-toggle="tooltip" data-placement="right" title="取消追蹤">
                    <i class="fas fa-star" style="font-size: 24px;"></i>
                </a>
                @else
                <a href="{{ route('follow', [get_class($department), $department]) }}" class="text-warning" data-toggle="tooltip" data-placement="right" title="追蹤">
                    <i class="far fa-star" style="font-size: 24px;"></i>
                </a>
                @endif
            </div>
        @if ($department->okrs!=null && count($department->okrs)>4)
            <a href="{{ route('department.okr', $department) }}" class="col-12 {{ $department->user_id == auth()->user()->id? :'u-pb-32' }} text-black-50 align-self-center">more...</a>
        @endif
        @if ($department->user_id == auth()->user()->id)
            <div class="col-12 text-right align-self-end">
                <a href="{{ route('department.root.create') }}" data-toggle="tooltip" data-placement="top" title="新增部門">
                    <i class="fas fa-plus-circle u-margin-4"></i>
                </a>
                <a href="{{ route('department.member.setting', $department) }}" data-toggle="tooltip" data-placement="top" title="新增成員">
                    <i class="fas fa-user-plus u-margin-4"></i>
                </a>
                <a href="{{ route('department.edit', $department) }}" data-toggle="tooltip" data-placement="top" title="編輯組織">
                    <i class="fas fa-edit u-margin-4"></i>
                </a>
                <a href="#" onclick="document.getElementById('departmentDelete').submit()" data-toggle="tooltip" data-placement="top" title="刪除組織">
                    <i class="fas fa-trash-alt"></i>
                </a>
                <form method="POST" id="departmentDelete" action="{{ route('department.destroy', $department) }}">
                    @csrf
                    {{ method_field('DELETE') }}
                </form>
            </div>
        @endif
        </div>
    </div>
</div>
    
