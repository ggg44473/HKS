@extends('layouts.master')
@section('title','部門OKR')
@section('content')
@include('okrs.list', ['actionlist'=>false,'admin'=>$owner->user_id, 'routeSearch' =>
route('department.okr',$owner->id), 'routeObjectiveStore' => route('department.objective.store', $owner->id)])
@endsection
