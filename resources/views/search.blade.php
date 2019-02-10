@extends('layouts.master')
@section('title','搜尋結果')
@section('content')
<div class="container">
    @if( $projectsCount == 0 && $usersCount == 0 )
    <div class="alert alert-warning alert-dismissible fade show u-mt-32 text-center" role="alert">
        <strong><i class="fas fa-exclamation-circle pl-2 pr-2"></i></strong>
        查無任何資料 !!
    </div>
    @endif

    @if($usersCount)
    <div class="col-12">
        <h4>同事</h4>
        <table class="rwd-table table table-hover">
            <thead>
                <tr class="bg-primary text-light text-center">
                    <th>
                        頭像
                    </th>
                    <th>
                        姓名
                    </th>
                    <th>
                        部門
                    </th>
                    <th>
                        職稱
                    </th>
                    <th>
                        被追蹤
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach($members as $member)
                <tr class="text-center">
                    <td data-th="頭像" class="align-middle">
                        <a href="{{ route('user.okr', $member->id) }}" class="u-ml-8 u-mr-8">
                            <img src="{{ $member->getAvatar() }}" alt="" class="avatar-sm text-center bg-white">
                        </a>
                    </td>
                    <td data-th="姓名" class="align-middle">
                        {{$member->name}}
                    </td>
                    <td data-th="部門" class="align-middle">
                        @if($member->department)
                        {{$member->department->name}}
                        @endif
                    </td>
                    <td data-th="職稱" class="align-middle">
                        {{$member->position}}
                    </td>
                    <td data-th="被追蹤" class="align-middle">
                        {{$member->follower->count()}}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif

    @if($projectsCount)
    <div class="col-12">
        <h4>專案</h4>
        <table class="rwd-table table table-hover">
            <thead>
                <tr class="bg-primary text-light text-center">
                    <th>
                        專案
                    </th>
                    <th>
                        簡述
                    </th>
                    <th>
                        狀態
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach($projects as $project)
                <tr class="text-center">
                    <td data-th="專案">
                        <a href="{{ route('project.okr', $project->id) }}" class="u-ml-8 u-mr-8">
                            <img src="{{ $project->getAvatar() }}" alt="" class="avatar-sm text-center bg-white">
                        </a>
                        {{$project->name}}
                    </td>
                    <td data-th="簡述">
                        {{$project->description}}
                    </td>
                    <td data-th="狀態">
                        {{$project->isdone ? '完成' : '未完成'}}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif
</div>
@endsection
