@extends('layouts.master')
@section('title','My OKR')
@section('content')
<div class="container">
 <div class="row">
     <div class="col-12">
         <h4>我的OKR</h4>
         <a href="{{ route('user.okr', auth()->user()->id) }}" class="btn btn-info btn-sm">返回</a>
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
    <form method="POST" action="{{ route('objective.store') }}">
        @csrf
        <div class="form-row ml-5">
        <div class="form-group col-md-4">
            <label for="objective_title">目標</label>
            <input type="text" class="form-control" name="obj_title" id="objective_title" value="">
        </div>
        <div class="form-group col-md-4">
            <label for="started_at">起始日</label>
            <input autocomplete="off" class="form-control" name="st_date" id="started_at" value="">
            </div>
        <div class="form-group col-md-4">
            <label for="finished_at">完成日</label>
            <input autocomplete="off" class="form-control" name="fin_date" id="finished_at" value="">
        </div>
        <button class="btn btn-primary btn-sm" type="submit">新增</button>
    </div>  
    </form>
</div>
@endsection
