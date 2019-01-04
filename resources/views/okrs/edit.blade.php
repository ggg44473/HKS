@extends('layouts.master')
@section('title','My OKR')
@section('content')
<div class="container">
 <div class="row">
     <div class="col-12">
         <h2>我的OKR</h2>
         <a href="{{route('okrs.index')}}" class="btn btn-primary btn-sm">返回</a>
    </div>
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
    <form method="POST" action="{{route('okrs.update',$objective->id)}}">
        @csrf
        {{ method_field('PATCH') }}
        <div class="form-row">
        <div class="form-group col-md-4">
            <label for="objective_title">目標(Objective)</label>
            <input type="text" class="form-control" name="obj_title" id="objective_title" value="{{$objective->title}}" required>
        </div>
        <div class="form-group col-md-4">
            <label for="started_at">起始日</label>
            <input type="date" class="form-control" name="st_date" id="started_at" value="{{$objective->started_at}}" required>
            </div>
        <div class="form-group col-md-4">
            <label for="finished_at">完成日</label>
            <input type="date" class="form-control" name="fin_date" id="finished_at" value="{{$objective->finished_at}}" required>
        </div>
        @foreach($keyresults as $keyresult)
        
            <div class="form-group col-md-12">
                <label for="keyresult_title">關鍵指標(KeyResult)</label>
                <input type="text" class="form-control" name="krs_title{{$keyresult->id}}" id="keyresult_title" value="{{$keyresult->title}}" required>
            </div>
            <div class="form-group col-md-2">
                <label for="keyresult_confidence">信心值</label>
                <input type="number" class="form-control" name="krs_conf{{$keyresult->id}}" id="keyresult_confidence" value="{{$keyresult->confidence}}"  required>
            </div>
            <div class="form-group col-md-2">
                    <label for="keyresult_weight">權重值</label>
                    <input type="number" class="form-control" name="krs_weight{{$keyresult->id}}" id="keyresult_weight" value="{{$keyresult->weight}}"  required>
                </div>
            <div class="form-group col-md-2">
                <label for="keyresult_initaial">起始值</label>
                <input type="number" class="form-control" name="krs_init{{$keyresult->id}}" id="keyresult_initaial" value="{{$keyresult->initial_value}}"  required>
            </div>
            <div class="form-group col-md-2">
                <label for="keyresult_target">目標值</label>
                <input type="number" class="form-control" name="krs_tar{{$keyresult->id}}" id="keyresult_target" value="{{$keyresult->target_value}}"  required>
            </div>
            <div class="form-group col-md-2">
                <label for="keyresult_target">當前值</label>
                <input type="number" class="form-control" name="krs_now{{$keyresult->id}}" id="keyresult_now" value="{{$keyresult->current_value}}"  required>
            </div>
        @endforeach
        <button class="btn btn-primary btn-sm col-md-12" type="submit">修改</button>  
        </div>
    </form>
</div>
@endsection