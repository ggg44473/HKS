@foreach($okrs as $okr)
    <div class="card shadow-sm p-2">
        <div class="row">
            <div class="col-md-7 text-right"></div>
            <div class="col-md-2 font-weight-light">起始日:{{ $okr['objective']->started_at }}</div>
            <div class="col-md-2 font-weight-light">結算日:{{ $okr['objective']->finished_at }}</div>
            <div class="col-md-1">
                <div class="col-md-2 btn-group">
                    <button type="button" class="btn btn-light btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <img src="http://www.haipic.com/icon/53922/53922.png" width="25" height="25">
                    </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="{{route('okrs.edit',$okr['objective']->id)}}"><img src="https://img.icons8.com/metro/1600/edit.png" width="20" height="20">編輯</a>
                        <a class="dropdown-item" href="#" onclick="document.getElementById('delete{{$okr['objective']->id}}').submit()"><img src="https://img.icons8.com/metro/1600/delete.png" width="20" height="20">刪除</a>
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
        
                        <span class="col-md-7" style="border-left: 3px solid red"> {{$kr->title}} </span>
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
                        <a class="dropdown-item col-md-1" href="#" onclick="document.getElementById('deleteKR{{$kr->id}}').submit()"><img src="https://img.icons8.com/metro/1600/delete.png" width="20" height="20"></a>
                        <form method="POST" id="deleteKR{{$kr->id}}" action="{{route('okrs.destroyKR',$kr->id)}}">
                            @csrf
                            {{ method_field('DELETE') }}
                        </form>
                            
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
                        <img src="https://img.icons8.com/ios/1600/goal.png" width="20" height="20"> 查看 Actions
                </button>
                </span><span class="col-md-4">
                
                <button class="btn btn-outline-primary border-0" type="button" data-toggle="collapse" data-target="#Msg{{$okr['objective']->id}}" aria-expanded="false" aria-controls="Msg">
                        <img src="http://icon.chrafz.com/uploads/allimg/160421/1-1604211620090-L.png" width="20" height="20"> 查看留言
                </button>
                </span><span class="col-md-4">
                
                <button class="btn btn-outline-primary border-0" type="button" data-toggle="collapse" data-target="#History{{$okr['objective']->id}}" aria-expanded="false" aria-controls="History">
                        <img src="http://icon.chrafz.com/uploads/allimg/170119/1-1F1191352440-L.png" width="20" height="20"> 歷史數據
                </button>
            </div>

        <div class="collapse" id="Action{{$okr['objective']->id}}">
            <div class="card card-body">
                Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident.
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

<!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
        刪除確認測試紐
</button>
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">KR名稱</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              你確定要刪除嗎 ?
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">否</button>
              <button type="button" class="btn btn-danger">是，刪除</button>
            </div>
          </div>
        </div>
      </div>
