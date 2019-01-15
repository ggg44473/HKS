@extends('layouts.master')
@section('title','Action')
@section('content')
<div class="container">
    <div class="row mb-2 align-items-center">
        <div class="col-md-4 mb-2">
            <a href="{{ route('user.okr', auth()->user()->id) }}" class="btn btn-primary btn-sm">返回</a><br />
            <span class="badge badge-pill badge-{{$action->priority()->getResults()->color}}">{{$action->priority()->getResults()->priority}}</span>
            <span class="badge badge-pill badge-secondary">關聯KR : {{$action->keyresult()->getResults()->title}}</span>
        </div>
        <div class="col align-self-end mb-3 text-right">
            <h5>
                <small>Updated : {{$action->updated_at}}</small><br />
                | <small>
                    執行者:
                    <a href="{{ route('user.okr',$action->user()->getResults()->id) }}">
                        <img src="{{ $action->user()->getResults()->avatar? asset('storage/avatar/'.$action->user()->getResults()->id.'/'.$action->user()->getResults()->avatar):asset('/img/icon/user/green.svg') }}"
                            class="avatar">
                    </a>
                    {{$action->user()->getResults()->name}}
                </small> |
                <small>
                    指派者:
                    <a href="{{ route('user.okr',$action->assignee()->getResults()->id) }}">
                        <img src="{{ $action->assignee()->getResults()->avatar? asset('storage/avatar/'.$action->assignee()->getResults()->id.'/'.$action->assignee()->getResults()->avatar):asset('/img/icon/user/green.svg') }}"
                            class="avatar">
                    </a>
                    {{$action->assignee()->getResults()->name}}
                </small> |
                <small>Started : {{$action->started_at}}</small> |
                <small>Finished : {{$action->finished_at}}</small> |
            </h5>
        </div>
        <div class="col-md-12 text-center alert alert-success">
            <h4>{{$action->title}}</h4>
        </div>
        <div class="col-md-12 align-self-end mb-2 text-right">
        </div>
        <div class="col-md ml-2">
            <h4>說明</h4>
        </div>
        <div class="col-md-11 bg-white pt-2 mb-2">
            <pre>{{$action->content}} </pre>
        </div>
        <div class="col-md ml-2">
            <h4>附件</h4>
        </div>
        <div class="col-md-11">
            @if(!empty($files))
            <div class="row">
                @foreach($files as $file)
                <div class="col-xs-12 col-md-6 col-lg-4">
                    {{ $file['updated_at'] }} <br>
                    <a href="{{ $file['url'] }}">{{ $file['name'] }}</a>
                </div>
                @endforeach
            </div>
            @endif
        </div><br />
        <hr />
        @comments(['model' => $action])
        @endcomments
    </div>
    @endsection
