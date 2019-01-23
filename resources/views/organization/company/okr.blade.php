@extends('layouts.master')
@section('title','公司OKR')
@section('content')
{!! \Session::put('redirect_url', \Request::getRequestUri()) !!}
@include('okrs.list', ['actionlist'=>false,'admin' => $owner->user_id, 'routeSearch' =>
route('company.okr',$owner->id), 'routeObjectiveStore' => route('company.objective.store', $owner->id)])
@endsection
