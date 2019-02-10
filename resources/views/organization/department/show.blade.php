<div class="row justify-content-center">
    <div class="col">
        <a href="{{ $department->parent? route('department.index', $department->parent):route('company.index') }}" class="text-black-50">
            <i class="fas fa-chevron-left"></i> 返回
        </a>
    </div>
    <div class="col text-right">
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
</div>
<div class="row justify-content-center">
    <div class="col-md-4 u-padding-16">
        <div class="row">
            <div class="col-auto">
                <a class="u-ml-8 u-mr-8" href="{{ route('department.okr', $department) }}">
                    <img src="{{ $department->getAvatar() }}" alt="" class="avatar text-center bg-white">
                </a>
            </div>
            <div class="col align-self-center text-truncate">
                <a href="{{ route('department.okr', $department) }}">
                    <span class="mb-0 font-weight-bold text-black-50 text-truncate">{{ $department->name }}</span><br>
                    <p class="mb-0 text-black-50 text-truncate">{{ $department->description }}</p>
                </a>
                @for ($i = 0; $i < count($department->users) && $i < 5; $i++) 
                    <a href="{{ route('user.okr', $department->users[$i]) }}" class="d-inline-block pt-2" data-toggle="tooltip" data-placement="bottom" title="{{ $department->users[$i]->name }}">
                        <img src="{{ $department->users[$i]->getAvatar() }}" alt="" class="avatar-xs">
                    </a>
                    @if (count($department->users)>5 && $i == 4)
                    <a class="d-inline-block pt-2" href="{{ route('department.member', $department) }}" data-toggle="tooltip" data-placement="bottom" title="與其他 {{ count($department->users)-5 }} 位成員">
                        <img src="{{ asset('img/icon/more/gray.svg') }}" alt="" class="avatar-xs">
                    </a>
                    @endif
                @endfor
            </div>
        </div>
    </div>
    <div class="col-md-6 col">
        @if ($department->okrs)
            <div class="row u-padding-16">
                @for ($i = 0; $i < 4 && $i < count($department->okrs); $i++)
                <a class="col-3 align-self-center" href="#oid-{{$department->okrs[$i]['objective']->id}}">
                    <div class="circle" data-value="{{ $department->okrs[$i]['objective']->getScore()/100 }}">
                        <div>{{ $department->okrs[$i]['objective']->getScore() }}%</div>
                    </div>
                    <div class="circle-progress-text">{{ $department->okrs[$i]['objective']->title }}</div>
                </a>
                @endfor
            </div>
        @endif
    </div>
</div>
<div class="row justify-content-center">
    <div class="col-12 text-right align-self-end">
        @can('create', App\Department::class)
            <a href="#" data-toggle="modal" data-target="#createDepartment{{ $department->id }}" class="tooltipBtn text-info" data-placement="top" title="新增部門"><i class="fas fa-plus-circle u-margin-4"></i></a>
        @endcan
        @can('memberSetting', $department)
            <a href="#" data-toggle="modal" data-target="#inviteMember{{ $department->id }}" class="tooltipBtn text-info" data-placement="top" title="新增成員"><i class="fas fa-user-plus u-margin-4"></i></a>                    
        @endcan
        @can('update', $department)
            <a href="#" data-toggle="modal" data-target="#editDepartment{{ $department->id }}" class="tooltipBtn text-info" data-placement="top" title="編輯組織"><i class="fas fa-edit u-margin-4"></i></a>                    
        @endcan
        @can('delete', $department)
            <a href="#" data-toggle="dropdown" class="tooltipBtn text-info" data-placement="top" title="刪除部門"><i class="fas fa-trash-alt"></i></a>
            <form method="POST" id="departmentDelete{{ $department->id }}" action="{{ route('department.destroy', $department->id) }}">
                @csrf
                {{ method_field('DELETE') }}
                <div class="dropdown-menu u-padding-16">
                    <div class="row justify-content-center mb-2">
                        <div class="col-auto text-danger"><i class="fas fa-exclamation-triangle"></i></div>
                    </div>
                    <div class="row">
                        <div class="col text-center">
                            刪除部門後，<br>
                            將失去部門中所有資料！！<br>
                            確認要刪除部門嗎？<br>
                        </div>
                    </div>
                    <div class="row justify-content-center mt-3">
                        <div class="col-auto text-center pr-2"><button class="btn btn-danger pl-4 pr-4" type="submit">刪除</button></div>
                        <div class="col-auto text-center pl-2"><a class="btn btn-secondary text-white pl-4 pr-4">取消</a></div>
                    </div>
                </div>
            </form>
        @endcan
    </div>
</div>

{{-- 新增部門modal --}}
@can('create', App\Department::class)
@include('organization.department.create', ['parent'=>null, 'self'=>$department, 'children'=>$department->children])
@endcan

{{-- 編輯部門modal --}}
@can('update', $department)
@include('organization.department.edit')
@endcan

{{-- 邀請成員modal --}}
@can('memberSetting', $department)
@include('organization.inviteMember',['id'=>$department->id,'action'=>route('department.member.store', $department), 'api'=>route('department.member.search', $department->company)])
@endcan
