@extends('layouts.master')

@section('title','個人綜覽')

@section('script')
<script src="{{ asset('js/cropper.js') }}" defer></script>
<script src="{{ asset('js/avatar.js') }}" defer></script>  
@endsection

@section('content')
<div class="container">
    <div class="row m-3">
        <div class="ml-4 mr-4">
            <form id="avatarForm" name="form" method="POST" action="{{ route('user.update', auth()->user()->id) }}" enctype="multipart/form-data">
                @csrf
                {{ method_field('PATCH') }}
                <label class="label" data-toggle="tooltip" title="Change your avatar">
                    <img id="avatar" class="avatar" src="{{ $user->avatar? $user->avatar:asset('/img/icon/user/green.svg') }}">    
                    <input type="file" name="avatar" id="input" class="sr-only" accept="image/*"/>
                </label>
            </form>
        </div>
        <div class="ml-2 pt-3">
            <h4>{{ $user->name }}</h4>
            <p>{{ $user->position.'   '.$user->created_at }}</p>
        </div>
    </div>
</div>
<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title" id="modalLabel">Crop the image</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <div class="modal-body">
        <div class="img-container">
            <img id="image" src="">
        </div>
        </div>
        <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary" id="crop">Crop</button>
        </div>
    </div>
    </div>
</div>
@endsection