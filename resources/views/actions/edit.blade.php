@extends('layouts.master')
@section('title','Edit Action')
@section('content')
<div class="container">
    <div class="row mb-2">
        <div class="col">
            <a href="{{url()->previous()}}" class="text-black-50"><i class="fas fa-chevron-left"></i> 返回</a>
        </div>
    </div>
    <div class="row justify-content-center mt-4 mb-4">
        <div class="col-md-10 col-12">
            <h4>編輯 Action</h4>
        </div>
    </div>
    @include('actions.error',[$errors])
    <div class="row justify-content-center">
        <div class="col-md-10 col-12">
            @foreach($actions as $action)
            <form method="POST" action="{{ route('actions.update',$action->id) }}" enctype="multipart/form-data">
                @csrf
                {{ method_field('PATCH') }}
                @include('actions.form',[$user,$keyresults,$priorities,$action,$files,'objective'=>$action->objective])
            </form>
            @endforeach
        </div>
    </div>
</div>
@endsection
