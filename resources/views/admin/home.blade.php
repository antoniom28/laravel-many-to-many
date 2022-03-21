@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div class="d-flex flex-column align-items-center justify-content-center avatar">
                        @if(Auth::user()->avatar)
                            <div class="avatar-box">
                                <img src="{{ asset("storage/".Auth::user()->avatar) }}" alt="">
                            </div>
                        @else
                            <h1>CARICA UN AVATAR</h1>    
                        @endif
                    </div>
                    <div class="mt-4 text-center">
                        <u>{{ Auth::user()->name }}</u>
                        {{ __('You are logged in!') }}
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</div>
@endsection
