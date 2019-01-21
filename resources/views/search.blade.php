@extends('layouts.master')
@section('title','搜尋結果')
@section('content')
<div class="container">
    @if(!($departments&&$members))
    <h4>查無資料</h4>
    @endif
    @if($departments)
    <div class="col-12">
        <h4>部門</h4>
        <table class="rwd-table table">
            <thead>
                <tr class="bg-primary text-light text-center">
                    <th>
                        頭像
                    </th>
                    <th>
                        部門
                    </th>
                    <th>
                        描述
                    </th>
                    <th>
                        歸屬
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach($departments as $department)
                <tr class="text-center">
                    <td data-th="頭像">
                        <a href="{{ route('department.okr', $department->id) }}" class="u-ml-8 u-mr-8">
                            <img src="{{ $department->getAvatar() }}" alt="" class="avatar-sm text-center bg-white">
                        </a>
                    </td>
                    <td data-th="部門">
                        {{$department->name}}
                    </td>
                    <td data-th="描述">
                        {{$department->description}}
                    </td>
                    <td data-th="歸屬">
                        @if($department->parent)
                        {{$department->parent->name}}
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif

    @if($members)
    <div class="col-12">
        <h4>同事</h4>
        <table class="rwd-table table ">
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
                    <td data-th="姓名">
                        {{$member->name}}
                    </td>
                    <td data-th="部門">
                        @if($member->department)
                        {{$member->department->name}}
                        @endif
                    </td>
                    <td data-th="職稱">
                        {{$member->position}}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif
</div>
@endsection
