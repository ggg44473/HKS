@extends('layouts.master')
@section('title','邀請成員')
@section('content')
<div class="container">
    <div class="row m-3">
        <div class="col-md-7 font-weight-light">
            <h4>專案成員管理</h4>
        </div>
    </div>
    <div class="mb-4">
        <form action="{{ route('project.member.invite', $project) }}" method="post">
            @csrf
            <search-component api={{ route('project.member.search', $project) }}></search-component>
        </form>
    </div>
    <div class="row justify-content-md-center">
        <div class="col-sm-10">專案成員
            <table class="rwd-table table table-hover">
                <thead>
                    <tr class="bg-primary text-light text-center">
                        <th>頭像</th>
                        <th>姓名</th>
                        <th>信箱</th>
                        @if (auth()->user()->company_id)
                            <th>部門</th>
                            <th>職稱</th>
                        @endif
                        <th>設定</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($project->users as $member)
                    <tr class="text-center">
                        <td data-th="頭像">
                            <a href="{{ route('user.okr', $member->id) }}" class="u-ml-8 u-mr-8">
                                <img src="{{ $member->getAvatar() }}" alt="" class="avatar-sm text-center bg-white">
                            </a>
                        </td>
                        <td data-th="姓名">{{ $member->name }}</td>
                        <td data-th="信箱">{{ $member->email }}</td>
                        @if (auth()->user()->company_id)
                            <td data-th="部門">{{ $member->department? $member->department->name: $member->company->name }}</td>
                            <td data-th="職稱">{{ $member->position? $member->position:'-' }}</td>
                        @endif
                        <td data-th="設定">
                            <a href="#" onclick="document.getElementById('memberDelete{{ $member->id }}').submit()"><i
                                    class="fas fa-trash-alt text-danger"></i></a href="#">
                            <form name="memberDelete{{ $member->id }}" method="POST" id="memberDelete{{ $member->id }}"
                                action="{{ route('project.member.destroy', [$project, $member]) }}">
                                @csrf
                                {{ method_field('PATCH') }}
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
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
                        <th>設定</th>
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
                        <td data-th="部門">{{ $member->department? $member->department->name: $member->company->name }}</td>
                        <td data-th="職稱">{{ $member->position? $member->position:'-' }}</td>
                        <td data-th="設定">
                            <a href="#" onclick="document.getElementById('memberDelete{{ $member->id }}').submit()"><i
                                    class="fas fa-trash-alt text-danger"></i></a href="#">
                            <form name="memberDelete{{ $member->id }}" method="POST" id="memberDelete{{ $member->id }}"
                                action="{{ route('project.member.invite.destroy', [$project, $member]) }}">
                                @csrf
                                {{ method_field('PATCH') }}
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
