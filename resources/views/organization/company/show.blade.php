<div class="row justify-content-center">
    <div class="col align-self-end text-right">
        @if ($company->following())
        <a href="{{ route('follow.cancel', [get_class($company), $company]) }}" class="text-warning" data-toggle="tooltip" data-placement="right" title="取消追蹤">
            <i class="fas fa-star" style="font-size: 24px;"></i>
        </a>
        @else
        <a href="{{ route('follow', [get_class($company), $company]) }}" class="text-warning" data-toggle="tooltip" data-placement="right" title="追蹤">
            <i class="far fa-star" style="font-size: 24px;"></i>
        </a>
        @endif
    </div>
</div>
<div class="row justify-content-center">
    <div class="col-md-4 u-padding-16">
        <div class="row">
            <div class="col-auto">
                <a class="u-ml-8 u-mr-8" href="{{ route('company.okr') }}">
                    <img src="{{ $company->getAvatar() }}" alt="" class="avatar text-center bg-white">
                </a>
            </div>
            <div class="col align-self-center text-truncate">
                <a href="{{ route('company.okr') }}">
                    <p class="mb-0 font-weight-bold text-black-50 text-truncate">{{ $company->name }}</p>
                    <p class="mb-0 text-black-50 text-truncate">{{ $company->description }}</p>
                </a>
                @for ($i = 0; $i < count($company->users) && $i < 5; $i++) 
                    <a href="{{ route('user.okr', $company->users[$i]) }}" class="d-inline-block pt-2" data-toggle="tooltip" data-placement="bottom" title="{{ $company->users[$i]->name }}">
                        <img src="{{ $company->users[$i]->getAvatar() }}" alt="" class="avatar-xs">
                    </a>
                    @if (count($company->users)>5 && $i == 4)
                    <a class="d-inline-block pt-2" href="{{ route('company.member') }}" data-toggle="tooltip" data-placement="bottom" title="與其他 {{ count($company->users)-5 }} 位成員">
                        <img src="{{ asset('img/icon/more/gray.svg') }}" alt="" class="avatar-xs">
                    </a>
                    @endif
                @endfor
            </div>
        </div>
    </div>
    <div class="col-md-6 u-padding-16">
        <div class="row">
            @if ($company->okrs)
                @for ($i = 0; $i < 4 && $i < count($company->okrs); $i++)
                <div class="col-auto align-self-center">
                    <div class="circle" data-value="{{ $company->okrs[$i]['objective']->getScore()/100 }}">
                        <div>{{ $company->okrs[$i]['objective']->getScore() }}%</div>
                    </div>
                    <div class="circle-progress-text">{{ $company->okrs[$i]['objective']->title }}</div>
                </div>
                @endfor
                @if (count($company->okrs)>4)
                    <a href="{{ route('company.okr') }}" class="col-12 {{ $company->user_id == auth()->user()->id? :'u-pb-32' }} text-black-50 align-self-center">more...</a>
                @endif
            @endif
        </div>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-md-10 col-12 text-right align-self-end">
        @can('create', App\Department::class)
            <a href="#" data-toggle="modal" data-target="#createDepartment" class="tooltipBtn" data-placement="top" title="新增部門"><i class="fas fa-plus-circle u-margin-4"></i></a>            
        @endcan
        @can('memberSetting', $company)
            <a href="#" data-toggle="modal" data-target="#inviteMember" class="tooltipBtn" data-placement="top" title="新增成員"><i class="fas fa-user-plus u-margin-4"></i></a>            
        @endcan
        @can('update', $company)
            <a href="#" data-toggle="modal" data-target="#editCompany" class="tooltipBtn" data-placement="top" title="編輯組織"><i class="fas fa-edit u-margin-4"></i></a>            
        @endcan
        @can('delete', $company)
            <a href="#" data-toggle="dropdown" class="tooltipBtn" data-placement="top" title="刪除組織"><i class="fas fa-trash-alt"></i></a>
            <form method="POST" id="companyDelete" action="{{ route('company.destroy') }}">
                @csrf
                {{ method_field('DELETE') }}
                <div class="dropdown-menu u-padding-16">
                    <div class="row justify-content-center mb-2">
                        <div class="col-auto text-danger"><i class="fas fa-exclamation-triangle"></i></div>
                    </div>
                    <div class="row">
                        <div class="col text-center">
                            刪除組織後，<br>
                            將失去組織中所有資料！！<br>
                            確認要刪除組織嗎？<br>
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

@can('create', App\Department::class)
{{-- 新增部門modal --}}
@include('organization.department.create', ['parent'=>$company, 'self'=>null, 'children'=>$company->departments, 'department'=>''])
@endcan

@can('update', $company)
{{-- 編輯公司modal --}}
@include('organization.company.edit')
@endcan

@can('memberSetting', $company)
{{-- 邀請成員modal --}}
@include('organization.inviteMember',['id'=>'', 'action'=>route('company.member.invite', $company), 'api'=>route('company.member.search')])
@endcan
