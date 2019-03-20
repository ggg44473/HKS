@extends('layouts.master')
@section('script')
<script src="{{ asset('js/avatar.js') }}" defer></script>
<script src="{{ asset('js/tooltip.js') }}" defer></script>
<script src="{{ asset('js/circle-progress.min.js') }}" defer></script>
<script src="{{ asset('js/circleProgress.js') }}" defer></script>
<script src="{{ asset('js/member.js') }}" defer></script>
@endsection
@section('title','組織成員')
@section('content')
<div class="container">
    @include('organization.company.show')
    <ul class="nav nav-tabs justify-content-center" id="myTab" role="tablist">
        <li class="nav-item">
            <a class="nav-link" id="department-tab" href="{{ route('company.index') }}">子部門</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('company.okr') }}">OKRs</a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" id="member-tab" data-toggle="tab" href="#member" role="tab" aria-controls="member"
                aria-selected="false">成員</a>
        </li>
    </ul>

    @can('memberSetting', $company)
        <div class="box box-primary">
            <div class="box-header with-border">
                <h5 class="box-title mt-2">匯入會員資料</h5>
            </div>
            <div class="box-body">
                <form action="{{route('company.bulk.import.user')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="title">選擇CSV輸入</label>
                        <input type="file" name="file" id="file" class="form-control mb-2 float-right">
                    </div>
                    <div class="form group">
                        <button class="btn btn-primary">
                            <i class="fa fa-upload"></i> 上傳檔案
                        </button>    
                    <div>
                </form>
            </div>
        </div>
    @endcan

        
    {{-- 分頁＋搜尋 --}}
    <div class="row justify-content-md-center">
        <div class="col-sm-10 mt-4">
            <div class="float-right mb-2">
                <form action="{{route('company.member')}}" class="form-inline search-form">
                    <select name="order" class="form-control input-sm mr-2 ml-2">
                        <option value="name_asc">姓名排序</option>
                        <option value="email_asc">信箱排序</option>
                        <option value="department_id_asc">部門度排序</option>
                        <option value="position_asc">職稱排序</option>
                    </select>
                    <button type="submit" value="Submit" class="btn btn-primary">搜索</button>
                </form>
            </div>
            {{ $members->links() }}
        </div>
    </div>
    {{-- 成員表 --}}
    <form name="memberUpdate" method="POST" id="memberUpdate" action="{{ route('company.member.update') }}">
        @csrf
        {{ method_field('PATCH') }}
    <div class="row justify-content-md-center">
        <div class="col-sm-10 mt-4">
            <div class="row justify-content-between mb-2">
                <div class="col-auto">公司成員</div>
                @can('memberSetting', $company)
                <div class="col-auto btn btn-info btn-sm text-white mr-4" onclick="getElementById('memberUpdate').submit();"><i class="fas fa-save"></i> 儲存全部變更</div>
                @endcan
            </div>
            <table class="rwd-table table table-hover">
                <thead>
                    <tr class="bg-primary text-light text-center">
                        <th>追蹤</th>
                        <th>姓名</th>
                        <th>部門</th>
                        <th>職稱</th>
                        <th>權限<a href="" data-toggle="modal" data-target="#rolePermission"><i class="fas fa-question-circle text-white pl-2"></i></a></th>
                        @can('memberSetting', $company)
                            <th>設定</th>                                
                        @endcan
                    </tr>
                </thead>
                <tbody>
                    @foreach($members as $member)
                    <tr class="text-center">
                        <td data-th="追蹤" class="align-middle">
                            @if ($member->id != auth()->user()->id)
                                @if ($member->following())
                                <a href="{{ route('follow.cancel', [get_class($member), $member]) }}" class="text-warning">
                                    <i class="fas fa-star" style="font-size: 24px;"></i>
                                </a>
                                @else
                                <a href="{{ route('follow', [get_class($member), $member]) }}" class="text-warning">
                                    <i class="far fa-star" style="font-size: 24px;"></i>
                                </a>
                                @endif
                            @endif
                        </td>
                        <td data-th="姓名" class="text-left align-middle">
                            <a href="{{ route('user.okr', $member->id) }}" class="text-black-50">
                                <img src="{{ $member->getAvatar() }}" alt="" class="avatar-sm text-center bg-white mr-4">
                                {{ $member->name }}
                            </a>
                        </td>
                        {{-- 有變更權限 --}}
                        {{-- 權限最高，設定自己 --}}
                        @can('adminCange', [$member, $company])
                            <td data-th="部門" class="align-middle">
                                <select name="department{{ $member->id }}" id="department" class="form-control">
                                    <option value="{{$company->id}}">{{ $company->name }}</option>
                                    @foreach ($company->departments as $department)
                                        @if ($department->id == $member->department_id)
                                        <option value="{{ $department->id }}" selected>{{ $department->name }}</option>
                                        @else
                                        <option value="{{ $department->id }}">{{ $department->name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </td>
                            <td data-th="職稱" class="align-middle">
                                <input name="position{{ $member->id }}" type="text" class="form-control" value="{{ $member->position }}">
                            </td>
                            <td data-th="權限" class="align-middle"><a href="#" data-toggle="modal" data-target="#changAdmin" class="tooltipBtn" data-placement="top" title="變更擁有者">{{ $member->role($company)->name }}</a></td>
                            <td data-th="設定" class="align-middle">
                                <a href="#"  onclick="document.getElementById('memberUpdate').submit()" class="pr-2 store-btn text-black-50"><i class="fas fa-save"></i></a>
                                {{-- <a href="#" data-toggle="modal" data-target="#deleteAdmin" class="tooltipBtn" data-placement="top" title="變更擁有者後刪除"><i class="fas fa-trash-alt text-black-50"></i></a> --}}
                            </td>
                        {{-- 管理者，可以設定比自己低的人 --}}
                        @elsecan('permissionCange', [$member, $company])
                            <td data-th="部門" class="align-middle">
                                <select name="department{{ $member->id }}" id="department" class="form-control">
                                    <option value="">{{ $company->name }}</option>
                                    @foreach ($company->departments as $department)
                                    @if ($department->id == $member->department_id)
                                    <option value="{{ $department->id }}" selected>{{ $department->name }}</option>
                                    @else
                                    <option value="{{ $department->id }}">{{ $department->name }}</option>
                                    @endif
                                    @endforeach
                                </select>
                            </td>
                            <td data-th="職稱" class="align-middle">
                                <input name="position{{ $member->id }}" type="text" class="form-control" value="{{ $member->position }}">
                            </td>
                            <td data-th="權限" class="align-middle">
                                <select name="permission{{ $member->id }}" id="permission" class="form-control">
                                    <option value="2">管理者</option>
                                    <option value="3" {{ $member->role($company)->id == 3?'selected':''}}>編輯</option>
                                    <option value="4" {{ $member->role($company)->id == 4?'selected':''}}>成員</option>
                                </select>
                            </td>
                            <td data-th="設定" class="align-middle">
                                <a href="#"  onclick="document.getElementById('memberUpdate').submit()" class="pr-2 store-btn text-black-50"><i class="fas fa-save"></i></a>
                                {{-- <a href="#" data-toggle="dropdown"><i class="fas fa-trash-alt text-black-50"></i></a>
                                <div class="dropdown-menu u-padding-16">
                                    <div class="row justify-content-center mb-2">
                                        <div class="col-auto text-danger"><i class="fas fa-exclamation-triangle"></i></div>
                                    </div>
                                    <div class="row">
                                        <div class="col text-center">
                                            從{{ $company->name }}中<br>
                                            刪除{{ $member->name }}成員嗎？<br>
                                        </div>
                                    </div>
                                    <div class="row justify-content-center mt-3">
                                        <div class="col-auto text-center pr-2"><button class="btn btn-danger pl-4 pr-4" onclick="document.getElementById('memberDelete{{ $member->id }}').submit()">刪除</button></div>
                                        <div class="col-auto text-center pl-2"><a class="btn btn-secondary text-white pl-4 pr-4">取消</a></div>
                                    </div>
                                </div> --}}
                            </td>
                        {{-- 一般成員 --}}
                        @elsecan('memberSetting', $company)
                            <td data-th="部門" class="align-middle">{{ $member->department? $member->department->name:$company->name }}</td>
                            <td data-th="職稱" class="align-middle">{{ $member->position }}</td>
                            <td data-th="權限" class="align-middle">{{ $member->role($company)->name }}</td>
                            <td data-th="設定" class="align-middle"></td>
                        @endcan
                        {{-- 無變更權限 --}}
                        @cannot('memberSetting', $company)
                            <td data-th="部門" class="align-middle">{{ $member->department? $member->department->name:$company->name }}</td>
                            <td data-th="職稱" class="align-middle">{{ $member->position }}</td>
                            <td data-th="權限" class="align-middle">{{ $member->role($company)->name }}</td>
                        @endcannot
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    </form>
    {{-- 邀請中的成員 --}}
    @if ($company->getInvitationUsers())
        <div class="row justify-content-md-center">
            <div class="col-sm-10">邀請中成員
                <table class="rwd-table table table-hover">
                    <thead>
                        <tr class="bg-primary text-light text-center">
                            <th>頭像</th>
                            <th>姓名</th>
                            <th>信箱</th>
                            @can('memberSetting', $company)
                                <th>設定</th>
                            @endcan
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($company->getInvitationUsers() as $member)
                        <tr class="text-center">
                            <td data-th="頭像" class="align-middle">
                                <img src="{{ $member->getAvatar() }}" class="avatar-sm text-center bg-white">
                            </td>
                            <td data-th="姓名" class="align-middle">{{ $member->name }}</td>
                            <td data-th="信箱" class="align-middle">{{ $member->email }}</td>
                            @can('memberSetting', $company)
                            <td data-th="設定" class="align-middle">
                                <a href="#" onclick="document.getElementById('memberDelete{{ $member->id }}').submit()">
                                    <i class="fas fa-trash-alt text-black-50"></i>
                                </a>
                                <form name="memberDelete{{ $member->id }}" method="POST" id="memberDelete{{ $member->id }}"
                                    action="{{ route('company.member.invite.destroy', [$company, $member]) }}">
                                    @csrf
                                    {{ method_field('PATCH') }}
                                </form>
                            </td>
                            @endcan
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
</div>
@foreach($members as $member)
{{-- @can('memberSetting', $company)
    <form name="memberUpdate{{ $member->id }}" method="POST" id="memberUpdate{{ $member->id }}" action="{{ route('company.member.update', $member ) }}">
        @csrf
        {{ method_field('PATCH') }}
    </form>    
@endcan --}}
@can('memberDelete', [$member, $company])
    <form name="memberDelete{{ $member->id }}" method="POST" id="memberDelete{{ $member->id }}" action="{{ route('company.member.destroy', $member ) }}">
        @csrf
        {{ method_field('PATCH') }}
    </form>
@endcan
@endforeach
@can('adminCange', [auth()->user(), $company])
{{-- 變更擁有者modal --}}
<div class="modal fade" id="changAdmin" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row mb-4">
                    <div class="col-12 text-center font-weight-bold"><h5>變更公司管理人</h5></div>
                </div>
                <form action="{{ route('company.admin.change') }}" method="post">
                    @csrf
                    {{ method_field('PATCH') }}
                    <div class="row pb-4">
                        <div class="col-12">
                            <label class="mb-0">公司管理人</label>                                                                               
                            <search-only-component api={{ route('company.member.search') }}></search-only-component>
                        </div>
                    </div>
                    <div class="row pb-4">
                        <div class="col-12 text-right">
                            <button type="submit" class="btn btn-primary">變更</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
{{-- 變更權限後刪除 --}}
<div class="modal fade" id="deleteAdmin" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row mb-4">
                    <div class="col-12 text-center font-weight-bold"><h5><i class="fas fa-exclamation-triangle text-danger pr-3"></i>變更管理權限後刪除</h5></div>
                </div>
                <form action="{{ route('company.admin.delete') }}" method="post">
                    @csrf
                    {{ method_field('PATCH') }}
                    <div class="row pb-4">
                        <div class="col-12">
                            <label class="mb-0">公司｜{{ $company->name }}</label>
                            <search-only-component api={{ route('company.member.search') }}></search-only-component>
                        </div>
                    </div>
                    @if (auth()->user()->permissions()->where(['model_type'=>App\Department::class,'role_id'=>1])->first())
                    <div class="row pb-4">
                            <div class="col-12">
                                <label class="mb-0">部門｜{{ auth()->user()->department->name }}</label>
                                <select name="department" id="department" class="form-control">
                                    @foreach (auth()->user()->department->users as $user)
                                        @if ($user->id!=auth()->user()->id)
                                            <option value="{{ $user->id }}">{{ $user->name }}</option>                                        
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    @endif
                    @foreach (auth()->user()->permissions()->where(['model_type'=>App\Project::class,'role_id'=>1])->get() as $permission)
                        <div class="row pb-4">
                            <div class="col-12">
                                <label class="mb-0">專案｜{{ $permission->model->name }}</label>
                                <select name="project{{ $permission->model->id }}" id="project{{ $permission->model->id }}" class="form-control">
                                    @foreach ($permission->model->users as $user)
                                        @if ($user->id!=auth()->user()->id)
                                            <option value="{{ $user->id }}">{{ $user->name }}</option>                                        
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    @endforeach
                    <div class="row pb-4 pt-4">
                        <div class="col-12 text-center">
                            <button type="submit" class="btn btn-danger pl-4 pr-4">變更後刪除</button>
                            <a class="btn btn-secondary text-white pl-4 pr-4" data-dismiss="modal">取消刪除</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endcan
{{-- 權限說明modal --}}
@include('permission.rolePermission', ['type'=>'組織'])
@endsection
