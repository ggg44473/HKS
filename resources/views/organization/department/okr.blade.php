@extends('layouts.master')
@section('title','部門OKR')
@section('content')
{!! \Session::put('redirect_url', \Request::getRequestUri()) !!}
@include('okrs.list', ['actionlist'=>false,'admin'=>$owner->user_id, 'routeSearch' =>
route('department.okr',$owner->id), 'routeObjectiveStore' => route('department.objective.store', $owner->id)])
@endsection
