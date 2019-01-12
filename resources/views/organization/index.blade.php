@extends('layouts.master')
@section('script')
    <script src="{{ asset('js/organization.js') }}" defer></script>
@endsection
@section('title','組織OKR')
@section('content')
    <div class="container">
        @if (auth()->user()->department_id)
            
        @else
            <div class="row justify-content-md-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-body">
                            <div class="avatar bg-primary text-center">
                                <i class="fas fa-building text-white"></i>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
        @endif
        
    </div>
@endsection