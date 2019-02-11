@extends('layouts.master')
@section('title','個人綜覽')
@section('script')
<script src="{{ asset('js/avatar.js') }}" defer></script>
<script src="{{ asset('js/circle-progress.min.js') }}" defer></script>
<script src="{{ asset('js/circleProgress.js') }}" defer></script>
<script src="{{ asset('js/setting.js') }}" defer></script>
@endsection

@section('stylesheet')
<link href="{{ asset('css/dragula.css') }}" rel="stylesheet"/>
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center pb-4">
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
        <h4 class="col-md-10">基本資料
            <hr class="u-mt-8">
        </h4>
        <div class="col-md-10">
            <div class="row">
                <div class="col-auto align-self-center">
                    <form id="avatarForm" name="form" method="POST" action="{{ route('user.update', auth()->user()->id) }}" enctype="multipart/form-data">
                        @csrf {{ method_field('PATCH') }}
                        <a id="avatar" class="u-ml-8 u-mr-8" href="#">
                            <img class="avatar u-margin-16 avatarImg" src="{{ $user->getAvatar() }}" alt="">
                            <img class="avatar u-hidden u-margin-16 avatarImgUpload" src="/img/icon/upload/gray.svg" alt="">
                        </a>
                        <input type="file" class="u-hidden" id="input" name="avatar" value="{{ $user->name }}" accept="image/*">
                    </form>
                </div>
                <div class="col align-self-center text-truncate">
                    <form id="userForm" name="form" method="POST" action="{{ route('user.update', auth()->user()->id) }}" enctype="multipart/form-data">
                        @csrf {{ method_field('PATCH') }}
                        <p class="mb-0 font-weight-bold text-truncate">
                            <span class="name">{{ $user->name }}</span>
                            <input type="text" class="u-hidden name-input" name="name" id="name" value="{{ $user->name }}" style="color: #495057; border: 1px solid #ced4da; background-color: #fff;">
                            <span class="pl-4 font-weight-normal" style="font-size:14px">{{ $user->position }}</span>
                        </p>
                        <p class="mb-0 text-truncate text-black-50 motto" style="font-size:14px">{{ $user->description }}</p>
                        <input type="text" class="{{ $user->description?'u-hidden':'' }} motto-input w-75 pt-2" name="description" id="description" value="{{ $user->description }}" placeholder="請輸入座右銘" style="color: #495057; border: 1px solid #ced4da; background-color: #fff;">
                    </form>
                </div>
                <div class="row col-md-6 pt-4">
                    <div class="col-4 text-center mb-4">
                        <div class="circle circle-1" data-value="{{ $user->complianceRate()[3] }}" style="position:absolute; top: 35%; left:50%; transform: translate(-50%, -50%);"></div>
                        <div class="circle circle-2" data-value="{{ $user->complianceRate()[2] }}" style="position:absolute; top: 35%; left:50%; transform: translate(-50%, -50%);"></div>
                        <div class="circle circle-3" data-value="{{ $user->complianceRate()[1] }}" style="position:absolute; top: 35%; left:50%; transform: translate(-50%, -50%);"></div>
                        <div class="circle circle-4" data-value="{{ $user->complianceRate()[0] }}" style="position:absolute; top: 35%; left:50%; transform: translate(-50%, -50%);"></div>
                        <div style="position:absolute; top: 35%; left:50%; transform: translate(-50%, -50%);">
                            <div class="row">
                                <div class="col-auto pl-0 pr-0 align-self-center">
                                    <span>{{ $user->complianceRateAvg() }}％</span><br>
                                    <span style="font-size:4px">達成率</span>
                                </div>
                            </div>
                        </div>
                        <div class="text-black-50" style="position:absolute; bottom: 0; left:50%; transform: translate(-50%, -50%);">Objective</div>
                    </div>
                    <div class="col-4 text-center mb-4">
                        <div class="circle circle-1" data-value="{{ $actionComplianceRate['all']!=0? $actionComplianceRate['complete']/$actionComplianceRate['all'] : 0 }}" style="position:absolute; top: 35%; left:50%; transform: translate(-50%, -50%);"></div>
                        <div class="circle circle-4" data-value="{{ $actionComplianceRate['all']!=0? $actionComplianceRate['delay']/$actionComplianceRate['all'] : 0  }}" style="position:absolute; top: 35%; left:50%; transform: translate(-50%, -50%);"></div>
                        <div style="position:absolute; top: 35%; left:50%; transform: translate(-50%, -50%);">
                            <div class="row">
                                <div class="col-auto pl-0 pr-0 align-self-center">
                                    <span>{{ $actionComplianceRate['complete'] }}</span><br>
                                    <span style="font-size:4px">完成</span>
                                </div>
                                <div class="col-auto pl-1 pr-1 ">/</div>
                                <div class="col-auto pl-0 pr-0 align-self-center">
                                    <span>{{ $actionComplianceRate['all'] }}</span><br>
                                    <span style="font-size:4px">總數</span>
                                </div>
                            </div>
                        </div>
                        <div class="text-black-50" style="position:absolute; bottom: 0; left:50%; transform: translate(-50%, -50%);">Action</div>
                    </div>
                    <div class="col-4 text-center mb-4" style="height: 120px;">
                        <div class="circle circle-1" data-value="{{ count($user->projects)!=0?count($user->projects()->where('isdone',true)->get())/count($user->projects):0 }}" style="position:absolute; top: 35%; left:50%; transform: translate(-50%, -50%);"></div>
                        <div style="position:absolute; top: 35%; left:50%; transform: translate(-50%, -50%);">
                            <div class="row">
                                <div class="col-auto pl-0 pr-0 align-self-center">
                                    <span>{{ count($user->projects()->where('isdone',true)->get()) }}</span><br>
                                    <span style="font-size:4px">完成</span>
                                </div>
                                <div class="col-auto pl-1 pr-1 ">/</div>
                                <div class="col-auto pl-0 pr-0 align-self-center">
                                    <span>{{ count($user->projects) }}</span><br>
                                    <span style="font-size:4px">總數</span>
                                </div>
                            </div>
                        </div>
                        <div class="text-black-50" style="position:absolute; bottom: 0; left:50%; transform: translate(-50%, -50%);">Project</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row justify-content-center pb-4 pt-4">
        <h4 class="col-md-10">帳號設定
            <hr class="u-mt-8">
        </h4>
        <div class="col-md-10">
            <div class="row ml-2">
                <div class="col-auto text-primary"><i class="fas fa-envelope"></i></div>
                <div class="align-self-center text-truncate text-center" style="width:90px;">
                    <span class="mb-0 font-weight-bold text-truncate text-primary pr-4">Ｅmail</span>
                </div>
                <div class="col-auto">
                    <span class="mb-0 text-truncate text-black-50">{{ $user->email }}</span>
                </div>
            </div>
            <div class="row mt-2 ml-2">
                <div class="col-auto text-primary"><i class="fas fa-lock"></i></div>
                <div class="align-self-center text-truncate text-center" style="width:90px;">
                    <span class="mb-0 font-weight-bold text-truncate text-primary pr-4">Password</span>
                </div>
                <div class="col-auto">
                    <a class="mb-0" href="#" data-toggle="modal" data-target="#resetPassword">變更密碼</a>
                </div>
            </div>
        </div>
    </div>
    <div class="row justify-content-center pt-4">
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
                        <td class="align-middle">公司</td>
                        <td class="align-middle">{{ isset($user->company)?$user->company->name:'-' }}</td>
                        <td class="align-middle">{{ isset($user->company)?$user->role($user->company)->name:'-' }}</td>
                    </tr>
                    <tr>
                        <td class="align-middle">部門</td>
                        <td class="align-middle">{{ isset($user->department) && $user->department?$user->department->name:'-' }}</td>
                        <td class="align-middle">{{ isset($user->department) && $user->department?$user->role($user->department)->name:'-' }}</td>
                    </tr>
                    @foreach ($user->projects as $project)
                    <tr>
                        <td class="align-middle">專案</td>
                        <td class="align-middle">{{ isset($project->name)?$project->name:'-' }}</td>
                        <td class="align-middle">{{ isset($project->name)?$user->role($project)->name:'-' }}</td>
                    </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>
    <div class="row justify-content-center pb-4 pt-4">
        <h4 class="col-md-10">紛絲人數・{{ count($user->follower) }}
            <hr class="u-mt-8">
        </h4>
        <div class="col-md-10 text-center">
            @for ($i = 0; $i < count($user->follower); $i++)
                <img src="{{ $user->follower[$i]->user->getAvatar() }}" alt="" class="avatar-sm m-2">
            @endfor
        </div>
    </div>
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
                    <div class="col-12 text-center font-weight-bold">
                        <h5>變更密碼</h5>
                    </div>
                </div>
                <form method="POST" action="{{ route('user.resetPassword') }}" enctype="multipart/form-data">
                    @csrf
                    {{-- 舊密碼 --}}
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label class="text-primary" for="current_password">現在密碼<strong class="invalid-feedback"></strong></label>
                                <input type="password" class="form-control {{ $errors->has('current_password') ? ' is-invalid' : '' }}"
                                    id="current_password" name="current_password" placeholder="請輸入現在密碼">
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
                                <input type="password" class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}"
                                    id="password" name="password" placeholder="請輸入新設密碼">
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
                                <input type="password" class="form-control {{ $errors->has('password_confirmation') ? ' is-invalid' : '' }}"
                                    id="password_confirmation" name="password_confirmation" placeholder="請確認新設密碼">
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
