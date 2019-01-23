@extends('layouts.master')
@section('script')

@endsection
@section('stylesheet')

@endsection
@section('title','個人追蹤')
@section('content')
<div class="container">
    <div class="row m-3">
        <div class="col-xs-3 mr-auto">
            <h4>個人追蹤</h4>
        </div>
    </div>
    <div class="row">
        @foreach (auth()->user()->follow as $follow)
        <div class="col-md-4 u-mb-16">
            <a href="{{ $follow->model->getOKrRoute() }}">
                <div class="card u-margin-8">
                    <div class="card-body u-pt-32 u-pb-32">
                        <div class="row justify-content-center">
                            <div class="col-lg-12 text-center">
                                <img src="{{ $follow->model->getAvatar() }}" alt="" class="avatar text-center projectAvatar">
                                <span class="u-margin-8 text-black-50 font-weight-bold" style="font-size: 18px">{{
                                        $follow->model->name }}</span>
                                @if ($follow->model->follower->first())
                                <a href="{{ route('follow.cancel', [get_class($follow->model), $follow->model]) }}" class="text-warning">
                                    <i class="fas fa-star" style="font-size: 24px;"></i>
                                </a>
                                @else
                                <a href="{{ route('follow', [get_class($follow->model), $follow->model]) }}" class="text-warning">
                                    <i class="far fa-star" style="font-size: 24px;"></i>
                                </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        @endforeach
    </div>
</div>
@endsection
