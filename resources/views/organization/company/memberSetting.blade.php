@extends('layouts.master')
@section('title','邀請成員')
@section('content')
<div class="container">
    <div class="row m-3">
        <div class="col-md-7 font-weight-light">
            <h4>公司成員管理</h4>
        </div>
    </div>
    <div class="mb-4">
        <form action="{{ route('company.member.invite', $company) }}" method="post">
            @csrf
            <search-component api={{ route('noncompany.member.search') }}></search-component>
        </form>
    </div>
    <div class="row justify-content-md-center">
        <div class="col-sm-10">公司成員
            <form name="formUpdate" action="{{ route('company.member.update') }}" method="post">
                @csrf
                {{ method_field('PATCH') }}
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
                        <tr class="text-center">
                            <td data-th="頭像">
                                <a href="{{ route('user.okr', auth()->user()->id) }}" class="u-ml-8 u-mr-8">
                                    <img src="{{ auth()->user()->getAvatar() }}" alt="" class="avatar-sm text-center bg-white">
                                </a>
                            </td>
                            <td data-th="姓名">{{ auth()->user()->name }}</td>
                            <td data-th="信箱">{{ auth()->user()->email }}</td>
                            <td data-th="部門">
                                <select name="department{{ auth()->user()->id }}" id="department{{ auth()->user()->id }}"
                                    class="form-control">
                                    <option value=""></option>
                                    @foreach ($departments as $department)
                                    @if ($department == auth()->user()->department)
                                    <option value="{{ $department->id }}" selected>{{ $department->name }}</option>
                                    @else
                                    <option value="{{ $department->id }}">{{ $department->name }}</option>
                                    @endif
                                    @endforeach
                                </select>
                            </td>
                            <td data-th="職稱">
                                <input name="position{{ auth()->user()->id }}" type="text" class="form-control" value="{{ auth()->user()->position }}">
                            </td>
                            <td data-th="設定">
                            </td>
                        </tr>
                        @foreach($members as $member)
                        <tr class="text-center">
                            <td data-th="頭像">
                                <a href="{{ route('user.okr', $member->id) }}" class="u-ml-8 u-mr-8">
                                    <img src="{{ $member->getAvatar() }}" alt="" class="avatar-sm text-center bg-white">
                                </a>
                            </td>
                            <td data-th="姓名">{{ $member->name }}</td>
                            <td data-th="信箱">{{ $member->email }}</td>
                            <td data-th="部門">
                                <select name="department{{ $member->id }}" id="department{{ $member->id }}" class="form-control">
                                    <option value=""></option>
                                    @foreach ($departments as $department)
                                    @if ($department->id == $member->department_id)
                                    <option value="{{ $department->id }}" selected>{{ $department->name }}</option>
                                    @else
                                    <option value="{{ $department->id }}">{{ $department->name }}</option>
                                    @endif
                                    @endforeach
                                </select>
                            </td>
                            <td data-th="職稱">
                                <input name="position{{ $member->id }}" type="text" class="form-control" value="{{ $member->position }}">
                            </td>
                            <td data-th="設定">
                                <a href="#" onclick="document.getElementById('memberDelete{{ $member->id }}').submit()">
                                    <i class="fas fa-trash-alt text-danger"></i>
                                </a href="#">
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="row u-mb-32 justify-content-md-center">
                    <div class="col-sm-10 text-right">
                        <button type="submit" class="btn btn-primary">變更</button>
                    </div>
                </div>
            </form>
            @foreach($members as $member)
            <form name="memberDelete{{ $member->id }}" method="POST" id="memberDelete{{ $member->id }}" action="{{ route('company.member.destroy', $member ) }}">
                @csrf
                {{ method_field('PATCH') }}
            </form>
            @endforeach
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
                        <th>設定</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($company->getInvitationUsers() as $member)
                    <tr class="text-center">
                        <td data-th="頭像">
                            <a href="{{ route('user.okr', $member->id) }}" class="u-ml-8 u-mr-8">
                                <img src="{{ $member->getAvatar() }}" alt="" class="avatar-sm text-center bg-white">
                            </a>
                        </td>
                        <td data-th="姓名">{{ $member->name }}</td>
                        <td data-th="信箱">{{ $member->email }}</td>
                        <td data-th="設定">
                            <a href="#" onclick="document.getElementById('memberDelete{{ $member->id }}').submit()">
                                <i class="fas fa-trash-alt text-danger"></i>
                            </a href="#">
                            <form name="memberDelete{{ $member->id }}" method="POST" id="memberDelete{{ $member->id }}"
                                action="{{ route('company.member.invite.destroy', [$company, $member]) }}">
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
