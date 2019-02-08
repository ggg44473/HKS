@section('script')
{{-- Chartjs --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js" charset="utf-8"></script>
<script src="{{ asset('js/chart.js') }}" defer></script>
<script src="{{ asset('js/editbtn.js') }}" defer></script>
@endsection

<div class="container">
    @can('update', $owner)
    <div class="row m-3">
        <div class="col font-weight-light">
            <h4>我的OKR</h4>
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
    <ul class="nav nav-tabs justify-content-end mt-4" id="myTab" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="okr-tab" data-toggle="tab" href="#okr" role="tab" aria-controls="okr"
                aria-selected="false">OKRs</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="action-tab" href="{{ route('user.action',$owner->id) }}">Action</a>
        </li>
    </ul>
    <div class="tab-pane fade show pl-sm-4 pr-sm-4">
        <div class="row m-3 pt-4 justify-content-center">
            <div class="col-auto">
                {{ $pageInfo['link'] }}
            </div>
            <div class="col-auto mb-2">
                <form action="{{ $owner->getOKrRoute() }}" class="form-inline search-form">
                    <input autocomplete="off" class="form-control input-sm" name="st_date" id="filter_started_at" value=""
                        placeholder="起始日">
                    <input autocomplete="off" class="form-control input-sm ml-md-2" name="fin_date" id="filter_finished_at"
                        value="" placeholder="結算日">
                    <select name="order" class="form-control input-sm mr-md-2 ml-md-2">
                        <option value="">排序方式</option>
                        <option value="started_at_asc">起始日由近到遠</option>
                        <option value="started_at_desc">起始日由遠到近</option>
                        <option value="finished_at_asc">完成日由近到遠</option>
                        <option value="finished_at_desc">完成日由遠到近</option>
                        <option value="updated_at_asc">最近更新由近到遠</option>
                        <option value="updated_at_desc">最近更新由遠到近</option>
                    </select>
                    <button class="btn btn-primary">搜索</button>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="alert alert-info text-center" role="alert">
    共有<strong> {{$pageInfo['totalItem']}} </strong>筆目標 ( Objectives )
    @if($st_date!=null || $fin_date!=null)
    <br />搜尋時間範圍 : {{$st_date}} ~ {{$fin_date}}
    @endif
</div>
<div class="container">
    <div class="tab-pane fade show pl-sm-4 pr-sm-4">
        @foreach($okrs as $okr)
            @include('okrs.okr', ['okr' => $okr])
        @endforeach
    </div>
</div>
@can('storeObjective', $owner)
    {{-- 新增O按鈕 --}}
    <a href="#" data-toggle="modal" data-target="#objective" class="newObjective"><img src="{{ asset('img/icon/add/lightgreen.svg') }}" alt=""></a>        
    {{-- 新增O modal --}}
    <div class="modal {{ count($errors) == 0 ? 'fade' : '' }}" id="objective" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                @include('okrs.create', ['route'=>$routeObjectiveStore])
            </div>
        </div>
    </div>
@endcan
