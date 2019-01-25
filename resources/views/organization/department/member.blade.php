@extends('layouts.master')
@section('script')
<script src="{{ asset('js/tooltip.js') }}" defer></script>
<script src="{{ asset('js/circle-progress.js') }}" defer></script>
<script src="{{ asset('js/circleProgress.js') }}" defer></script>
@endsection
@section('title','組織成員')
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
                <table class="rwd-table table">
                    <thead>
                        <tr class="bg-primary text-light text-center">
                            <th>追蹤</th>
                            <th>頭像</th>
                            <th>姓名</th>
                            <th>信箱</th>
                            <th>部門</th>
                            <th>職稱</th>
                            <th>權限</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($department->users as $member)
                        <tr class="text-center">
                            <td data-th="追蹤">
                                @if ($member->follower->first())
                                <a href="{{ route('follow.cancel', [get_class($member), $member]) }}" class="text-warning">
                                    <i class="fas fa-star" style="font-size: 24px;"></i>
                                </a>
                                @else
                                <a href="{{ route('follow', [get_class($member), $member]) }}" class="text-warning">
                                    <i class="far fa-star" style="font-size: 24px;"></i>
                                </a>
                                @endif
                            </td>
                            <td data-th="頭像">
                                <a href="{{ route('user.okr', $member->id) }}" class="u-ml-8 u-mr-8">
                                    <img src="{{ $member->getAvatar() }}" alt="" class="avatar-sm text-center bg-white">
                                </a>
                            </td>
                            <td data-th="姓名">{{ $member->name }}</td>
                            <td data-th="信箱">{{ $member->email }}</td>
                            <td data-th="部門">{{ $member->department? $member->department->name:'-' }}</td>
                            <td data-th="職稱">{{ $member->position }}</td>
                            <td data-th="權限">一般成員</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div id="departmentCard" class="row justify-content-md-center u-mt-16">
                    <div class="alert alert-warning alert-dismissible fade show u-mt-32" role="alert">
                        <strong><i class="fas fa-exclamation-circle pl-2 pr-2"></i></strong>
                        此部門未具有成員 !!
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
