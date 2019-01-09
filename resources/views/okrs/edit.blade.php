@extends('layouts.master')
@section('title','My OKR')
@section('content')
<div class="container">
 <div class="row">
    <div class="col-12">
         <h4><a href="{{ route('user.okr', auth()->user()->id) }}" class="btn btn-primary btn-sm">返回</a>
         修改 OKR</h4>
    </div>
    @include('actions.error',[$errors]) 
    <form method="POST" action="{{route('okr.update',$objective->id)}}">
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
                <label for="keyresult_title"><a class="btn btn-link" href="#" onclick="document.getElementById('deleteKR{{ $keyresult->id }}').submit()"><i class="fas fa-trash"></i></a> 關鍵指標(KeyResult)</label>
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
        <button class="btn btn-primary btn-sm col-md-12 mt-3" type="submit">修改</button>  
        </div>
    </form>
    @foreach ($keyresults as $keyresult)
        <form method="POST" id="deleteKR{{ $keyresult->id }}" action="{{ route('kr.destroy', $keyresult->id) }}">
            @csrf
            {{ method_field('DELETE') }}
        </form>
    @endforeach
</div>
@endsection