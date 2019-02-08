@extends('layouts.master')
@section('script')
<script src="{{ asset('js/avatar.js') }}" defer></script>
<script src="{{ asset('js/tooltip.js') }}" defer></script>
<script src="{{ asset('js/circle-progress.min.js') }}" defer></script>
<script src="{{ asset('js/circleProgress.js') }}" defer></script>
@endsection
@section('title','部門成員')
@section('content')
<div class="container">
    @include('organization.department.show')
    <ul class="nav nav-tabs justify-content-center" id="myTab" role="tablist">
        @if (count($department->children) > 0)
        <li class="nav-item">
            <a class="nav-link" id="department-tab" href="{{ route('department.index', $department) }}">子部門</a>
        </li>
        @endif
        <li class="nav-item">
            <a class="nav-link" href="{{ route('department.okr', $department) }}">OKRs</a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" id="member-tab" data-toggle="tab" href="#member" role="tab" aria-controls="member"
                aria-selected="false">成員</a>
        </li>
    </ul>
    <div class="row justify-content-md-center">
        <div class="col-sm-10 mt-4">
            @if (count($department->users))
                <div class="float-right mb-2">
                    <form action="{{route('department.member', $department)}}" class="form-inline search-form">
                        <select name="order" class="form-control input-sm mr-2 ml-2">
                            <option value="name_asc">姓名排序</option>
                            <option value="email_asc">信箱排序</option>
                            <option value="position_asc">職稱排序</option>
                        </select>
                        <button type="submit" value="Submit" class="btn btn-primary">搜索</button>
                    </form>
                </div>
                {{ $members->links() }}
                <table class="rwd-table table table-hover">
                    <thead>
                        <tr class="bg-primary text-light text-center">
                            <th>追蹤</th>
                            <th>姓名</th>
                            <th>部門</th>
                            <th>職稱</th>
                            <th>權限<a href="" data-toggle="modal" data-target="#rolePermission"><i class="fas fa-question-circle text-white pl-2"></i></a></th>
                            @can('memberSetting', $department)
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
                                    <img src="{{ $member->getAvatar() }}" alt="" class="avatar-sm text-center bg-white">
                                    {{ $member->name }}
                                </a>
                            </td>
                            {{-- 有變更權限 --}}
                            {{-- 管理者，可以設定比自己低的人 --}}
                            @can('permissionCange', [$member, $department])
                            <td data-th="部門" class="align-middle">
                                <select name="department" id="department" class="form-control" form="memberUpdate{{ $member->id }}">
                                    <option value="{{ $department->id }}" selected>{{ $department->name }}</option>
                                    @foreach ($department->children as $child)
                                        <option value="{{ $child->id }}">{{ $child->name }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td data-th="職稱" class="align-middle">
                                <input name="position" type="text" class="form-control" value="{{ $member->position }}" form="memberUpdate{{ $member->id }}">
                            </td>
                            <td data-th="權限" class="align-middle">
                                <select name="permission" id="permission" class="form-control" form="memberUpdate{{ $member->id }}">
                                    <option value="2">管理者</option>
                                    <option value="3" {{ $member->role($department)->id == 3?'selected':''}}>編輯</option>
                                    <option value="4" {{ $member->role($department)->id == 4?'selected':''}}>成員</option>
                                </select>
                            </td>
                            <td data-th="設定" class="align-middle">
                                <a href="#"  onclick="document.getElementById('memberUpdate{{ $member->id }}').submit()" class="pr-2 text-black-50"><i class="fas fa-save"></i></a>
                                <a href="#" data-toggle="dropdown"><i class="fas fa-trash-alt text-danger"></i></a>
                                <div class="dropdown-menu u-padding-16">
                                    <div class="row justify-content-center mb-2">
                                        <div class="col-auto text-danger"><i class="fas fa-exclamation-triangle"></i></div>
                                    </div>
                                    <div class="row">
                                        <div class="col text-center">
                                            從{{ $department->name }}中<br>
                                            刪除{{ $member->name }}成員嗎？<br>
                                        </div>
                                    </div>
                                    <div class="row justify-content-center mt-3">
                                        <div class="col-auto text-center pr-2"><button class="btn btn-danger pl-4 pr-4" onclick="document.getElementById('memberDelete{{ $member->id }}').submit()">刪除</button></div>
                                        <div class="col-auto text-center pl-2"><a class="btn btn-secondary text-white pl-4 pr-4">取消</a></div>
                                    </div>
                                </div>
                            </td>
                        {{-- 一般成員 --}}
                        @elsecan('memberSetting', $department)
                            <td data-th="部門" class="align-middle">{{ $department->name }}</td>
                            <td data-th="職稱" class="align-middle">{{ $member->position }}</td>
                            <td data-th="權限" class="align-middle">{{ $member->role($department)->name }}</td>
                            <td data-th="設定" class="align-middle"></td>
                        @endcan
                        {{-- 無變更權限 --}}
                        @cannot('memberSetting', $department)
                            <td data-th="部門" class="align-middle">{{ $department->name }}</td>
                            <td data-th="職稱" class="align-middle">{{ $member->position }}</td>
                            <td data-th="權限" class="align-middle">{{ $member->role($department)->name }}</td>
                        @endcannot
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div id="dragCard" class="row justify-content-md-center u-mt-16">
                    <div class="alert alert-warning alert-dismissible fade show u-mt-32" role="alert">
                        <strong><i class="fas fa-exclamation-circle pl-2 pr-2"></i></strong>
                        此部門未具有成員 !!
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@foreach($members as $member)
@can('memberSetting', $department)
    <form name="memberUpdate{{ $member->id }}" method="POST" id="memberUpdate{{ $member->id }}" action="{{ route('department.member.update', [$department, $member] ) }}">
        @csrf
        {{ method_field('PATCH') }}
    </form>    
@endcan
@can('memberDelete', [$member, $department])
    <form name="memberDelete{{ $member->id }}" method="POST" id="memberDelete{{ $member->id }}" action="{{ route('department.member.destroy', [$department, $member] ) }}">
        @csrf
        {{ method_field('PATCH') }}
    </form>
@endcan
@endforeach
{{-- 權限說明modal --}}
@include('permission.rolePermission', ['type'=>'部門'])
@endsection
