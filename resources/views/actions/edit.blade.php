@extends('layouts.master')
@section('title','Edit Action')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <h4>編輯 Action</h4>
            <a href="{{ route('user.okr', auth()->user()->id) }}" class="btn btn-info btn-sm">返回</a>
        </div>
        @foreach($actions as $action)
        <form method="POST" action="{{ route('actions.update',$action->id) }}" enctype="multipart/form-data">
            @csrf
            {{ method_field('PATCH') }}
            <div class="form-row ml-5">
                <div class="form-group col-md-4">
                    <label for="action_title">Action 具體作為</label>
                    <input type="text" class="form-control" name="act_title" id="action_title" value="{{ $action->title }}">
                </div>
                <div class="form-group col-md-2">
                    <label for="started_at">起始日</label>
                    <input autocomplete="off" class="form-control" name="st_date" id="started_at" value="{{ $action->started_at }}">
                </div>
                <div class="form-group col-md-2">
                    <label for="finished_at">完成日</label>
                    <input autocomplete="off" class="form-control" name="fin_date" id="finished_at" value="{{ $action->finished_at }}">
                </div>
                <div class="form-group col-md-2">
                <label for="priority">標籤</label>
                <select id="priority" class="form-control" name="priority" >
                    <option selected>一般</option>
                    <option>緊急</option>
                    <option>除錯</option>
                    <option>功能</option>
                    <option>會議</option>
                </select>
                </div>
                <div class="form-group col-md-2">
                <label for="krs_id">關聯KR</label>
                    <select class="form-control" name="krs_id" id="keyresult" >
                        @foreach ($keyresults as $keyresult)
                            @if($keyresult->id==$action->related_kr)
                                <option selected value="{{ $keyresult->id }}">{{ $keyresult->title }}</option>
                            @else
                                <option value="{{ $keyresult->id }}">{{ $keyresult->title }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md-12">
                        <label for="action_content">內容</label>
                        <textarea class="form-control" id="action_content" rows="15" name="act_content" >{{ $action->content }}</textarea>
                </div>
                <div class="col-md-12">
                        @if(!empty($files))
                        @foreach($files as $file)
                        <a href="{{ route('actions.destroyFile',['id'=>$action->id,'file_path'=>$file]) }}"><i class="fas fa-times"></i></a>    
                        :
                            <a href="{{ route('download',['file'=>$file,'action_id'=>$action->id]) }}" >
                            {{ $file }}
                            </a>  |
                        @endforeach
                    @endif
                </div>
                <div class="form-group col-md-11">
                    <label for="files">上傳附件</label>
                    <input type="file" class="form-group" name="files[]" id="files" multiple>
                </div>

                <button class="btn btn-primary btn-sm mb-1 mt-1 " type="submit">修改</button>
            </div>  
        </form>
        @endforeach
    </div>
</div>
@endsection

    