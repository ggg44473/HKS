@extends('layouts.master')
@section('script')
<script src="{{ asset('js/tooltip.js') }}" defer></script>
<script src="{{ asset('js/circle-progress.min.js') }}" defer></script>
<script src="{{ asset('js/circleProgress.js') }}" defer></script>
@endsection
@section('title','專案成員')
@section('content')
<div class="container">
    {{-- 專案概述 --}}
    @include('project.show')
    {{-- 分頁 --}}
    <ul class="nav nav-tabs justify-content-center" id="myTab" role="tablist">
        <li class="nav-item">
            <a class="nav-link" id="okr-tab" href="{{ route('project.okr', $project) }}">OKRs</a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" id="member-tab" href="{{ route('project.member', $project) }}">成員</a>
        </li>
    </ul>
    <div class="row justify-content-md-center">
        <div class="col-sm-10 mt-4">
            @if (count($project->users))
                {{-- 篩選 --}}
                <div class="float-right mb-2">
                    <form action="{{route('project.member', $project)}}" class="form-inline search-form">
                        <select name="order" class="form-control input-sm mr-2 ml-2">
                            <option value="name_asc">姓名排序</option>
                            <option value="email_asc">信箱排序</option>
                            <option value="position_asc">職稱排序</option>
                        </select>
                        <button type="submit" value="Submit" class="btn btn-primary">搜索</button>
                    </form>
                </div>
                {{ $members->links() }}
                {{-- 成員表 --}}
                <table class="rwd-table table table-hover">
                    <thead>
                        <tr class="bg-primary text-light text-center">
                            <th>追蹤</th>
                            <th>姓名</th>
                            <th>部門</th>
                            <th>職稱</th>
                            <th>權限</th>
                            @can('memberSetting', $project)
                                <th>設定</th>                              
                            @endcan
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($members as $member)
                        <tr class="text-center">
                            <td data-th="追蹤">
                                @if ($member->following())
                                <a href="{{ route('follow.cancel', [get_class($member), $member]) }}" class="text-warning">
                                    <i class="fas fa-star" style="font-size: 24px;"></i>
                                </a>
                                @else
                                <a href="{{ route('follow', [get_class($member), $member]) }}" class="text-warning">
                                    <i class="far fa-star" style="font-size: 24px;"></i>
                                </a>
                                @endif
                            </td>
                            <td data-th="姓名" class="text-left">
                                <a href="{{ route('user.okr', $member->id) }}" class="text-black-50">
                                    <img src="{{ $member->getAvatar() }}" alt="" class="avatar-sm text-center bg-white">
                                    {{ $member->name }}
                                </a>
                            </td>
                            <td data-th="部門">{{ $member->department? $member->department->name:'-' }}</td>
                            <td data-th="職稱">{{ $member->position }}</td>
                            {{-- 有變更權限 --}}
                            {{-- 權限最高，設定自己 --}}
                            @can('adminCange', [$member, $project])
                                <td data-th="權限"><a href="#" data-toggle="modal" data-target="#changAdmin" class="tooltipBtn" data-placement="top" title="變更擁有者">{{ $member->role($project)->name }}</a></td>
                                <td data-th="設定">
                                    <a href="#"  onclick="document.getElementById('memberUpdate{{ $member->id }}').submit()" class="pr-2 text-black-50"><i class="fas fa-save"></i></a>
                                    <a href="#" data-toggle="modal" data-target="#deleteAdmin" class="tooltipBtn" data-placement="top" title="變更擁有者後刪除"><i class="fas fa-trash-alt text-danger"></i></a>
                                </td>
                            {{-- 管理者，可以設定比自己低的人 --}}
                            @elsecan('permissionCange', [$member, $project])
                                <td data-th="權限">
                                    <select name="permission" id="permission" class="form-control" form="memberUpdate{{ $member->id }}">
                                        <option value="2">管理者</option>
                                        <option value="3" {{ $member->role($project)->id == 3?'selected':''}}>編輯</option>
                                        <option value="4" {{ $member->role($project)->id == 4?'selected':''}}>成員</option>
                                    </select>
                                </td>
                                <td data-th="設定">
                                    <a href="#"  onclick="document.getElementById('memberUpdate{{ $member->id }}').submit()" class="pr-2 text-black-50"><i class="fas fa-save"></i></a>
                                    <a href="#" data-toggle="dropdown"><i class="fas fa-trash-alt text-danger"></i></a>
                                    <div class="dropdown-menu u-padding-16">
                                        <div class="row justify-content-center mb-2">
                                            <div class="col-auto text-danger"><i class="fas fa-exclamation-triangle"></i></div>
                                        </div>
                                        <div class="row">
                                            <div class="col text-center">
                                                從{{ $project->name }}中<br>
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
                            @elsecan('memberSetting', $project)
                                <td data-th="權限">{{ $member->role($project)->name }}</td>
                                <td data-th="設定"></td>
                            @endcan
                            {{-- 無變更權限 --}}
                            @cannot('memberSetting', $project)
                                <td data-th="權限">{{ $member->role($project)->name }}</td>
                            @endcannot
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div id="dragCard" class="row justify-content-md-center u-mt-16">
                    <div class="alert alert-warning alert-dismissible fade show u-mt-32" role="alert">
                        <strong><i class="fas fa-exclamation-circle pl-2 pr-2"></i></strong>
                        此專案未具有成員 !!
                    </div>
                </div>
            @endif
        </div>
    </div>
    @if (count($project->invitation))
        {{-- 邀請表 --}}
        <div class="row justify-content-md-center">
            <div class="col-sm-10">邀請中成員
                <table class="rwd-table table table-hover">
                    <thead>
                        <tr class="bg-primary text-light text-center">
                            <th>頭像</th>
                            <th>姓名</th>
                            <th>信箱</th>
                            <th>部門</th>
                            <th>職稱</th>
                            @can('memberSetting', $project)
                            <th>設定</th>                                
                            @endcan
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($project->getInvitationUsers() as $member)
                        <tr class="text-center">
                            <td data-th="頭像">
                                <a href="{{ route('user.okr', $member->id) }}" class="u-ml-8 u-mr-8">
                                    <img src="{{ $member->getAvatar() }}" alt="" class="avatar-sm text-center bg-white">
                                </a>
                            </td>
                            <td data-th="姓名">{{ $member->name }}</td>
                            <td data-th="信箱">{{ $member->email }}</td>
                            <td data-th="部門">{{ $member->department? $member->department->name: '-' }}</td>
                            <td data-th="職稱">{{ $member->position? $member->position:'-' }}</td>
                            @can('memberSetting', $project)                            
                            <td data-th="設定">
                                <a href="#" onclick="document.getElementById('memberDelete{{ $member->id }}').submit()"><i
                                        class="fas fa-trash-alt text-danger"></i></a href="#">
                                <form name="memberDelete{{ $member->id }}" method="POST" id="memberDelete{{ $member->id }}"
                                    action="{{ route('project.member.invite.destroy', [$project, $member]) }}">
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
@can('memberSetting', $project)
    <form name="memberUpdate{{ $member->id }}" method="POST" id="memberUpdate{{ $member->id }}" action="{{ route('project.member.update', [$project, $member] ) }}">
        @csrf
        {{ method_field('PATCH') }}
    </form>    
@endcan
@can('memberDelete', [$member, $project])
    <form name="memberDelete{{ $member->id }}" method="POST" id="memberDelete{{ $member->id }}" action="{{ route('project.member.destroy', [$project, $member] ) }}">
        @csrf
        {{ method_field('PATCH') }}
    </form>
@endcan
@endforeach
@can('adminCange', [auth()->user(), $project])
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
                <form action="{{ route('project.admin.change', $project) }}" method="post">
                    @csrf
                    {{ method_field('PATCH') }}
                    <div class="row pb-4">
                        <div class="col-12">
                            <label class="mb-0">專案｜{{ $project->name }}</label>
                            <select name="project" id="project" class="form-control">
                                @foreach ($project->users as $user)
                                    @if ($user->id!=auth()->user()->id)
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endif
                                @endforeach
                            </select>
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
                <form action="{{ route('project.admin.delete', $project) }}" method="post">
                    @csrf
                    {{ method_field('PATCH') }}
                    <div class="row pb-4">
                        <div class="col-12">
                            <label class="mb-0">專案｜{{ $project->name }}</label>
                            <select name="project" id="project" class="form-control">
                                @foreach ($project->users as $user)
                                    @if ($user->id!=auth()->user()->id)
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
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
@endsection
