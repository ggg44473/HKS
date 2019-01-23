@extends('layouts.master')
@section('title','Action')
@section('content')
<div class="container">
    <div class="row mb-2">
        <div class="col-12">
            <a href="{{url()->previous()}}" class="btn btn-primary btn-sm float-right">返回</a>
        </div>
        <div class="col">
            <h4>{{$action->title}}</h4>
        </div>
        <div class="col">
            <span class="badge badge-pill badge-{{$action->priority()->getResults()->color}}">{{$action->priority()->getResults()->priority}}</span>
            <span class="badge badge-pill badge-secondary">關聯KR : {{$action->keyresult->title}}</span>
        </div>
    </div>
    <div class="row align-items-center mb-4">
        <div class="col-md-6">
            負責:
            <a href="{{ route('user.okr', $action->user->id) }}" title="{{$action->user->name}}">
                <img src="{{ $action->user->getAvatar() }}" class="avatar-sm mr-1">
            </a>
        </div>
        <div class="col-md-2">Start: {{$action->started_at}}</div>
        <div class="col-md-2">Finish: {{$action->finished_at}}</div>
        <div class="col-md-2">Updated: {{$action->updated_at}}</div>
    </div>
    <div class="row">
        <div class="col-12">
            <label>說明</label>
            <div class="ml-4">
                <pre>{{$action->content}}</pre>
            </div>
        </div>
        <div class="col-12">
            <label>附件</label>
            @if(!empty($files))
            <div class="row ml-3">
                @foreach($files as $file)
                <div class="col-xs-12 col-md-6 col-lg-4">
                    {{ $file['updated_at'] }} <br>
                    <a href="{{ $file['url'] }}">{{ $file['name'] }}</a>
                </div>
                @endforeach
            </div>
            @endif
        </div>
    </div>
    <hr>
    <div class="row">
        @comments(['model' => $action])
        @endcomments
    </div>
</div>
@endsection
