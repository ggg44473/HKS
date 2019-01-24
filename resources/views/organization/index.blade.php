@extends('layouts.master')
@section('script')
<script src="{{ asset('js/tooltip.js') }}" defer></script>
<script src="{{ asset('js/avatar.js') }}" defer></script>
<script src="{{ asset('js/circle-progress.js') }}" defer></script>
<script src="{{ asset('js/circleProgress.js') }}" defer></script>
<script src="{{ asset('js/organization.js') }}" defer></script>
@endsection
@section('title','組織OKR')
@section('content')
<div class="container">
    @if (auth()->user()->company_id)
    @include('organization.company.show')
    <ul class="nav nav-tabs justify-content-center" id="myTab" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="department-tab" data-toggle="tab" href="#department" role="tab" aria-controls="department"
                aria-selected="true">子部門</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="okr-tab" data-toggle="tab" href="#okr" role="tab" aria-controls="okr"
                aria-selected="false">OKRs</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="member-tab" data-toggle="tab" href="#member" role="tab" aria-controls="member"
                aria-selected="false">成員</a>
        </li>
    </ul>
    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="department" role="tabpanel" aria-labelledby="department-tab">
            <div class="row justify-content-md-center u-mt-16">
                @if (count($departments) == 0)
                    <div class="alert alert-warning alert-dismissible fade show u-mt-32" role="alert">
                        <strong><i class="fas fa-exclamation-circle pl-2 pr-2"></i></strong>
                        尚未建立子部門 !!
                    </div>
                @endif
                @foreach ($departments as $department)
                    @include('organization.department.show', ['show'=>true])
                @endforeach
            </div>
        </div>
        <div class="tab-pane fade" id="okr" role="tabpanel" aria-labelledby="profile-tab">
            
        </div>
        <div class="tab-pane fade" id="member" role="tabpanel" aria-labelledby="contact-tab">...</div>
    </div>

    @else
    @foreach ($invitations as $invitation)
    @include('organization.company.invitation')
    @endforeach
    @include('organization.company.create')
    @endif
</div>
@endsection
