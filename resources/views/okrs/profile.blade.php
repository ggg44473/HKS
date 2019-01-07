@extends('layouts.master')
@section('title','個人綜覽')
@section('content')
<div class="container">
    <div class="row m-3">
        <div class="ml-4 mr-4">
            <form name="form" method="POST" action="{{ route('profile.update', auth()->user()->id) }}" enctype="multipart/form-data">
                @csrf
                {{ method_field('PATCH') }}
                <input type="file" name="avatar" id="fileSelect" style="display:none;" accept="image/gif, image/jpeg, image/png">
                <img id="avatarImg" class="avatar" src="{{ $user->avatar? asset('storage/avatar/'.$user->id.'/'.$user->avatar):asset('/img/icon/user/green.svg') }}" onclick="onloadphoto()">    
                <input name="submitAvatar" type="submit" style="display:none;">
            </form>
        </div>
        <div class="ml-2 pt-3">
            <h4>{{ $user->name }}</h4>
            <p>{{ $user->position.'   '.$user->created_at }}</p>
        </div>
        <div>
            <div class="dropdown">
                <i class="fas fa-award"></i>
                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Dropdown button
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item" href="#">Action</a>
                    <a class="dropdown-item" href="#">Another action</a>
                    <a class="dropdown-item" href="#">Something else here</a>
                </div>
            </div>
        </div>

    </div>
    @include('okrs.okr',$okrs)

@endsection