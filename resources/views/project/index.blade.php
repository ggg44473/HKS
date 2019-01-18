@extends('layouts.master')
@section('script')

@endsection
@section('title','專案綜覽')
@section('content')
<div class="container">
    <div class="row m-3">
        <div class="col-md-7">
            <h4>Project</h4>
        </div>
    </div>
    <div class="row">
        {{-- @foreach ($collection as $item) --}}
            <div class="col-md-6 u-mb-16">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-3 text-center">名稱</div>
                            <div class="col-9">專案名稱</div>
                        </div>
                        <div class="row">
                            <div class="col-3 text-center">簡介</div>
                            <div class="col-9">專案名稱</div>
                        </div>
                        <hr class="u-mb-16">
                        <div class="row">
                            <div class="col-3 text-center">
                                <span class="font-weight-bold" style="font-size:14px;">O</span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-3 text-center">
                                <span class="font-weight-bold" style="font-size:14px;">KR</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 u-mb-16">
                <div class="card">
                    <div class="card-body">
                        <h4>Project</h4>
                    </div>
                </div>
            </div>
            <div class="col-md-6 u-mb-16">
                <div class="card">
                    <div class="card-body">
                        <h4>Project</h4>
                    </div>
                </div>
            </div>
            <div class="col-md-6 u-mb-16">
                <div class="card">
                    <div class="card-body">
                        <h4>Project</h4>
                    </div>
                </div>
            </div>
        {{-- @endforeach --}}
    </div>
    <div class="row m-3">
        <div class="col-md-7">
            <h4>Closed</h4>
        </div>
    </div>
    <div class="row">
        
    </div>
</div>
@endsection
