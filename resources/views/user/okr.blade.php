@extends('layouts.master')
@section('title','個人OKR')
@section('content')
    @include('okrs.list', ['route' => 'user.objective.store']) 
@endsection