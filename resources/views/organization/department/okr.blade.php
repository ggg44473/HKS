@extends('layouts.master')
@section('title','部門OKR')
@section('content')
    @include('okrs.list', ['admin'=>$owner->user_id, 'routeObjectiveStore' => route('department.objective.store', $owner->id)]) 
@endsection