@extends('layouts.master')
@section('title','個人OKR')
@section('script')
<script src="{{ asset('js/okr.js') }}" defer></script>
{{-- Chartjs --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js" charset="utf-8"></script>
<script src="{{ asset('js/chart.js') }}" defer></script>
<script src="{{ asset('js/editbtn.js') }}" defer></script>
@endsection
@section('content')
@include('okrs.list', ['actionlist'=>true,'admin' => $owner->id, 'routeSearch' => route('user.okr',$owner->id),
'routeObjectiveStore' => route('user.objective.store', auth()->user()->id)])
@endsection
