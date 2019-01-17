@extends('layouts.master')
@section('title','個人OKR')
@section('content')
    @include('okrs.list', ['admin' => $owner->id, 'routeSearch' => route('user.okr',$owner->id), 'routeObjectiveStore' => route('user.objective.store', auth()->user()->id)]) 
@endsection