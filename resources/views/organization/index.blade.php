@extends('layouts.master')
@section('script')
    <script src="{{ asset('js/organization.js') }}" defer></script>
@endsection
@section('title','組織OKR')
@section('content')
    <div class="container">
        @if (auth()->user()->company_id)
            <div class="row justify-content-md-center">
                <div class="col-md-4">
                    <a class="row" href="{{ route('company.okr', $company->id) }}">
                        <div class="col-md-3">
                            <div class="avatar text-center organizationIcon bg-white">
                                <i class="fas fa-building text-primary"></i>
                            </div>
                        </div>
                        <div class="col-md-9 align-self-center">
                            <p class="mb-0 font-weight-bold">公司名稱: {{ $company->name }}</p>
                            <p class="mb-0">{{ $company->description }}</p>
                        </div>
                    </a>
                </div>
            </div>
        @else
            <div class="row justify-content-md-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-body">
                            <div class="row u-margin-16 u-mt-32 u-ml-32">
                                <div class="col-md-12"><h5>建立新的組織?</h5></div>
                            </div>
                            <form method="POST" action="{{ route('company.store') }}">
                                @csrf
                                <div class="row u-ml-16 u-mr-16">
                                    <div class="col-md-12 align-self-center">
                                        <input id="companyImgUpload" name="company_img_upload" type="file" class="u-hidden" accept="image/*"/>
                                        <img id="companyImg" class="avatar u-hidden u-margin-16" src="" alt="">
                                        <div id="companyIcon" class="avatar text-center companyIcon">
                                            <i class="fas fa-building text-white"></i>
                                            <i class="fas fa-upload text-white"></i>
                                        </div>
                                        <div class="form-group u-ml-16" style="display:inline-block">
                                            <label for="company_name">組織名稱<strong class="invalid-feedback"></strong></label>
                                            <input type="text" name="company_name" id="company_name" value="" placeholder="請輸入組織名稱" class="form-control {{ $errors->has('company_name') ? ' is-invalid' : '' }}" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row u-ml-32 u-mr-32">
                                    <div class="col-md-12">
                                        <div class="form-row">
                                            <div class="form-group col-md-12">
                                                <label for="company_description">組織概述<strong class="invalid-feedback"></strong></label>
                                                <textarea type="text" name="company_description" id="company_description" value="" placeholder="請輸入組織概述" class="form-control {{ $errors->has('company_description') ? ' is-invalid' : '' }}" required></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- <search-component></search-component> --}}
                                <div class="form-row u-ml-32 u-mr-32 u-mb-32 justify-content-end">
                                    <div class="form-group u-pl-16 u-pr-16">
                                        <button class="btn btn-primary" type="submit">下一步</button>   
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection