@extends('layouts.master')
@section('title','My OKR')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h4>新增 Action</h4>
            <a href="{{ route('user.okr', auth()->user()->id) }}" class="btn btn-info btn-sm">返回</a>
        </div>
        @include('actions.error',[$errors]) 
        <form method="POST" action="{{ route('actions.store') }}" enctype="multipart/form-data">
            @csrf
            @include('actions.form',[$user,$keyresults,$priorities,$action=false,]) 
        </form>
    </div>
</div>
@endsection

    