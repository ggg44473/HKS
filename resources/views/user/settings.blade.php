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
                    <hr>
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
@endsection
