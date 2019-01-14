@extends('layouts.master')
@section('title','部門OKR')
@section('content')
    @include('okrs.list', ['admin'=>$owner->user_id,'image'=>'/img/icon/building/g.svg', 'route' => route('department.objective.store', $owner->id)]) 
@endsection