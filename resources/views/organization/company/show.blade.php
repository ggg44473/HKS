<div class="row justify-content-md-center">
    <div class="col-md-4">
        <div class="row">
            <a class="col-md-3" href="{{ route('company.okr') }}">
                <img src="{{ $company->getAvatar() }}" alt="" class="avatar text-center organizationIcon bg-white">
            </a>
            <div class="col-md-9 align-self-center">
                <a href="{{ route('company.okr') }}">
                    <p class="mb-0 font-weight-bold text-black-50">公司名稱: {{ $company->name }}</p>
                    <p class="mb-0 text-black-50">{{ $company->description }}</p>
                </a>
                @if ($company->user_id == auth()->user()->id)
                    <a href="{{ route('department.root.create') }}" data-toggle="tooltip" data-placement="bottom" title="新增部門"><i class="fas fa-plus-circle u-margin-4"></i></a>
                    <a href="{{ route('company.invite') }}" data-toggle="tooltip" data-placement="bottom" title="新增成員"><i class="fas fa-user-plus u-margin-4"></i></a>
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