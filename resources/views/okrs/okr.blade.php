<span class="anchor" id="oid-{{ $okr['objective']->id }}"></span>
<div class="card m-4 okr-card">
    <div class="card-header bg-transparent" style="border-bottom: none;">
        {{-- 卡片時間 --}}
        <div class="row">
            <div class="col-md-12 ml-auto text-right">
                <span class="font-weight-light pl-2 pr-4">{{ $okr['objective']->started_at }} ~ {{ $okr['objective']->finished_at }}</span>
                @can('storeObjective', $owner)
                <a class="close okr-close-btn">
                    <i class="far fa-edit"></i>
                </a>
                @endcan
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
                    <div class="col-md-5 col-sm-5" style="line-height: 32px; font-size: 16px;">{{
                        $okr['objective']->title }}</div>
                    <div class="col-md-7 col-sm-7 row justify-content-end">
                        <div class="pt-2" style="display:inline-block; width:60%;">
                            <div class="progress" style="height:20px;">
                                @if($okr['objective']->getScore()<0) 
                                    <div class="progress-bar bg-danger" role="progressbar" style="width:{{ abs($okr['objective']->getScore()) }}%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">{{ $okr['objective']->getScore() }}%</div>
                                @else
                                    <div class="progress-bar" role="progressbar" style="width:{{ $okr['objective']->getScore() }}%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">{{ $okr['objective']->getScore() }}%</div>
                                @endif
                            </div>
                        </div>
                        @can('storeObjective', $owner)
                        <div class="pt-2 pl-3 pr-2 btn-edit-group" style="display:none;">
                            {{-- 編輯O按鈕 --}}
                            <a href="#" data-toggle="modal" data-target="#objectiveEdit{{ $okr['objective']->id }}" class="pl-2 pr-2 text-info"><i class="fas fa-pencil-alt"></i></a>        
                            {{-- 編輯O modal --}}
                            <div class="modal" id="objectiveEdit{{ $okr['objective']->id }}" tabindex="-1" role="dialog">
                                <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal">
                                                <span>&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="col-12 text-center">
                                                <h4>編輯 Objective</h4>
                                            </div>
                                            <form method="POST" action="{{ route('okr.update',$okr['objective']->id) }}">
                                                @csrf
                                                {{ method_field('PATCH') }}
                                                <div class="form-row">
                                                    <div class="form-group col">
                                                        <label for="objective_title">目標(Objective)</label>
                                                        <input type="text" class="form-control" name="obj_title" id="objective_title" value="{{ $okr['objective']->title }}" required>
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <div class="form-group col">
                                                        <label for="started_at">起始日</label>
                                                        <input autocomplete="off" class="form-control started_at" name="st_date" id="" value="{{ $okr['objective']->started_at }}" required>
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <div class="form-group col">
                                                        <label for="finished_at">完成日</label>
                                                        <input autocomplete="off" class="form-control finished_at" name="fin_date" id="" value="{{ $okr['objective']->finished_at }}" required>
                                                    </div>
                                                </div>
                                                <div class="form-row mb-4 mt-3 justify-content-center">
                                                    <div class="col-6">
                                                        <button class="btn btn-primary btn-sm col-md-12 mt-3" type="submit">修改</button>  
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <a href="#" data-toggle="dropdown" class="text-info"><i class="fas fa-trash-alt"></i></a>
                            <form method="POST" id="deleteKR{{ $okr['objective']->id }}" action="{{ route('objective.destroy', $okr['objective']->id) }}">
                                @csrf
                                {{ method_field('DELETE') }}
                                <div class="dropdown-menu u-padding-16">
                                    <div class="row justify-content-center mb-2">
                                        <div class="col-auto text-danger"><i class="fas fa-exclamation-triangle"></i></div>
                                    </div>
                                    <div class="row">
                                        <div class="col text-center">
                                            刪除Objective後，<br>
                                            將失去Objective下的KR和Action！！<br>
                                            確認要刪除Objective嗎？<br>
                                        </div>
                                    </div>
                                    <div class="row justify-content-center mt-3">
                                        <div class="col-auto text-center pr-2"><button class="btn btn-danger pl-4 pr-4" type="submit">刪除</button></div>
                                        <div class="col-auto text-center pl-2"><a class="btn btn-secondary text-white pl-4 pr-4">取消</a></div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        @endcan
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
                    <span class="col-md-5 col-sm-5 ml-sm-4 pt-2 pr-0" style="border-left: 5px solid {{ $kr->color() }} "> no.{{ $kr->id }} : {{ $kr->title }} </span>
                    <div class="col-md-7 col-sm-7 row justify-content-end value pl-0 pr-sm-5">
                        <span class="pt-2 pr-4">{{ $kr->confidence }} / 10 <i class="fas fa-heart" style="color: #FFB5B1;"></i></span>
                        <div class="pt-3" style="display:inline-block; width:60%;">
                            <div class="progress">
                                @if($kr->accomplishRate()<0) 
                                    <div class="progress-bar bg-danger" data-toggle="tooltip" data-placement="top" title="當前:{{ $kr->current_value }} 目標:{{ $kr->target_value }} 權重:{{ $kr->weight }}"
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
                        @can('storeObjective', $owner)
                        <div class="pt-2 pl-3 pr-2 btn-edit-group" style="display:none;">
                            {{-- 編輯KR按鈕 --}}
                            <a href="#" data-toggle="modal" data-target="#keyresult{{ $kr->id }}" class="pl-2 pr-2 text-info"><i class="fas fa-pencil-alt"></i></a>        
                            {{-- 編輯KR modal --}}
                            <div class="modal" id="keyresult{{ $kr->id }}" tabindex="-1" role="dialog">
                                <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal">
                                                <span>&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="col-12 text-center">
                                                <h4>編輯 KeyResult</h4>
                                            </div>
                                            <form method="POST" action="{{ route('okr.update', $okr['objective']->id) }}">
                                                @csrf
                                                {{ method_field('PATCH') }}
                                                <div class="form-row mt-4">
                                                    <div class="form-group col-12 mt-4">
                                                        <label for="keyresult_title">關鍵指標(KeyResult)</label>
                                                        <input type="text" class="form-control" name="krs_title{{ $kr->id }}" id="keyresult_title" value="{{ $kr->title }}">
                                                    </div>
                                                    <div class="form-group col-12">
                                                        <label for="keyresult_confidence">達成率</label>
                                                        <input type="text" class="js-range-slider kr-slider" id="keyresult_slider" name="krs_now{{ $kr->id }}" value="{{ $kr->current_value }}"
                                                            data-min="{{ $kr->initial_value }}"
                                                            data-max="{{ $kr->target_value }}"
                                                            data-from="{{ $kr->current_value }}"
                                                            data-grid= true 
                                                        />
                                                    </div>
                                                    <div class="form-group col-4">
                                                        <label for="keyresult_initaial">起始值</label>
                                                        <input type="number" class="form-control kr-init" name="krs_init{{ $kr->id }}" id="keyresult_initaial" value="{{ $kr->initial_value }}">
                                                    </div>
                                                    <div class="form-group col-4">
                                                        <label class="text-primary" for="keyresult_target">當前值</label>
                                                        <input type="number" class="form-control kr-now" name="krs_now{{ $kr->id }}" id="keyresult_now" value="{{ $kr->current_value }}">
                                                    </div>
                                                    <div class="form-group col-4">
                                                        <label for="keyresult_target">目標值</label>
                                                        <input type="number" class="form-control kr-target" name="krs_tar{{ $kr->id }}" id="keyresult_target" value="{{ $kr->target_value }}">
                                                    </div>

                                                    <div class="form-group col-6">
                                                        <label for="keyresult_weight">權重</label>
                                                        <input type="text" class="js-range-slider" name="krs_weight{{ $kr->id }}" value="{{ $kr->weight }}"
                                                            data-min="0.1"
                                                            data-max="2"
                                                            data-from="{{ $kr->weight }}"
                                                            data-step="0.1"
                                                            data-grid= true 
                                                        />
                                                    </div>
                                                    <div class="form-group col-6">
                                                        <label for="keyresult_confidence">信心值</label>
                                                        <input type="text" class="js-range-slider" name="krs_conf{{ $kr->id }}" value="{{ $kr->confidence }}"
                                                            data-min="0"
                                                            data-max="10"
                                                            data-from="{{ $kr->confidence }}"
                                                            data-step="1" 
                                                            data-grid= true 
                                                        />
                                                    </div>
                                                </div>
                                                <div class="form-row mb-4 mt-3 justify-content-center">
                                                    <div class="col-6">
                                                        <button class="btn btn-primary btn-sm col-md-12 mt-3" type="submit">修改</button>  
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <a href="#" data-toggle="dropdown" class="text-info"><i class="fas fa-trash-alt"></i></a>
                            <form method="POST" id="deleteKR{{ $kr->id }}" action="{{ route('kr.destroy', $kr->id) }}">
                                @csrf
                                {{ method_field('DELETE') }}
                                <div class="dropdown-menu u-padding-16">
                                    <div class="row justify-content-center mb-2">
                                        <div class="col-auto text-danger"><i class="fas fa-exclamation-triangle"></i></div>
                                    </div>
                                    <div class="row">
                                        <div class="col text-center">
                                            刪除KeyResult後，<br>
                                            將失去KeyResult下的Action！！<br>
                                            確認要刪除KeyResult嗎？<br>
                                        </div>
                                    </div>
                                    <div class="row justify-content-center mt-3">
                                        <div class="col-auto text-center pr-2"><button class="btn btn-danger pl-4 pr-4" type="submit">刪除</button></div>
                                        <div class="col-auto text-center pl-2"><a class="btn btn-secondary text-white pl-4 pr-4">取消</a></div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        @endcan
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @can('storeObjective', $owner)
        <div class="col-md-10 offset-md-2">
            <div class="row">
                @include('okrs.newkr',$okr['objective'])
            </div>
        </div>
        @endcan
    </div>

    <div id="objective{{ $okr['objective']->id }}" class="card-footer text-muted mt-3">
        <div class="row text-center mb-3">
            <div class="col-4 align-self-center pl-0 pr-0">
                <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#Action{{ $okr['objective']->id }}">
                    <i class="fas fa-bullseye"></i> Actions
                </button>
            </div>
            <div class="col-4 align-self-center pl-0 pr-0">
                <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#Msg{{ $okr['objective']->id }}">
                    <i class="far fa-comments"></i> 留言
                </button>
            </div>
            <div class="col-4 align-self-center pl-0 pr-0">
                <button class="btn btn-link historybtn" type="button" data-toggle="collapse" data-target="#History{{ $okr['objective']->id }} " data-oid={{ $okr['objective']->id }}>
                    <i class="fas fa-chart-line"></i> 歷史數據
                </button>
            </div>
        </div>
        {{-- Action內容 --}}
        <div id="Action{{ $okr['objective']->id }}" class="collapse" data-parent="#objective{{ $okr['objective']->id }}">
            <div class="card-body">
                @can('storeObjective', $owner)
                @if($okr['keyresults']->toArray())
                <a class="btn btn-success mb-3 w-100" href="{{ route('actions.create',$okr['objective']->id) }}"><i class="fa fa-plus fa-sm"></i>
                    Action</a>
                @else
                <button type="button" class="btn btn-secondary w-100" disabled><i class="fa fa-lock fa-sm"></i> 請先新增 Key Results
                    (關鍵指標)</button>
                @endif
                @include('okrs.listaction',$okr)
                @endcan
            </div>
        </div>
        {{-- 留言內容 --}}
        <div id="Msg{{ $okr['objective']->id }}" class="collapse comment" data-parent="#objective{{ $okr['objective']->id }}">
            @comments(['model' => $okr['objective']])
            @endcomments
        </div>
        {{-- 歷史圖表內容 --}}
        <div id="History{{ $okr['objective']->id }}" class="collapse" data-parent="#objective{{ $okr['objective']->id }}">
            <div class="row">
                <div class="col-12">
                    {{-- <div class="card card-body" style="position: relative;"> --}}
                        <canvas id="speedChart{{$okr['objective']->id}}"></canvas>
                        <div class="alert alert-info" role="alert" style="display: none;" id="ChartShow{{ $okr['objective']->id }}">
                            此目標尚未有歷史紀錄，故無圖表。
                        </div>
                    {{-- </div> --}}
                </div>
            </div>
        </div>
    </div>
</div>
<br />
