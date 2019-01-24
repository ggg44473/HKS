<div class="row justify-content-md-center">
    <div class="col-md-3 u-padding-16">
        <div class="row">
            <a class="u-ml-8 u-mr-8" href="{{ route('company.okr') }}">
                <img src="{{ $company->getAvatar() }}" alt="" class="avatar text-center organizationIcon bg-white">
            </a>
            <div class="u-ml-8 u-mr-8 align-self-center">
                <a href="{{ route('company.okr') }}">
                    <span class="mb-0 font-weight-bold text-black-50 d-inline-block text-truncate" style="max-width: 120px;">{{ $company->name }}</span><br>
                    <span class="mb-0 text-black-50 d-inline-block text-truncate" style="max-width: 120px;">{{ $company->description }}</span><br>
                </a>
                @for ($i = 0; $i < count($company->users) && $i < 3; $i++) 
                    <a href="{{ route('user.okr', $company->users[$i]) }}" class="d-inline-block pt-2" data-toggle="tooltip" data-placement="bottom" title="{{ $company->users[$i]->name }}">
                        <img src="{{ $company->users[$i]->getAvatar() }}" alt="" class="avatar-xs">
                    </a>
                    @if (count($company->users)>5 && $i == 2)
                    <a id="moreMember" class="d-inline-block pt-2" data-toggle="tooltip" data-placement="bottom" title="與其他 {{ count($company->users)-3 }} 位成員">
                        <img src="{{ asset('img/icon/more/gray.svg') }}" alt="" class="avatar-xs">
                    </a>
                    @endif
                @endfor
            </div>
        </div>
    </div>
    <div class="col-md-5 u-padding-16 u-pt-32">
        <div class="row">
            @if ($company->okrs)
                @for ($i = 0; $i < 4 && $i < count($company->okrs); $i++)
                <div class="col-3 align-self-center">
                    <div class="circle" data-value="{{ $company->okrs[$i]['objective']->getScore()/100 }}">
                        <div>{{ $company->okrs[$i]['objective']->getScore() }}%</div>
                    </div>
                    <div class="circle-progress-text">{{ $company->okrs[$i]['objective']->title }}</div>
                </div>
                @endfor
            @endif
        </div>
    </div>
    <div class="col-md-2 align-self-end">
        {{-- @if (count($company->okrs)>4)
        <div class="row">
            <a id="moreObjective" class="col-12 {{ $company->user_id == auth()->user()->id? :'u-pb-32' }} text-black-50">more...</a>
        </div>
        @endif --}}
        @if ($company->user_id == auth()->user()->id)
        <div class="row">
            <div class="col-12 text-right">
                <a href="{{ route('department.root.create') }}" data-toggle="tooltip" data-placement="top" title="新增部門">
                    <i class="fas fa-plus-circle u-margin-4"></i>
                </a>
                <a href="{{ route('company.member.setting') }}" data-toggle="tooltip" data-placement="top" title="新增成員">
                    <i class="fas fa-user-plus u-margin-4"></i>
                </a>
                <a href="{{ route('company.edit') }}" data-toggle="tooltip" data-placement="top" title="編輯組織">
                    <i class="fas fa-edit u-margin-4"></i>
                </a>
                <a href="#" onclick="document.getElementById('companyDelete').submit()" data-toggle="tooltip" data-placement="top" title="刪除組織">
                    <i class="fas fa-trash-alt"></i>
                </a>
                <form method="POST" id="companyDelete" action="{{ route('company.destroy') }}">
                    @csrf
                    {{ method_field('DELETE') }}
                </form>
            </div>
        </div>
        @endif
    </div>
</div>
