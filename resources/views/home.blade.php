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

                    {{ __('You are logged in!') }}
                </div>
            </div>
        </div>
        <div class="col-md-8 mb-4">
            <div class="card">
                <div class="card-header">{{ __('Companies') }}</div>
                <div class="card-body">
                <p class="card-text">Manage companies information.</p>
                <a href="{{route('company.list')}}" class="btn btn-primary">View Companies</a>
            </div>
        </div>
    </div>
    <div class="col-md-8 mb-4">
        <div class="card">
            <div class="card-header">{{ __('Employees') }}</div>
                <div class="card-body">
                <p class="card-text">Manage employees information.</p>
                <a href="{{route('employee.list')}}" class="btn btn-primary">View Employees</a>
                </div>
        </div>
    </div>
    <div class="col-md-8 mb-4">
        <div class="card">
            <div class="card-header">{{ __('Categories') }}</div>
                <div class="card-body">
                    <p class="card-text">Manage company categories.</p>
                    <a href="{{route('category.list')}}" class="btn btn-primary">View Categories</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
