
 
@extends('layouts.master')
@section('title','My OKR')
@section('content')
<div class="container">
 <div class="row">
     <div class="col-12">
         <h2>我的OKR</h2>
         <a href="{{route('okrs.index')}}" class="btn btn-info btn-sm">返回</a>
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
    <form method="POST" action="{{route('okrs.storeObjective')}}">
        @csrf
        <div class="form-row ml-5">
        <div class="form-group col-md-4">
            <label for="objective_title">目標</label>
            <input type="text" class="form-control" name="obj_title" id="objective_title" value="">
        </div>
        <div class="form-group col-md-4">
            <label for="started_at">起始日</label>
            <input type="date" class="form-control datepicker" name="st_date" id="started_at" value="">
            </div>
        <div class="form-group col-md-4">
            <label for="finished_at">完成日</label>
            <input type="date" class="form-control datepicker" name="fin_date" id="finished_at" value="">
        </div>
        <button class="btn btn-info btn-sm" type="submit">新增</button>
    </div>  
    </form>
</div>
@endsection


            
    
            
    