<div class="row justify-content-md-center">
    <div class="col-md-3 u-margin-16">
        <div class="row">
            <a class="u-ml-8 u-mr-8" href="{{ route('company.okr') }}">
                <img src="{{ $company->getAvatar() }}" alt="" class="avatar text-center organizationIcon bg-white">
            </a>
            <div class="u-ml-8 u-mr-8 align-self-center">
                <a href="{{ route('company.okr') }}">
                    <span class="mb-0 font-weight-bold text-black-50">公司名稱: {{ $company->name }}</span><br>
                    <span class="mb-0 text-black-50">{{ $company->description }}</span><br>
                </a>
                @if ($company->user_id == auth()->user()->id)
                    <a href="{{ route('department.root.create') }}" data-toggle="tooltip" data-placement="bottom" title="新增部門"><i class="fas fa-plus-circle u-margin-4"></i></a>
                    <a href="{{ route('company.member.setting') }}" data-toggle="tooltip" data-placement="bottom" title="新增成員"><i class="fas fa-user-plus u-margin-4"></i></a>
                    <a href="{{ route('company.edit') }}" data-toggle="tooltip" data-placement="bottom" title="編輯組織"><i class="fas fa-edit u-margin-4"></i></a>
                    <a href="#" onclick="document.getElementById('companyDelete').submit()" data-toggle="tooltip" data-placement="bottom" title="刪除組織"><i class="fas fa-trash-alt"></i></a>
                    <form method="POST" id="companyDelete" action="{{ route('company.destroy') }}">
                        @csrf
                        {{ method_field('DELETE') }}
                    </form>
                @endif
            </div>
        </div>
    </div>
</div>