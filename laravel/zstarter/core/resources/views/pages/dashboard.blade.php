@extends('backend.layouts.main') 
@section('title', 'Dashboard')
@section('content')
    <div class="container-fluid">
        {{-- @if (auth()->user()->roles[0]->name == 'Admin' && Auth::user()->status != 3)
        @endif --}}
        @if(auth()->check())    
            @if(auth()->user()->roles[0]->name == 'Super Admin')
                @include('backend.dashboard.developer')
            @elseif(auth()->user()->roles[0]->name == 'Admin')
               @include('backend.dashboard.admin')
            {{-- @elseif(auth()->user()->roles[0]->name == 'Admin')
               @include('backend.dashboard.manager') --}}
            @else
                @include('backend.dashboard.user')
            @endif  
        @endif
    </div>
	
    
  
@endsection