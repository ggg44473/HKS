@extends('layouts.master')
@section('title','My OKR')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h4>新增 Action</h4>
            <a href="{{url()->previous()}}" class="btn btn-primary btn-sm float-right">返回</a>
        </div>
        @include('actions.error',[$errors])
        <form method="POST" action="{{ route('actions.store') }}" enctype="multipart/form-data">
            @csrf
            @include('actions.form', ['action'=>false])
        </form>
    </div>
</div>
@endsection
