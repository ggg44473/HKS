@extends('layouts.master')
@section('title','My OKR')
@section('content')
<div class="container">
    <div class="row m-3">
        @if (auth()->user() == $user)
            <div class="col-md-3 font-weight-light"><h4>My OKR</h4> </div>
            <div class="col-md-5 offset-md-4 text-right">
                <a href="{{ route('objective.create') }}" class="btn btn-primary" data-toggle="modal" data-target="#objective"><i class="fa fa-plus fa-sm"></i> 新增目標</a>
                <div class="btn-group">
                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-history fa-sm"></i> 歷史紀錄
                    </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="#">2018  Q1</a>
                        <a class="dropdown-item" href="#">2018  Q2</a>
                        <a class="dropdown-item" href="#">2018  Q3</a>
                        <a class="dropdown-item" href="#">2018  Q4</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#">2017</a>
                    </div>                        
                </div>
            </div>
        @else
            <div class="col-md-2 text-right">
                <img class="avatar" src="{{ $user->avatar? asset($user->avatar):asset('/img/icon/user/green.svg') }}">    
            </div>
            <div class="col-md-10 font-weight-light align-self-end"><h4>{{ $user->name }}</h4> </div>

            
        @endif  
    </div>
    <!-- Modal -->
    <div id='app'> 
        <div class="modal {{ count($errors) == 0 ? 'fade' : '' }}" id="objective" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">
                            <span>&times;</span>
                        </button>
                    </div>
                    @include('okrs.create') 
                </div>
            </div>
        </div>
    </div>
    @include('okrs.okr',$okrs)
@endsection






