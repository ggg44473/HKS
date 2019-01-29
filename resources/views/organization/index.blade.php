@extends('layouts.master')
@section('script')
<script src="{{ asset('js/avatar.js') }}" defer></script>
<script src="{{ asset('js/tooltip.js') }}" defer></script>
<script src="{{ asset('js/circle-progress.min.js') }}" defer></script>
<script src="{{ asset('js/circleProgress.js') }}" defer></script>
<script src="{{ asset('js/dragula.js') }}" defer></script>
<script src="{{ asset('js/dragDrop.js') }}" defer></script>
@endsection
@section('stylesheet')
<link href="{{ asset('css/dragula.css') }}" rel="stylesheet" />    
@endsection
@section('title','組織架構')
@section('content')
<div class="container">
    @can('create', App\Company::class)
        @foreach ($invitations as $invitation)
            @include('organization.company.invitation')
        @endforeach
        @include('organization.company.create')
    @endcan
    @cannot('create', App\Company::class)
        @include('organization.company.show')
        <ul class="nav nav-tabs justify-content-center" id="myTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="department-tab" data-toggle="tab" href="#department" role="tab" aria-controls="department"
                    aria-selected="true">子部門</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('company.okr') }}">OKRs</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="member-tab" href="{{ route('company.member') }}">成員</a>
            </li>
        </ul>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="department" role="tabpanel" aria-labelledby="department-tab">
                <div id="dragCard" class="row justify-content-md-center u-mt-16">
                    @if (count($departments) == 0)
                        <div class="alert alert-warning alert-dismissible fade show u-mt-32" role="alert">
                            <strong><i class="fas fa-exclamation-circle pl-2 pr-2"></i></strong>
                            尚未建立子部門 !!
                        </div>
                    @endif
                    @foreach ($departments as $department)
                        @include('organization.department.card')
                    @endforeach
                </div>
            </div>
        </div>
    @endcannot
</div>
@endsection
