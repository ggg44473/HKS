@extends('layouts.master')
@section('title','個人OKR')
@section('content')
    @include('okrs.list', ['admin' => $owner->id, 'image'=>'/img/icon/user/green.svg', 'route' => route('user.objective.store', auth()->user()->id)]) 
@endsection