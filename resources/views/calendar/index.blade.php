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
    <div id="calendar">
    </div>
</div>
@endsection
