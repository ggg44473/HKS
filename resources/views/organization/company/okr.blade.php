@extends('layouts.master')
@section('script')
<script src="{{ asset('js/avatar.js') }}" defer></script>
<script src="{{ asset('js/tooltip.js') }}" defer></script>
<script src="{{ asset('js/circle-progress.min.js') }}" defer></script>
<script src="{{ asset('js/circleProgress.js') }}" defer></script>
<script src="{{ asset('js/editbtn.js') }}" defer></script>
{{-- Chartjs --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js" charset="utf-8"></script>
<script src="{{ asset('js/chart.js') }}" defer></script>
@endsection
@section('title','組織OKR')
@section('content')
<div class="container">
    @include('organization.company.show')
    <ul class="nav nav-tabs justify-content-center" id="myTab" role="tablist">
        <li class="nav-item">
            <a class="nav-link" id="department-tab" href="{{ route('company.index') }}">子部門</a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" id="okr-tab" data-toggle="tab" href="#okr" role="tab" aria-controls="okr"
                aria-selected="false">OKRs</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="member-tab" href="{{ route('company.member') }}">成員</a>
        </li>
    </ul>
    <div class="tab-pane fade show pl-sm-4 pr-sm-4">
        <div class="row m-3 pt-4 justify-content-center">
            <div class="col-auto">{{ $pageInfo['link'] }}</div>
            <div class="col-auto mb-2">
                <form action="{{ $company->getOKrRoute() }}" class="form-inline search-form">
                    <input autocomplete="off" class="form-control input-sm" name="st_date" id="filter_started_at" value=""
                        placeholder="起始日">
                    <input autocomplete="off" class="form-control input-sm ml-md-2" name="fin_date" id="filter_finished_at"
                        value="" placeholder="結算日">
                    <select name="order" class="form-control input-sm mr-md-2 ml-md-2">
                        <option value="">排序方式</option>
                        <option value="started_at_asc">起始日由近到遠</option>
                        <option value="started_at_desc">起始日由遠到近</option>
                        <option value="finished_at_asc">完成日由近到遠</option>
                        <option value="finished_at_desc">完成日由遠到近</option>
                        <option value="updated_at_asc">最近更新由近到遠</option>
                        <option value="updated_at_desc">最近更新由遠到近</option>
                    </select>
                    <button class="btn btn-primary">篩選</button>
                </form>
            </div>
        </div>
        @if ($company->okrs)
            @foreach($company->okrs as $okr)
                @include('okrs.okr', ['okr' => $okr, 'owner'=>$company])
            @endforeach
        @else
            <div id="dragCard" class="row justify-content-md-center u-mt-16">
                <div class="alert alert-warning alert-dismissible fade show u-mt-32" role="alert">
                    <strong><i class="fas fa-exclamation-circle pl-2 pr-2"></i></strong>
                    當前期間尚未建立OKR !!
                </div>
            </div>
        @endif
    </div>
    @can('storeObjective', $company)
        <a href="#" data-toggle="modal" data-target="#objective" class="newObjective"><img src="{{ asset('img/icon/add/lightgreen.svg') }}" alt=""></a>
        <div class="modal {{ count($errors) == 0 ? 'fade' : '' }}" id="objective" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">
                            <span>&times;</span>
                        </button>
                    </div>
                    @include('okrs.create', ['route'=>route('company.objective.store', $company->id)])
                </div>
            </div>
        </div>
    @endcan
</div>
@endsection
