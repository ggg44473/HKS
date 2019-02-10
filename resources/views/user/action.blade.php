@extends('layouts.master')
@section('title','個人Action')
@section('content')
<div class="container">
    {{-- action指派訊息 --}}
    @foreach ($invitations as $invitation)
        @include('actions.invitation')
    @endforeach
    @can('update', $owner)
    <div class="row m-3">
        <div class="col font-weight-light">
            <h4>我的Action</h4>
        </div>
    </div>
    @endcan
    @cannot('update', $owner)
    <div class="row">
        <div class="col align-self-end text-right">
            @if ($owner->following())
            <a href="{{ route('follow.cancel', [get_class($owner), $owner]) }}" class="text-warning">
                <i class="fas fa-star" style="font-size: 24px;"></i>
            </a>
            @else
            <a href="{{ route('follow', [get_class($owner), $owner]) }}" class="text-warning">
                <i class="far fa-star" style="font-size: 24px;"></i>
            </a>
            @endif
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-10 col">
            <div class="row">
                <div class="col-auto">
                    <a class="u-ml-8" href="{{ $owner->getOKrRoute() }}">
                        <img src="{{ $owner->getAvatar() }}" alt="" class="avatar text-center bg-white">
                    </a>
                </div>
                <div class="col align-self-center text-truncate">
                    <a href="{{ $owner->getOKrRoute() }}">
                        <span class="text-black-50 text-truncate" style="line-height:30px;">{{ isset($owner->department)?$owner->department->name:$owner->company->name }}</span>
                        <span class="text-black-50 text-truncate pl-4" style="line-height:30px;">{{ $owner->position }}</span>
                        <h5 class="font-weight-bold text-black-50 text-truncate">{{ $owner->name }}</h5>
                        <p class="mb-0 text-black-50 text-truncate">{{ $owner->description }}</p>
                    </a>
                </div>
            </div>
        </div>
    </div>
    @endcannot
    {{-- okrs/action換頁標籤 --}}
    <ul class="nav nav-tabs justify-content-end" id="myTab" role="tablist">
        <li class="nav-item">
            <a class="nav-link" id="okr-tab" href="{{route('user.okr',$owner->id)}}">OKRs</a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" id="action-tab" href="{{ route('user.action',$owner->id) }}">Action</a>
        </li>
    </ul>
    <div class="tab-pane fade show pl-sm-4 pr-sm-4">
        {{-- 搜尋 --}}
        <div class="row m-3 pt-4 justify-content-center">
            <div class="col-auto mb-2">
                <form action="{{route('user.action',$owner->id)}}" class="form-inline search-form">
                    <select name="isdone" class="form-control input-sm mr-2 ml-2">
                        <option value="false">未完成</option>
                        <option value="true">完成</option>
                    </select>
                    <select name="state" class="form-control input-sm mr-2 ml-2">
                        <option value="now">執行中</option>
                        <option value="back">過去</option>
                        <option value="future">未來</option>
                    </select>
                    <select name="order" class="form-control input-sm mr-2 ml-2">
                        <option value="finished_at_asc">期限排序</option>
                        <option value="started_at_asc">起始日排序</option>
                        <option value="priority_asc">優先度排序</option>
                    </select>
                    <button class="btn btn-primary">搜索</button>
                </form>
            </div>
        </div>
        {{-- action列表 --}}
        <div class="row">
            <div class="col-12">
                <table class="rwd-table table table-hover">
                    <thead>
                        <tr class="bg-primary text-light text-center">
                            <th>完成</th>
                            <th>優先度</th>
                            <th>期限</th>
                            <th>來源</th>
                            <th>標題</th>
                            <th>附檔</th>
                            <th>回覆</th>
                            <th>最後更新</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($actions as $action)
                        <tr class="text-center">
                            <td data-th="完成" class="align-middle">
                                <form action="{{ route('actions.done', $action->id) }}" method="post" id="doneAct{{ $action->id }}">
                                    @csrf
                                    <input type="checkbox" name="" id="" {{ $action->isdone? 'checked="checked"':'' }}  onclick="document.getElementById('doneAct{{ $action->id }}').submit()">
                                </form>
                            </td>
                            <td data-th="優先度" class="alert-{{$action->priority()->getResults()->color}} align-middle">
                                {{$action->priority()->getResults()->priority}}
                            </td>
                            <td data-th="期限" class="align-middle">
                                {{$action->finished_at}}
                            </td>
                            <td data-th="來源" class="align-middle">
                                {{str_split($action->objective->model_type,4)[1]}}
                            </td>
                            <td data-th="標題" class="align-middle">
                                <a href="{{ route('actions.show',$action->id) }}">
                                    {{$action->title}}
                                </a>
                            </td>
                            <td data-th="附檔" class="align-middle">
                                {{count($action->getRelatedFiles())}}
                            </td>
                            <td data-th="回覆" class="align-middle">
                                {{$action->comments->count()}}
                            </td>
                            <td data-th="最後更新" class="align-middle">
                                {{$action->updated_at}}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $actions->links() }}
            </div>
        </div>
    </div>
</div>
@endsection