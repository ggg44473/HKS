@extends('layouts.master')
@section('script')
<script src="{{ asset('js/tooltip.js') }}" defer></script>
<script src="{{ asset('js/avatar.js') }}" defer></script>
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
            <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile"
                aria-selected="false">OKRs</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact"
                aria-selected="false">成員</a>
        </li>
    </ul>
    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="department" role="tabpanel" aria-labelledby="department-tab">
            <div class="row justify-content-md-center u-mt-16">
                @foreach ($departments as $department)
                @include('organization.department.show', ['show'=>true])
                @endforeach
            </div>
        </div>
        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
            
        </div>
        <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">...</div>
    </div>


    @else
    @foreach ($invitations as $invitation)
    @include('organization.company.invitation')
    @endforeach
    @include('organization.company.create')
    @endif
</div>
@endsection
