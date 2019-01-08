@extends('layouts.master')
@section('title','Edit Action')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <h4>編輯 Action</h4>
            <a href="{{ route('user.okr', auth()->user()->id) }}" class="btn btn-info btn-sm">返回</a>
        </div>
        @include('actions.error',[$errors]) 
        @foreach($actions as $action)
        <form method="POST" action="{{ route('actions.update',$action->id) }}" enctype="multipart/form-data">
            @csrf
            {{ method_field('PATCH') }}
            @include('actions.form',[$user,$keyresults,$priorities,$action,$files]) 
        </form>
        @endforeach
    </div>
</div>
@endsection

    