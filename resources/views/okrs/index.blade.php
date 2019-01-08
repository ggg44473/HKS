@extends('layouts.master')
@section('title','My OKR')
@section('content')
<div class="container">
    <div class="row m-3">
        <div class="col-md-2 font-weight-light text-center"> <h4>My OKR</h4> </div>
        <div class="col-md-8 "></div>
        <div class="col-md-1 "><a href="{{ route('objective.create') }}" class="btn btn-primary "> <i class="fa fa-plus fa-sm"></i> 新增目標</a></div>        
        <div class="col-md-1 btn-group">
            <button type="button" class="btn btn-primary dropdown-toggle btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fa fa-history fa-sm"></i> 歷史紀錄
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
    @include('okrs.okr',$okrs)
    
@endsection




