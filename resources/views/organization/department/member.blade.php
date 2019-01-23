@extends('layouts.master')
@section('title','邀請成員')
@section('content')
<div class="container">
    <div class="row m-3">
        <div class="col-md-7 font-weight-light">
            <h4>部門成員管理</h4>
        </div>
    </div>
    <div class="mb-4">
        <form action="{{ route('department.member.store', $department) }}" method="post">
            @csrf
            <search-component api={{ route('department.member.search', $department->company) }}></search-component>
        </form>
    </div>
    <div class="row justify-content-md-center">
        <div class="col-sm-10">部門成員
            <form name="formUpdate" action="{{ route('department.member.update', $department) }}" method="post">
                @csrf
                {{ method_field('PATCH') }}
                <table class="rwd-table table">
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
                                    <option value="{{ $department->id }}">{{ $department->name }}</option>
                                    @foreach ($department->children as $child)
                                    @if ($child->id == $member->child_id)
                                    <option value="{{ $child->id }}" selected>{{ $child->name }}</option>
                                    @else
                                    <option value="{{ $child->id }}">{{ $child->name }}</option>
                                    @endif
                                    @endforeach
                                </select>
                            </td>
                            <td data-th="職稱">
                                <input name="position{{ $member->id }}" type="text" class="form-control" value="{{ $member->position }}">
                            </td>
                            <td data-th="設定">
                                <a href="#" onclick="document.getElementById('memberDelete{{ $member->id }}').submit()"><i
                                        class="fas fa-trash-alt text-danger"></i></a href="#">
                                <form name="memberDelete{{ $member->id }}" method="POST" id="memberDelete{{ $member->id }}"
                                    action="{{ route('department.member.destroy', [$department, $member]) }}">
                                    @csrf
                                    {{ method_field('PATCH') }}
                                </form>
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
        </div>
    </div>
</div>
@endsection
