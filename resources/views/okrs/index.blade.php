@extends('layouts.master')
@section('title','My OKR')
@section('content')
<div class="container">
    <div class="row m-3">
        <div class="col-md-2 font-weight-light text-center"> <h2>My OKR</h2> </div>
        <div class="col-md-6 "></div>
        <div class="col-md-1 "><a href="{{route('okrs.create')}}" class="btn btn-info">新增目標</a></div>
        <div class="col-md-1 text-right"><img src="https://img.icons8.com/windows/1600/time-search.png" width="30" height="30"></div>          
        <div class="col-md-2 btn-group">
            <button type="button" class="btn btn-info dropdown-toggle btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                歷史紀錄
            </button>
            <div class="dropdown-menu">
                <a class="dropdown-item" href="#">2018  Q1</a>
                <a class="dropdown-item" href="#">2018  Q2</a>
                <a class="dropdown-item" href="#">2018  Q3</a>
                <a class="dropdown-item" href="#">2018  Q4</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#">2017</a>
            </div>                        
        </div>
    </div>
    
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
    
                <div class="col-md-2 font-weight-light text-center"> <h3>Objectives</h3> </div>
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
                <div class="col-md-2 font-weight-light text-center "> <h3>Key Results</h3> </div>
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

                            @if ($errors->any())
                                <div class="alert alert-danger alert-dismissible col-md-10" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    <strong>警告！</strong> 請修正以下表單錯誤：
                                    <ul>
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                        <form method="POST" action="{{route('okrs.storeKR')}}">
                                @csrf
                        <div class="form-row  mr-5">
                        <input type="hidden" class="form-control" name="krs_owner" id="keyresult_owner" value="{{$okr['objective']->id}}">
                        <div class="form-group col-md-12">
                            <label for="keyresult_title">關鍵指標(KeyResult)</label>
                            <input type="text" class="form-control" name="krs_title" id="keyresult_title" value="{{old('krs_title')}}">
                        </div>
                        <div class="form-group col-md-1">
                            <label for="keyresult_weight">權重</label>
                            <input type="number" class="form-control" name="krs_weight" id="keyresult_weight" value="{{old('krs_weight')}}">
                        </div>
                        <div class="form-group col-md-1">
                            <label for="keyresult_confidence">信心值</label>
                            <input type="number" class="form-control" name="krs_conf" id="keyresult_confidence" value="{{old('krs_conf')}}">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="keyresult_initaial">起始值</label>
                            <input type="number" class="form-control" name="krs_init" id="keyresult_initaial" value="{{old('krs_init')}}">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="keyresult_target">目標值</label>
                            <input type="number" class="form-control" name="krs_tar" id="keyresult_target" value="{{old('krs_tar')}}">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="keyresult_target">當前值</label>
                            <input type="number" class="form-control" name="krs_now" id="keyresult_now" value="{{old('krs_now')}}">
                        </div>
                        <button class="btn btn-info btn-sm col-md-1" type="submit">新增</button>  
                        </div>    
                        </form>
                        
                    </div>
                </div>
            </div>
            
            <div class="card-footer text-muted mt-3">
                <div class="row text-center mb-3">
                    <span class="col-md-4">
                    
                    <button class="btn btn-outline-info border-0" type="button" data-toggle="collapse" data-target="#Action" aria-expanded="false" aria-controls="Action">
                            <img src="https://img.icons8.com/ios/1600/goal.png" width="20" height="20"> 查看 Actions
                    </button>
                    </span><span class="col-md-4">
                    
                    <button class="btn btn-outline-info border-0" type="button" data-toggle="collapse" data-target="#Msg" aria-expanded="false" aria-controls="Msg">
                            <img src="http://icon.chrafz.com/uploads/allimg/160421/1-1604211620090-L.png" width="20" height="20"> 查看留言
                    </button>
                    </span><span class="col-md-4">
                    
                    <button class="btn btn-outline-info border-0" type="button" data-toggle="collapse" data-target="#History" aria-expanded="false" aria-controls="History">
                            <img src="http://icon.chrafz.com/uploads/allimg/170119/1-1F1191352440-L.png" width="20" height="20"> 歷史數據
                    </button>
                </div>
    
            <div class="collapse" id="Action">
                <div class="card card-body">
                    Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident.
                </div>
                </div>
                <div class="collapse" id="Msg">
                    <div class="card card-body">
                            X
                    </div>
                </div>
                <div class="collapse" id="History">
                    <div class="card card-body">
                            X
                    </div>
                </div>
            </div>
        </div>
        <br/>
    @endforeach
    
@endsection