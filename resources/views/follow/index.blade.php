@extends('layouts.master')
@section('script')
<script src="{{ asset('js/dragula.js') }}" defer></script>
<script src="{{ asset('js/dragDrop.js') }}" defer></script>
@endsection
@section('stylesheet')
<link href="{{ asset('css/dragula.css') }}" rel="stylesheet" />
@endsection
@section('title','個人追蹤')
@section('content')
<div class="container">
    @if (count(auth()->user()->follow) == 0 )
        <div class="alert alert-warning alert-dismissible fade show u-mt-32 text-center" role="alert">
            <strong><i class="fas fa-exclamation-circle pl-2 pr-2"></i></strong>
            尚未擁有追蹤 !!
        </div>
    @endif
    <div id="dragCard" class="row">
        @foreach (auth()->user()->follow as $follow)
        <div class="col-md-3 col-sm-6 u-mb-16">
                <div class="card u-margin-4">
                    <div class="card-header">
                        {{-- 追蹤 --}}
                        <div class="row">
                            <div class="col-12 text-right">
                                <a href="{{ route('follow.cancel', [get_class($follow->model), $follow->model]) }}" class="text-warning" data-toggle="tooltip" data-placement="right" title="取消追蹤">
                                    <i class="fas fa-star" style="font-size: 20px;"></i>
                                </a>
                            </div>
                        </div>
                        {{-- 個人資訊 --}}
                        <a href="{{ $follow->model->getOKrRoute() }}">
                            <div class="row mb-2">
                                <div class="col-auto pl-4 pr-0">
                                    <img src="{{ $follow->model->getAvatar() }}" alt="" class="avatar-md text-center projectAvatar">
                                </div>
                                <div class="col text-truncate align-self-center">
                                    <p class="font-weight-bold text-black-50 mb-0 text-truncate">{{ $follow->model->name }}</p>
                                </div>
                            </div>
                        </a>
                    </div>
                <a href="{{ $follow->model->getOKrRoute() }}">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-4 text-center pr-0">
                                <p class="font-weight-bold text-black-50 mb-0" style="font-size: 20px;">{{ $follow->model->countObjective() }}</p>
                                <span class="text-black-50">Objective</span>
                            </div>
                            <div class="col-4 text-center pl-0 pr-0">
                                    <p class="font-weight-bold text-black-50 mb-0" style="font-size: 20px;">{{ $follow->model->countKRs() }}</p>
                                    <span class="text-black-50">KRs</span>
                            </div>
                            <div class="col-4 text-center pl-0">
                                    <p class="font-weight-bold text-black-50 mb-0" style="font-size: 20px;">{{ count($follow->model->follower) }}</p>
                                    <span class="text-black-50">Follower</span>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
