@extends('layouts.master')
@section('script')
    <script src="{{ asset('js/tooltip.js') }}" defer></script>
@endsection
@section('stylesheet')
<link href="{{ asset('css/project.css') }}" rel="stylesheet">
@endsection
@section('title','專案綜覽')
@section('content')
<div class="container">
    <div class="row m-3">
        <div class="col-xs-3 mr-auto">
            <h4>Project</h4>
        </div>
        <div class="col-xs-3 text-right pr-3">
            <a href="{{ route('project.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> 新增專案</a>
        </div>
    </div>
    <div class="row">
        @foreach ($projects as $project)
        <div class="col-md-6 u-mb-16">
            <a href="{{ route('project.okr', $project) }}">
                <div class="card u-margin-8">
                    @include('project.card')
                </div>
            </a>
        </div>
        @endforeach
    </div>
    <hr />
    <div class="row m-3">
        <div class="col-xs-3 mr-auto">
            <h4>Closed</h4>
        </div>
    </div>
    <div class="row">
        @foreach ($done as $project)
        <div class="col-md-6 u-mb-16">
            <a href="{{ route('project.okr', $project) }}">
                <div class="card u-margin-8">
                    @include('project.card')
                </div>
            </a>
        </div>
        @endforeach
    </div>
</div>
@endsection
