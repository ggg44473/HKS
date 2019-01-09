@extends('layouts.master')
@section('title','My OKR')
@section('content')
<div class="container">
 <div class="row">
     <div class="col-12">
         <h2>我的OKR</h2>
         <a href="{{ route('user.okr', auth()->user()->id) }}" class="btn btn-primary btn-sm">返回</a>
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
            <div class="form-row">
                <div class="form-group col-md-12">
                    <label for="keyresult_title">關鍵指標(KeyResult)</label>
                    <input type="text" class="form-control" name="krs_title{{ $keyresult->id }}" id="keyresult_title" value="{{ $keyresult->title }}">
                </div>
                <div class="form-group col-md-6">
                    <label for="keyresult_confidence">達成率</label>
                    <input type="text" class="js-range-slider" id="keyresult_slider" name="krs_now" value="{{ old('krs_now') ? old('krs_now') : '0' }}"
                        data-min="{{ old('krs_init') ? old('krs_init') : '0' }}"
                        data-max="{{ old('krs_tar') }}"
                        data-from="{{ old('krs_now') ? old('krs_now') : '0' }}"
                        data-grid= true 
                    />
                </div>
                <div class="form-group col-md-3">
                    <label for="keyresult_weight">權重</label>
                    <input type="text" class="js-range-slider" name="krs_weight" value="{{ old('krs_weight') ? old('krs_weight') : '1' }}"
                        data-min="0.1"
                        data-max="2"
                        data-from="{{ old('krs_weight') ? old('krs_weight') : '1' }}"
                        data-step="0.1"
                        data-grid= true 
                    />
                </div>
                <div class="form-group col-md-3">
                    <label for="keyresult_confidence">信心值</label>
                    <input type="text" class="js-range-slider" name="krs_conf" value="{{ old('krs_conf') ? old('krs_conf') : '5' }}"
                        data-min="0"
                        data-max="10"
                        data-from="{{ old('krs_conf') ? old('krs_conf') : '5' }}"
                        data-step="1" 
                        data-grid= true 
                    />
                </div>
                <div class="form-group col-md-2">
                    <label for="keyresult_initaial">起始值</label>
                    <input type="number" class="form-control" name="krs_init" id="keyresult_initaial" value="{{ old('krs_init') ? old('krs_init') : '0' }}">
                </div>
                <div class="form-group col-md-2">
                    <label class="text-primary" for="keyresult_target">當前值</label>
                    <input type="number" class="form-control" name="krs_now" id="keyresult_now" value="{{ old('krs_now') ? old('krs_now') : '0' }}">
                </div>
                <div class="form-group col-md-2">
                    <label for="keyresult_target">目標值</label>
                    <input type="number" class="form-control" name="krs_tar" id="keyresult_target" value="{{ old('krs_tar') ? old('krs_tar') : '100' }}">
                </div>
                <div class="form-group col-md-6 u-text-right">
                    <button class="btn btn-primary u-mt-16" type="submit" style="width:100px;">新增</button>   
                </div>
            </div>
            {{-- <div class="form-group col-md-12">
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
            </div> --}}
        @endforeach
        <button class="btn btn-primary btn-sm col-md-12" type="submit">修改</button>  
        </div>
    </form>
</div>
@endsection