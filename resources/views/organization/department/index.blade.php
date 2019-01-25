@extends('layouts.master')
@section('script')
    <script src="{{ asset('js/organization.js') }}" defer></script>
@endsection
@section('title','組織OKR')
@section('content')
    <div class="container">
        <a href="{{ $parent? route('department.index', $parent):route('company.index') }}" class="btn btn-primary">返回上層</a>
        <div class="row justify-content-md-center u-mt-16">
            @include('organization.department.show',['department'=>$department, 'show'=>false])
        </div>
        <hr/>
        <div class="row justify-content-md-center u-mt-16" id="items-list" class="moveable">
            @foreach ($children as $department)
                @include('organization.department.show', ['show'=>true])
            @endforeach
        </div>
    </div>
@endsection