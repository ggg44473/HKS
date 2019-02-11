@extends('layouts.master')
@section('title','個人行事曆')

@section('script')
<!-- Moment.js v2.23.0 -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.23.0/moment.min.js" defer></script>
<!-- FullCalendar v3.10.0 -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.0/fullcalendar.min.js" defer></script>
<!-- FullCalendar.js -->
<script src="{{ asset('js/calendar.js') }}" defer></script>
@endsection

@section('stylesheet')
<!-- FullCalendar v3.10.0 -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.0/fullcalendar.min.css" rel="stylesheet" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.0/fullcalendar.print.css" rel="stylesheet" media="print">
@endsection

@section('content')
<div class="container">
    <div classs="row">
        @if(count($errors)>0)
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{$error}}</li>
                @endforeach
            </ul>
        </div>
        @endif
        @if(Session::has('success'))
        <div>
            <p>{{Session::get('success')}}</p>
        </div>
        @endif
    </div>
    <select class="btn btn-primary mb-2" id="school_selector">
        <option class="btn-light" value="all">全部 All</option>
        <option class="btn-light" value="1">目標 Objective</option>
        <option class="btn-light" value="2">作為 Action</option>
        <option class="btn-light" value="3">行程 Activity</option>
    </select>
    <button id="copyBT" class="btn btn-secondary mb-2 btn-sm">複製ical日曆網址</button>
    <a id="icalcontent" href="{{route('calendar.ical')}}">{{route('calendar.ical')}}</a>
   
    <div id="calendar" data-uid="{{auth()->user()->id}}"></div>
    <form action="{{route('calendar.create', auth()->user()->id) }}" method="post">
        @csrf
        <div class="modal fade" tabindex="-1" role="dialog" id="mdlEvent">
            <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">新增行程</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group col-md-12">
                            <label for="title">內容</label>
                            <input type="text" class="form-control" name="title" id="title" placehoder="輸入行程" required>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="started_at">起始日</label>
                            <input autocomplete="off" class="form-control" name="st_date" id="started_at">
                        </div>
                        <div class="form-group col-md-12">
                            <label for="st_time">起始時間</label>
                            <input type="time" class="form-control" name="st_time" id="st_time">
                        </div>
                        <div class="form-group col-md-12">
                            <label for="finished_at">完成日</label>
                            <input autocomplete="off" class="form-control" name="fin_date" id="finished_at">
                        </div>
                        <div class="form-group col-md-12">
                            <label for="fin_time">完成時間</label>
                            <input type="time" class="form-control" name="fin_time" id="fin_time">
                        </div>
                        <div class="form-group col-md-12">
                            <label for="color">選擇顏色</label>
                            <input type="color" class="form-control" name="color" id="color" placehoder="選擇顏色" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="col-md-12 text-right">
                            <button class="btn btn-primary " type="submit" name="submit">新增</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
