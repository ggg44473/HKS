<div id="oid-{{ $okr['objective']->id }}" class="card shadow-sm m-4 okr-card">
    <div class="card-header bg-transparent" style="border-bottom: none;">
        {{-- 卡片時間 --}}
        <div class="row">
            <div class="col-md-12 ml-auto text-right">
                <span class="font-weight-light pl-2 pr-4">{{ $okr['objective']->started_at }}~{{ $okr['objective']->finished_at }}</span>
                @if (auth()->user()->id == $admin)
                <a class="close okr-close-btn">
                    <i class="far fa-edit"></i>
                </a>
                @endif
            </div>
        </div>
    </div>
    <div class="card-body">

        {{-- 卡片目標 --}}
        <div class="row align-items-center">
            <div class="col-md-2 font-weight-bold text-md-right pr-0">
                <h4 style="font-size:18px;">Objective</h4>
            </div>
            <div class="col-md-10">
                <div class="row">
                    <div class="col-md-5 col-sm-5" style="line-height: 32px; font-size: 16px;">{{ $okr['objective']->title }}</div>
                    <div class="col-md-7 col-sm-7 row justify-content-end">
                        <div class="pt-2" style="display:inline-block; width:60%;">
                            <div class="progress" style="height:20px;">
                                @if($okr['objective']->getScore()<0) 
                                <div class="progress-bar bg-danger" role="progressbar"
                                    style="width:{{ abs($okr['objective']->getScore()) }}%;" aria-valuenow="25"
                                    aria-valuemin="0" aria-valuemax="100">{{ $okr['objective']->getScore() }}%
                                </div>
                                @else
                                <div class="progress-bar" role="progressbar" style="width:{{ $okr['objective']->getScore() }}%;"
                                    aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">{{ $okr['objective']->getScore() }}%
                                </div>
                                @endif
                            </div>
                        </div>
                        <div class="pt-2 pl-3 pr-2 btn-edit-group" style="display:none;">
                            <a class="pl-2 pr-2 text-success" href="{{ route('okr.edit', $okr['objective']->id) }}"><i class="fas fa-pencil-alt"></i></a>
                            <a class="pl-2 pr-2 text-danger" href="#" onclick="document.getElementById('deleteKR{{ $okr['objective']->id }}').submit()"><i
                                    class="fas fa-trash"></i></a>
                            <form method="POST" id="deleteKR{{ $okr['objective']->id }}" action="{{ route('objective.destroy', $okr['objective']->id) }}">
                                @csrf
                                {{ method_field('DELETE') }}
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <hr class="u-mb-16">
        {{-- 卡片指標 --}}
        <div class="row">
            <div class="col-md-2 font-weight-bold text-md-right align-self-center pr-0">
                <h4 style="font-size:18px;">Key Results</h4>
            </div>
            <div class="col-md-10">
                @foreach ($okr['keyresults'] as $kr)
                <div class="row pt-2 kr">
                    <span class="col-md-5 col-sm-5 ml-sm-4 pt-2" style="border-left: 5px solid {{ $kr->color() }} "> no.{{
                        $kr->id }} : {{
                        $kr->title }} </span>
                    <div class="col-md-7 col-sm-7 row justify-content-end value">
                        <span class="pt-2 pr-4">{{ $kr->confidence }} / 10 <i class="fas fa-heart" style="color: #FFB5B1;"></i></span>
                        <div class="pt-3" style="display:inline-block; width:60%;">
                            <div class="progress">
                                @if($kr->accomplishRate()<0) <div class="progress-bar bg-danger" data-toggle="tooltip"
                                    data-placement="top" title="當前:{{ $kr->current_value }} 目標:{{ $kr->target_value }} 權重:{{ $kr->weight }}"
                                    role="progressbar" style="width:{{ abs($kr->accomplishRate()) }}%" aria-valuenow="25">
                                    {{ $kr->accomplishRate() }}%
                            </div>
                            @else
                            <div class="progress-bar" data-toggle="tooltip" data-placement="top" title="當前:{{ $kr->current_value }} 目標:{{ $kr->target_value }} 權重:{{ $kr->weight }}"
                                role="progressbar" style="width:{{ $kr->accomplishRate() }}%" aria-valuenow="25">
                                {{ $kr->accomplishRate() }}%
                            </div>
                            @endif
                        </div>
                    </div>
                    <div class="pt-2 pl-3 pr-2 btn-edit-group" style="display:none;">
                        <a class="pl-2 pr-2 text-success" href="{{ route('okr.edit', $okr['objective']->id) }}"><i class="fas fa-pencil-alt"></i></a>
                        <a class="pl-2 pr-2 text-danger" href="#" onclick="document.getElementById('deleteKR{{ $kr->id }}').submit()"><i
                                class="fas fa-trash"></i></a>
                        <form method="POST" id="deleteKR{{ $kr->id }}" action="{{ route('kr.destroy', $kr->id) }}">
                            @csrf
                            {{ method_field('DELETE') }}
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @if (auth()->user()->id == $admin)
    <div class="col-md-10 offset-md-2">
        <div class="row">
            @include('okrs.newkr',$okr['objective'])
        </div>
    </div>
    @endif
</div>

<div class="card-footer text-muted mt-3">
    <div class="row text-center mb-3">
        <div class="col-sm-4 align-self-center">
            <button class="btn btn-outline-primary border-0" type="button" data-toggle="collapse" data-target="#Action{{ $okr['objective']->id }}"
                aria-expanded="false" aria-controls="Action">
                <i class="fas fa-bullseye"></i> 查看 Actions
            </button>
        </div>
        <div class="col-sm-4 align-self-center">
            <button class="btn btn-outline-primary border-0" type="button" data-toggle="collapse" data-target="#Msg{{ $okr['objective']->id }}"
                aria-expanded="false" aria-controls="Msg">
                <i class="far fa-comments"></i> 查看留言
            </button>
        </div>
        <div class="col-sm-4 align-self-center">
            <button class="btn btn-outline-primary border-0" type="button" data-toggle="collapse" data-target="#History{{ $okr['objective']->id }}"
                aria-expanded="false" aria-controls="History">
                <i class="fas fa-chart-line"></i> 歷史數據
            </button>
        </div>
    </div>

    <div class="collapse" id="Action{{ $okr['objective']->id }}">
        <div class="card card-body">
            @if($okr['keyresults']->toArray())
            <a class="btn btn-success mb-3" href="{{ route('actions.create',$okr['objective']->id) }}"><i class="fa fa-plus fa-sm"></i>
                Action</a>
            @else
            <button type="button" class="btn btn-secondary" disabled><i class="fa fa-lock fa-sm"></i> 請先新增 Key Results
                (關鍵指標)</button>
            @endif
            @include('okrs.listaction',$okr)
        </div>
    </div>
    <div class="collapse" id="Msg{{ $okr['objective']->id }}">
        <div class="card card-body">
            @comments(['model' => $okr['objective']])
            @endcomments
        </div>
    </div>
    <div class="collapse" id="History{{ $okr['objective']->id }}">
        <div class="card card-body">
            {!! $okr['chart']->container() !!}
            {!! $okr['chart']->script() !!}
        </div>
    </div>
</div>
</div>
<br />
