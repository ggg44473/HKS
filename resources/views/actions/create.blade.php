@extends('layouts.master')
@section('title','My OKR')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h4>新增 Action</h4>
            <a href="{{ route('user.okr', auth()->user()->id) }}" class="btn btn-info btn-sm">返回</a>
        </div>
        @include('actions.error',[$errors]) 
        <form method="POST" action="{{ route('actions.store') }}" enctype="multipart/form-data">
            @csrf
            @include('actions.form',[$user,$keyresults,$priorities,$action=false,]) 
            {{-- <div class="form-row ml-5">
                    <input type="hidden" class="form-control" name="krs_id" id="keyresult" value="{{ $keyresult->id }}">
                <div class="form-group col-md-4">
                    <label for="action_title">Action 具體作為</label>
                    <input type="text" class="form-control" name="act_title" id="action_title" value="">
                </div>
                <div class="form-group col-md-3">
                    <label for="started_at">起始日</label>
                    <input autocomplete="off" class="form-control" name="st_date" id="started_at" value="">
                </div>
                <div class="form-group col-md-3">
                    <label for="finished_at">完成日</label>
                    <input autocomplete="off" class="form-control" name="fin_date" id="finished_at" value="">
                </div>
                <div class="form-group col-md-2">
                <label for="priority">優先度</label>
                <select id="priority" class="form-control" name="priority" >
                    @foreach($priorities as $priority)
                    <option value="{{$priority->id}}">{{$priority->priority}}</option>
                    @endforeach
                </select>
                </div>
                <div class="form-group col-md-12">
                        <label for="action_content">內容</label>
                        <textarea class="form-control" id="action_content" rows="15" name="act_content" ></textarea>
                </div>
                <div class="form-group">
                    <label for="files">上傳附件</label>
                    <input type="file" class="form-group" name="files[]" id="files" multiple>
                </div>
                <button class="btn btn-primary btn-sm" type="submit">新增</button>
            </div>   --}}
        </form>
    </div>
</div>
@endsection

    