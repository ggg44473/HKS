<div class="row justify-content-md-center">
    <div class="col-md-4 u-padding-16">
        <div class="row">
            <a class="u-ml-8 u-mr-8" href="{{ route('company.okr') }}">
                <img src="{{ $company->getAvatar() }}" alt="" class="avatar text-center organizationIcon bg-white">
            </a>
            <div class="u-ml-8 u-mr-8 align-self-center">
                <a href="{{ route('company.okr') }}">
                    <span class="mb-0 font-weight-bold text-black-50">{{ $company->name }}</span><br>
                    <span class="mb-0 text-black-50">{{ $company->description }}</span><br>
                </a>
                @for ($i = 0; $i < count($company->users) && ($i <= 5); $i++) <a href="{{ route('user.okr', $company->users[$i]) }}"
                        class="d-inline-block pt-2" data-toggle="tooltip" data-placement="bottom" title="{{ $company->users[$i]->name }}">
                        <img src="{{ $company->users[$i]->getAvatar() }}" alt="" class="avatar-xs">
                        </a>
                        @if (count($company->users)>5 && $i == 5)
                        <a href="#" class="d-inline-block pt-2" data-toggle="tooltip" data-placement="bottom" title="與其他 {{ count($company->users)-6 }} 位成員">
                            <img src="{{ asset('img/icon/more/gray.svg') }}" alt="" class="avatar-xs">
                        </a>
                        @endif
                        @endfor
            </div>
        </div>
    </div>
    <div class="col-md-4 u-padding-16 u-pt-32">
        <div class="row mb-2">
            <div class="col-12">
                <span class="font-weight-bold text-black-50" style="font-size:16px;">Objective</span>
            </div>
        </div>
        @if ($company->okrs)
        @foreach ($company->okrs as $okr)
        <div class="row mb-2">
            <div class="col-6">
                <span class="font-weight-bold text-black-50 pl-2" style="font-size:16px;">{{ $okr['objective']->title }}</span>
            </div>
            <div class="col-6">
                <div class="progress" style="height:20px;">
                    @if($okr['objective']->getScore()<0) <div class="progress-bar bg-danger" role="progressbar" style="width:{{ abs($okr['objective']->getScore()) }}%;"
                        aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">{{ $okr['objective']->getScore() }}%
                </div>
                @else
                <div class="progress-bar" role="progressbar" style="width:{{ $okr['objective']->getScore() }}%;"
                    aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">{{ $okr['objective']->getScore() }}%
                </div>
                @endif
            </div>
        </div>
    </div>
    @endforeach
    @else
    <div class="row">
        <div class="col-lg-3 text-center mw-100">
            <span class="font-weight-bold text-black-50" style="font-size: 16px;">Objective</span>
        </div>
        <div class="col-lg-7 text-black-50 text-center text-lg-left">尚未具有進行中的Objective</div>
    </div>
    @endif
</div>
<div class="col-md-2">
    @if ($company->user_id == auth()->user()->id)
    <div class="row">
        <div class="col-12 text-right">
            <a href="{{ route('department.root.create') }}" data-toggle="tooltip" data-placement="bottom" title="新增部門"><i
                    class="fas fa-plus-circle u-margin-4"></i></a>
            <a href="{{ route('company.member.setting') }}" data-toggle="tooltip" data-placement="bottom" title="新增成員"><i
                    class="fas fa-user-plus u-margin-4"></i></a>
            <a href="{{ route('company.edit') }}" data-toggle="tooltip" data-placement="bottom" title="編輯組織"><i class="fas fa-edit u-margin-4"></i></a>
            <a href="#" onclick="document.getElementById('companyDelete').submit()" data-toggle="tooltip"
                data-placement="bottom" title="刪除組織"><i class="fas fa-trash-alt"></i></a>
            <form method="POST" id="companyDelete" action="{{ route('company.destroy') }}">
                @csrf
                {{ method_field('DELETE') }}
            </form>
        </div>
    </div>
    @endif
</div>
</div>
