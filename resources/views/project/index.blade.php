@extends('layouts.master')
@section('script')
<script src="{{ asset('js/closeProject.js') }}" defer></script>
<script src="{{ asset('js/tooltip.js') }}" defer></script>
<script src="{{ asset('js/avatar.js') }}" defer></script>
<script src="{{ asset('js/dragula.js') }}" defer></script>
<script src="{{ asset('js/dragDrop.js') }}" defer></script>
@endsection
@section('stylesheet')
<link href="{{ asset('css/project.css') }}" rel="stylesheet">
<link href="{{ asset('css/dragula.css') }}" rel="stylesheet"/>
@endsection
@section('title','專案綜覽')
@section('content')
<div class="container">
    @cannot('create', App\Project::class)
        <a class="row pt-4 justify-content-center" href="{{ route('company.index') }}">
            <div class="alert alert-danger alert-dismissible fade show u-mt-32" role="alert">
                <strong><i class="fas fa-exclamation-circle pl-2 pr-2"></i></strong>
                請先成立或加入組織 !!
            </div>
        </a>        
    @endcannot
    @can('create', App\Project::class)
        {{-- 專案邀請 --}}
        @foreach ($invitations as $invitation)
            @include('project.invitation')        
        @endforeach
        {{-- 進行中/已完成專案切換 --}}
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="project-tab" data-toggle="tab" href="#project" role="tab" aria-controls="project" aria-selected="true">Project</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="closeProject-tab" data-toggle="tab" href="#closeProject" role="tab" aria-controls="closeProject" aria-selected="false">Closed</a>
            </li>
        </ul>
        <div class="tab-content" id="myTabContent">
            {{-- 進行中專案 --}}
            <div class="tab-pane fade show active" id="project" role="tabpanel" aria-labelledby="project-tab">
                <div id="dragCard" class="row pt-4 justify-content-center">
                    @foreach ($projects as $project)
                        @include('project.card')
                    @endforeach
                    @if (count($projects) == 0)
                        <div class="alert alert-warning alert-dismissible fade show u-mt-32" role="alert">
                            <strong><i class="fas fa-exclamation-circle pl-2 pr-2"></i></strong>
                            尚未擁有進行中專案 !!
                        </div>
                    @endif
                </div>
            </div>
            {{-- 已完成專案 --}}
            <div class="tab-pane fade" id="closeProject" role="tabpanel" aria-labelledby="profile-tab">
                <div id="dragCarddone" class="row pt-4 justify-content-center">
                    @foreach ($done as $project)
                        @include('project.card')
                    @endforeach
                    @if (count($done) == 0)
                        <div class="alert alert-warning alert-dismissible fade show u-mt-32" role="alert">
                            <strong><i class="fas fa-exclamation-circle pl-2 pr-2"></i></strong>
                            尚未擁有已完成專案 !!
                        </div>
                    @endif
                </div>
            </div>
        </div>
        {{-- 新增專案按鈕 --}}
        <a href="#" data-toggle="modal" data-target="#createProject" class="newObjective"><img src="{{ asset('img/icon/add/lightgreen.svg') }}" alt=""></a>        
        {{-- 新增專案Modal --}}
        @include('project.create')
    @endcan
</div>
@endsection
