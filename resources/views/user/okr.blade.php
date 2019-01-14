@extends('layouts.master')
@section('title','個人OKR')
@section('content')
    @include('okrs.list', ['route' => route('user.objective.store', auth()->user()->id)]) 
@endsection