@extends('layouts.master')
@section('title','公司OKR')
@section('content')
    @include('okrs.list', ['admin' => $owner->user_id,'image'=>'/img/icon/building/g.svg', 'route' => route('company.objective.store', $owner->id)]) 
@endsection