@extends('layouts.master')
@section('script')
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
    @include('organization.department.show')
    <ul class="nav nav-tabs justify-content-center" id="myTab" role="tablist">
        @if (count($children) > 0)
        <li class="nav-item">
            <a class="nav-link active" id="department-tab" data-toggle="tab" href="#department" role="tab" aria-controls="department"
                aria-selected="true">子部門</a>
        </li>
        @endif
        <li class="nav-item">
            <a class="nav-link" href="{{ route('department.okr', $department) }}">OKRs</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="member-tab" href="{{ route('department.member', $department) }}">成員</a>
        </li>
    </ul>
    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="department" role="tabpanel" aria-labelledby="department-tab">
            <div id="departmentCard" class="row justify-content-md-center u-mt-16">
                @foreach ($children as $department)
                    @include('organization.department.card')
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
