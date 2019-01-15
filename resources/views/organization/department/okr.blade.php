@extends('layouts.master')
@section('title','部門OKR')
@section('content')
    @include('okrs.list', ['admin'=>$owner->user_id, 'route' => route('department.objective.store', $owner->id)]) 
@endsection