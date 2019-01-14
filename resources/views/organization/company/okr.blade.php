@extends('layouts.master')
@section('title','公司OKR')
@section('content')
    @include('okrs.list', ['route' => 'company.objective.store']) 
@endsection