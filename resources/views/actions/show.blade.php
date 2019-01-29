@extends('layouts.master')
@section('title','Action')
@section('content')
<div class="container">
    <div class="row mb-2">
        <div class="col">
            <a href="{{url()->previous()}}" class="text-primary mt-2 mr-2 float-left"><i class="fa fa-arrow-left fa-lg"></i></a><br/>
            <h4 class="d-inline-block">{{$action->title}}</h4>
            <span class="badge badge-pill badge-{{$action->priority()->getResults()->color}}">{{$action->priority()->getResults()->priority}}</span>
            <span class="badge badge-pill badge-secondary">關聯KR : {{$action->keyresult->title}}</span>
        </div>
        <div class="col">
            @can('update', $action)
            <a class="btn-group mt-2 mr-2 text-success float-right" href="#" data-toggle="dropdown" aria-haspopup="true"
                aria-expanded="false"><i class="fas fa-pencil-alt"></i></a>
            <div class="dropdown-menu">
                <a class="dropdown-item text-primary" href="#" onclick="document.getElementById('doneAct{{ $action->id }}').submit()"><i
                        class="fas fa-check-circle"></i> 完成 Action</a>
                <form method="POST" id="doneAct{{ $action->id }}" action="{{ route('actions.done',$action->id) }}">
                    @csrf
                </form>
                <a class="dropdown-item text-primary" href="{{ route('actions.edit',$action->id) }}"><i class="fas fa-pencil-alt"></i>
                    編輯 Action</a>
                <a class="dropdown-item text-danger" href="#" onclick="document.getElementById('deleteAct{{ $action->id }}').submit()"><i
                        class="fas fa-trash"></i> 刪除 Action</a>
                <form method="POST" id="deleteAct{{ $action->id }}" action="{{ route('actions.destroy',$action->id) }}">
                    @csrf
                    {{ method_field('DELETE') }}
                </form>
            </div>
            @endcan            
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
