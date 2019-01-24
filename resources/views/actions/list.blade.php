<div class="container">
    <div class="row m-3">
        @if ( auth()->user() == $owner)
        <div class="col-md-12 font-weight-light">
            <h4>我的 Action</h4>
        </div>
        @else
        <a class="col-md-7" href="{{ $owner->getOKrRoute() }}">
            <img class="avatar u-ml-8 u-mr-8" src="{{ $owner->getAvatar() }}">
            <h4 class="list-inline-item u-ml-8 u-mr-8 text-black-50">{{ $owner->name }}</h4>
        </a>
        @endif
    </div>
    <div class="row m-3">
        <div class="col-md-9 mb-2">
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
                    <option value="finished_at_asc">結算日排序</option>
                    <option value="started_at_asc">起始日排序</option>
                    <option value="priority_asc">優先度排序</option>
                </select>
                <button class="btn btn-primary">搜索</button>
            </form>
        </div>
        <div class="btn-group col mb-2">
            <a href="{{route('user.okr',$owner->id)}}" class="btn btn-light border " >OKR</a>
            <button class="btn btn-success" disabled>Action</button>
        </div>
    </div>
    <div class="col-12">
        <table class="rwd-table table">
            <thead>
                <tr class="bg-primary text-light text-center">
                    <th>
                        優先度
                    </th>
                    <th>
                        結算日
                    </th>
                    <th>
                        來源
                    </th>
                    <th>
                        標題
                    </th>
                    <th>
                        附檔
                    </th>
                    <th>
                        回覆
                    </th>
                    <th>
                        最後更新
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach($actions as $action)
                <tr class="text-center">
                    <td data-th="優先度" class="alert-{{$action->priority()->getResults()->color}}">
                        {{$action->priority()->getResults()->priority}}
                    </td>
                    <td data-th="結算日">
                        {{$action->finished_at}}
                    </td>
                    <td data-th="來源">
                        {{str_split($action->objective->model_type,4)[1]}}
                    </td>
                    <td data-th="標題">
                        <a href="{{ route('actions.show',$action->id) }}">
                            {{$action->title}}
                        </a>
                    </td>
                    <td data-th="附檔">
                        {{count($action->getRelatedFiles())}}
                    </td>
                    <td data-th="回覆">
                        {{$action->comments->count()}}
                    </td>
                    <td data-th="最後更新">
                        {{$action->updated_at}}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        {{ $actions->links() }}
    </div>
</div>
