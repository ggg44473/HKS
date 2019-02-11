@extends('layouts.master')
@section('title','Action')
@section('content')
<div class="container">
    <div class="row mb-2">
        <div class="col">
            <a href="{{$backLink}}" class="text-black-50"><i class="fas fa-chevron-left"></i> 回到目標</a>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-10 col-12">
            {{-- 編輯 --}}
            @can('update', $action)
            <div class="row justify-content-end">
                <div class="col-auto">
                    <a class="text-info" href="#" onclick="document.getElementById('doneAct{{ $action->id }}').submit()"><i class="fas fa-check-circle"></i> {{ $action->isdone?'取消完成':'完成' }}</a>
                    <form method="POST" id="doneAct{{ $action->id }}" action="{{ route('actions.done',$action->id) }}">
                        @csrf
                    </form>
                </div>
                <div class="col-auto">
                    <a class="text-info" href="{{ route('actions.edit',$action->id) }}"><i class="fas fa-edit"></i> 編輯</a>
                </div>
                <div class="col-auto">
                    <a href="#" data-toggle="dropdown" class="text-info"><i class="fas fa-trash-alt"></i> 刪除</a>
                    <form method="POST" id="deleteAct{{ $action->id }}" action="{{ route('actions.destroy', $action->id) }}">
                        @csrf
                        {{ method_field('DELETE') }}
                        <div class="dropdown-menu u-padding-16">
                            <div class="row justify-content-center mb-2">
                                <div class="col-auto text-danger"><i class="fas fa-exclamation-triangle"></i></div>
                            </div>
                            <div class="row">
                                <div class="col text-center">
                                    確認要Action嗎？<br>
                                </div>
                            </div>
                            <div class="row justify-content-center mt-3">
                                <div class="col text-center pr-0"><button class="btn btn-danger" type="submit">刪除</button></div>
                                <div class="col text-center pl-0"><a class="btn btn-secondary text-white">取消</a></div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            @endcan
            {{-- kr --}}
            <div class="row">
                <div class="col-auto font-weight-bold text-muted align-self-center">
                    <div class="badge badge-pill pl-4 pr-4 text-white mr-2"  style="line-height: 18px; background-color:{{ $action->keyresult->color() }};">KR</div>
                    {{ $action->keyresult->title }}
                </div>
            </div>
            {{-- Action title --}}
            <div class="row mt-4 mb-4">
                <div class="col-auto">
                    <h4>{{ $action->title }}</h4>
                </div>
                <div class="col-auto text-right text-muted align-self-center">{{ $action->updated_at }}更新</div>
            </div>
            <div class="row mt-4 mb-4">
                <div class="col-auto align-self-center text-muted pr-md-4" style="line-height: 24px;">
                    期限｜
                    <i class="far fa-clock pr-2"></i>
                    {{ date('M. d, Y', strtotime($action->finished_at)) }}
                </div>
                <div class="col-auto align-self-center text-muted pl-md-4 pr-md-4" style="line-height: 24px;">
                    負責人｜
                    <a href="{{ route('user.okr', $action->user->id) }}" title="{{ $action->user->name }}">
                        <img src="{{ $action->user->getAvatar() }}" class="avatar-xs mr-1">
                        <span>{{ $action->user->name }}</span>
                    </a>
                </div>
                <div class="col-auto text-center align-self-center text-muted pl-md-4" style="line-height: 24px;">
                    優先度｜
                    <div class="badge badge-pill badge-{{ $action->priority()->getResults()->color }} pl-4 pr-4">{{ $action->priority()->getResults()->priority }}</div>
                </div>
            </div>
            <hr/>
            <div class="row pl-md-4 pr-md-4">
                <div class="col-12">
                    <div>
                        <pre style="line-height: 28px;">{{$action->content}}</pre>
                    </div>
                </div>
            </div>
            @if(!empty($files))
            <div class="row justify-content-center pt-4 pb-4">
                <div class="col">
                    <i class="fas fa-paperclip text-muted pr-2"></i>
                    <label class="text-muted">附件</label>
                    @foreach($files as $file)
                        <div class="row ml-3 mt-2">
                            <div class="col-auto">{{ $file['updated_at'] }}</div>
                            <div class="col-auto"><a href="{{ $file['url'] }}">{{ $file['name'] }}</a></div>
                        </div>
                    @endforeach
                </div>
            </div>
            @endif
            <hr>
            <div class="row">
                <div class="col">
                    @comments(['model' => $action])
                    @endcomments
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
