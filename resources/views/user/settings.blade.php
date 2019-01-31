@extends('layouts.master')
@section('title','個人綜覽')
@section('script')
<script src="{{ asset('js/avatar.js') }}" defer></script>
@endsection

@section('stylesheet')
@endsection

@section('content')
<div class="container">
    <div class="row m-3 justify-content-center pb-4">
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
        <h4 class="col-md-10">基本資料<hr class="u-mt-8"></h4>
        <div class="col-md-10">
            <div class="row">
                <div class="col-auto">
                    <a class="u-ml-8 u-mr-8" href="#">
                        <img src="{{ $user->getAvatar() }}" alt="" class="avatar text-center bg-white">
                    </a>
                </div>
                <div class="col-auto align-self-center text-truncate">
                    <a href="#">
                        <p class="mb-0 font-weight-bold text-truncate">{{ $user->name }}</p>
                        <p class="mb-0 text-truncate">{{ $user->email }}</p>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="row m-3 justify-content-center pb-4 pt-4">
        <h4 class="col-md-10">帳號設定<hr class="u-mt-8"></h4>
        <div class="col-md-10">
            <div class="row">
                <div class="col-2 align-self-center text-truncate text-right">
                    <span class="mb-0 font-weight-bold text-truncate text-primary pr-4"><i class="fas fa-envelope"></i>Ｅmail</span>
                </div>
                <div class="col-8">
                    <span class="mb-0 text-truncate text-black-50">{{ $user->email }}</span>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-2 align-self-center text-truncate text-right">
                    <span class="mb-0 font-weight-bold text-truncate text-primary pr-4"><i class="fas fa-lock"></i> Password</span>
                </div>
                <div class="col-8">
                    <a class="mb-0" href="#" data-toggle="modal" data-target="#resetPassword" >變更密碼</a>
                </div>
            </div>
        </div>
    </div>
    <div class="row m-3 justify-content-center pt-4">
        <h4 class="col-md-10 u-mb-8">帳號權限</h4>
        <div class="col-md-10">
            <table class="table table-hover text-center">
                <thead>
                    <tr>
                    <th scope="col">tpye</th>
                    <th scope="col">name</th>
                    <th scope="col">permission</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>公司</td>
                        <td>{{ $user->company->name }}</td>
                        <td>{{ $user->role($user->company)->name }}</td>
                    </tr>
                    <tr>
                        <td>部門</td>
                        <td>{{ $user->department?$user->department->name:'-' }}</td>
                        <td>{{ $user->department?$user->role($user->department)->name:'-' }}</td>
                    </tr>
                    @foreach ($user->projects as $project)
                        <tr>
                            <td>專案</td>
                            <td>{{ $project->name }}</td>
                            <td>{{ $user->role($project)->name }}</td>
                        </tr>
                    @endforeach
                    
                </tbody>
                </table>
        </div>
    </div>
    {{-- <div class="row justify-content-center"> --}}
        
        {{-- <div class="col-md-6">
            <form name="form" method="POST" action="{{ route('user.update', auth()->user()->id) }}" enctype="multipart/form-data">
                @csrf {{ method_field('PATCH') }}

                <div class="u-pl-32 u-pr-32 form-group row">
                    <div class="col-12">
                        <span class="u-pl-8 u-pr-8">帳號</span>
                        <span class="u-pl-8 u-pr-8">{{ $user->email }}</span>
                    </div>
                </div>
                <div class="u-pl-32 u-pr-32 form-group row">
                    <div class="col-12">
                        <span class="u-pl-8 u-pr-8">姓名</span>
                        <input type="text" class="u-pl-8 u-pr-8" name="name" id="name" value="{{ $user->name }}" style="color: #495057; border: 1px solid #ced4da; background-color: #fff;">
                    </div>
                </div>
                <div class="u-pl-32 u-pr-32 u-pt-16 u-pb-16 form-group row">
                    <div class="col-12">
                        <span for="avatar" class="u-pl-8 u-pr-8">頭像</span>
                        <img id="avatar" class="avatar" src="{{ $user->getAvatar() }}">
                        <input type="file" class="u-ml-8 u-mr-8 align-self-bottom" id="input" name="avatar" value="{{ $user->name }}"
                            accept="image/*">
                    </div>
                </div>

                @if ($user->compan)
                <div class="u-pl-32 u-pr-32 form-group row">
                    <div class="col-12">
                        <span class="u-pl-8 u-pr-8">組織</span>
                        <span class="u-pl-8 u-pr-8">{{ $user->company->name }}</span>
                    </div>
                </div>
                @endif

                @if ($user->department)
                <div class="u-pl-32 u-pr-32 form-group row">
                    <div class="col-12">
                        <span class="u-pl-8 u-pr-8">部門</span>
                        <span class="u-pl-8 u-pr-8">{{ $user->department->name }}</span>
                    </div>
                </div>
                @endif

                @if ($user->position)
                <div class="u-pl-32 u-pr-32 form-group row">
                    <div class="col-12">
                        <span class="u-pl-8 u-pr-8">職稱</span>
                        <span class="u-pl-8 u-pr-8">{{ $user->position }}</span>
                    </div>
                </div>
                @endif

                <div class="u-pl-32 u-pr-32 form-group row justify-content-end">
                    <div class="col-2">
                        <button type="submit" class="btn btn-primary">變更</button>
                    </div>
                </div>
            </form>
        </div> --}}
    {{-- </div> --}}
</div>
{{-- 重設密碼modal --}}
<div class="modal fade " id="resetPassword" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row pb-4">
                    <div class="col-12 text-center font-weight-bold"><h5>變更密碼</h5></div>
                </div>
                <form method="POST" action="{{ route('user.resetPassword') }}" enctype="multipart/form-data">
                    @csrf
                    {{-- 舊密碼 --}}
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label class="text-primary" for="current_password">現在密碼<strong class="invalid-feedback"></strong></label>
                                <input type="password" class="form-control {{ $errors->has('current_password') ? ' is-invalid' : '' }}" id="current_password" name="current_password" placeholder="請輸入現在密碼">
                                @if ($errors->has('current_password'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('current_password') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    {{-- 新設密碼 --}}    
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label class="text-primary" for="password">新設密碼<strong class="invalid-feedback"></strong></label>
                                <input type="password" class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}" id="password" name="password" placeholder="請輸入新設密碼">
                                @if ($errors->has('password'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    {{-- 新設密碼 --}}    
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label class="text-primary" for="password_confirmation">新設密碼確認<strong class="invalid-feedback"></strong></label>
                                <input type="password" class="form-control {{ $errors->has('password_confirmation') ? ' is-invalid' : '' }}" id="password_confirmation" name="password_confirmation" placeholder="請確認新設密碼">
                                @if ($errors->has('password_confirmation'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('password_confirmation') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                    </div>
 
                    {{-- 建立按鈕 --}}
                    <div class="form-row u-mt-16 u-mb-32 justify-content-end">
                        <div class="form-group">
                            <button class="btn btn-primary" type="submit">變更</button>   
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
