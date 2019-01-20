@extends('layouts.master')
@section('script')
    <script src="{{ asset('js/organization.js') }}" defer></script>
@endsection
@section('title','組織OKR')
@section('content')
    <div class="container">
        @if (auth()->user()->company_id)
            @include('organization.company.show')
            <hr/>
            <div class="row justify-content-md-center u-mt-16">
                @foreach ($departments as $department)
                    @include('organization.department.show', ['show'=>true])
                @endforeach
            </div>
        @else
            @include('organization.company.create')
        @endif
    </div>
@endsection