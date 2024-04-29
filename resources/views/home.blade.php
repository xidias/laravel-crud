@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 mb-4">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    @if($loggedInUser)
                        <p>Welcome, {{ $loggedInUser->name }}!</p>
                        <p>Your role is: {{ $loggedInUser->role }}</p>
                        {{ __('You are logged in!') }}
                    @else
                        <p>Welcome, guest!</p>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-8 mb-4">
            <div class="card">
                <div class="card-header">{{ __('Companies') }}</div>
                @if($loggedInUser)
                    <div class="card-body">
                        <p class="card-text">Manage companies information.</p>
                        <a href="{{route('company.list')}}" class="btn border-primary-subtle bg-primary-subtle">View Companies</a>
                    </div>
                @endif
            </div>
        </div>
        <div class="col-md-8 mb-4">
            <div class="card">
                <div class="card-header">{{ __('Employees') }}</div>
                @if ($loggedInUser)
                    <div class="card-body">
                        <p class="card-text">Manage employees information.</p>
                        <a href="{{route('employee.list')}}" class="btn border-primary-subtle bg-primary-subtle">View Employees</a>
                    </div>
                @endif
            </div>
        </div>
        <div class="col-md-8 mb-4">
            <div class="card">
                <div class="card-header">{{ __('Categories') }}</div>
                @if ($loggedInUser&&$loggedInUser->role=='admin')
                    <div class="card-body">
                        <p class="card-text">Manage company categories.</p>
                        <a href="{{route('category.list')}}" class="btn border-primary-subtle bg-primary-subtle">View Categories</a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
