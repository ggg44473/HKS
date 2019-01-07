@foreach($okrs as $okr)
    <div class="card shadow-sm p-2">
        <div class="row">
            <div class="col-md-7 text-right"></div>
            <div class="col-md-2 font-weight-light">起始日:{{ $okr['objective']->started_at }}</div>
            <div class="col-md-2 font-weight-light">結算日:{{ $okr['objective']->finished_at }}</div>
            <div class="col-md-1">
                <div class="col-md-2 btn-group">
                    <button type="button" class="btn btn-light btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-pencil-alt"></i>
                    </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="{{route('okrs.edit',$okr['objective']->id)}}"><i class="fas fa-pencil-alt"></i>編輯</a>
                        <a class="dropdown-item" href="#" onclick="document.getElementById('delete{{$okr['objective']->id}}').submit()"><i class="fas fa-trash"></i>刪除</a>
                        <form method="POST" id="delete{{$okr['objective']->id}}" action="{{route('okrs.destroyObjective',$okr['objective']->id)}}">
                            @csrf
                            {{ method_field('DELETE') }}
                        </form>
                    </div>                        
                </div>                   
            </div>
            
            <div class="col-md-2 font-weight-light text-center"> <h5>Objectives</h5> </div>
            <div class="col-md-7 font-weight-light">
                    {{$okr['objective']->title}}
            </div>
            <div class="col-md-2">
                @php
                $sum = 0; $totalWeight = 0;
                foreach($okr['keyresults'] as $kr){
                    $totalWeight += $kr->weight;
                    $sum += $kr->accomplishRate() * $kr->weight;
                }
                if($totalWeight > 0)
                    $scoreOfObj=round($sum/$totalWeight, 0);
                else
                    $scoreOfObj=0;
                @endphp
                    
            <div class="progress">
                @if($scoreOfObj<0)  
                <div class="progress-bar bg-danger" role="progressbar" style="width:{{ abs($scoreOfObj) }}%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">{{ $scoreOfObj }}%</div>
                @else
                <div class="progress-bar" role="progressbar" style="width:{{ $scoreOfObj }}%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">{{ $scoreOfObj }}%</div>
                @endif
            </div>
            </div>
            <div class="col-md-2 font-weight-light text-center pt-3"> <h5>Key Results</h5> </div>
            <div class="col-md-10">
                <div class="row">
                    @foreach ($okr['keyresults'] as $kr)
                    
                        <span class="col-md-7" style="border-left: 5px solid {{$colors[($kr->id)%9]}} "> {{$kr->title}} </span>
                        <div class="col-md-3">
                            <div class="progress">
                                @if($kr->accomplishRate()<0)
                                    <div class="progress-bar bg-danger" role="progressbar" style="width:{{ abs($kr->accomplishRate()) }}%" aria-valuenow="25" aria-valuemin="{{$kr->initial}}" aria-valuemax="{{$kr->target}}">
                                    {{ $kr->accomplishRate() }}%</div>
                                @else
                                    <div class="progress-bar" role="progressbar" style="width:{{ $kr->accomplishRate() }}%" aria-valuenow="25" aria-valuemin="{{$kr->initial}}" aria-valuemax="{{$kr->target}}">
                                    {{ $kr->accomplishRate() }}%</div>
                                @endif
                            </div>
                        </div>
                        <span class="col-md-1 text-right">{{$kr->confidence}}/10 </span>
                        <div class="col-md-1 btn-group">
                            <button type="button" class="btn btn-light btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-pencil-alt"></i>
                            </button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="{{route('actions.create',$kr->id)}}"><i class="fas fa-pencil-alt"></i>新增 Action</a>
                                <a class="dropdown-item" href="#" onclick="document.getElementById('deleteKR{{$kr->id}}').submit()"><i class="fas fa-trash"></i>刪除 KR</a>
                                <form method="POST" id="deleteKR{{$kr->id}}" action="{{route('okrs.destroyKR',$kr->id)}}">
                                    @csrf
                                    {{ method_field('DELETE') }}
                                </form>
                            </div>                        
                        </div>      
                        <span class="col-md-12"></span>
                        @endforeach
                        @include('okrs.newkr',$okr['objective'])
                </div>
            </div>
        </div>
        
        <div class="card-footer text-muted mt-3">
            <div class="row text-center mb-3">
                <span class="col-md-4">
                
                <button class="btn btn-outline-primary border-0" type="button" data-toggle="collapse" data-target="#Action{{$okr['objective']->id}}" aria-expanded="false" aria-controls="Action">
                        <i class="fas fa-bullseye"></i> 查看 Actions
                </button>
                </span><span class="col-md-4">
                
                <button class="btn btn-outline-primary border-0" type="button" data-toggle="collapse" data-target="#Msg{{$okr['objective']->id}}" aria-expanded="false" aria-controls="Msg">
                        <i class="far fa-comments"></i> 查看留言
                </button>
                </span><span class="col-md-4">
                
                <button class="btn btn-outline-primary border-0" type="button" data-toggle="collapse" data-target="#History{{$okr['objective']->id}}" aria-expanded="false" aria-controls="History">
                        <i class="fas fa-chart-line"></i> 歷史數據
                </button>
            </div>

        <div class="collapse" id="Action{{$okr['objective']->id}}">
            <div class="card card-body">
                <div class="row">
                    @foreach($okr['actions'] as $action)
                    @if(!$action->isdone)
                        <div class="col-md-2 text-center"> {{$action->finished_at}}</div>
                        <div class="col-md-6 mb-1" style="border-left: 5px solid {{$colors[($action->related_kr)%9]}} ">
                            <a href="{{route('actions.show',$action->id)}}"  data-toggle="modal" data-target="#action{{$action->id}}">{{$action->title}}</a>                    
                        </div>
                            <!-- Modal -->
                        <div id='app'>
                            <div class="modal {{ count($errors) == 0 ? 'fade' : '' }}" id="action{{$action->id}}" tabindex="-1" role="dialog">
                                <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal">
                                                <span>&times;</span>
                                            </button>
                                        </div>
                                        @if(count($okrs[0]['actions'])>0)
                                        @include('actions.show',$action) 
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                                <i class="fas fa-file"></i>
                        </div>
                        <div class="col-md-1"><i class="far fa-comment-alt"></i></div>
                        <div class="col-md-1 btn-group">
                            <button type="button" class="btn btn-light btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-pencil-alt"></i>
                            </button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="#" onclick="document.getElementById('doneAct{{$action->id}}').submit()"><i class="fas fa-check-circle"></i> 完成 Action</a>
                                <form method="POST" id="doneAct{{$action->id}}" action="{{route('actions.done',$action->id)}}">
                                    @csrf
                                </form>
                                <a class="dropdown-item" href="{{route('actions.edit',$action->id)}}"><i class="fas fa-pencil-alt"></i> 編輯 Action</a>
                                <a class="dropdown-item" href="#" onclick="document.getElementById('deleteAct{{$action->id}}').submit()"><i class="fas fa-trash"></i> 刪除 Action</a>
                                <form method="POST" id="deleteAct{{$action->id}}" action="{{route('actions.destroyAct',$action->id)}}">
                                    @csrf
                                    {{ method_field('DELETE') }}
                                </form>
                            </div>                        
                        </div>  
                    @endif    
                    @endforeach
                </div>
            </div>
            </div>
            <div class="collapse" id="Msg{{$okr['objective']->id}}">
                <div class="card card-body">
                        X
                </div>
            </div>
            <div class="collapse" id="History{{$okr['objective']->id}}">
                <div class="card card-body">
                        X
                </div>
            </div>
        </div>
    </div>
    <br/>
    @comments(['model' => $okr['objective']])
    @endcomments
@endforeach



