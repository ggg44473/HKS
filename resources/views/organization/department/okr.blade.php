@extends('layouts.master')
@section('title','部門OKR')
@section('content')
    @include('okrs.list', ['route' => 'department.objective.store']) 
@endsection