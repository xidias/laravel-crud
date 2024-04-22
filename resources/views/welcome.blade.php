@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row">
      <div class="col-md-4">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Companies</h5>
            <p class="card-text">Manage companies information.</p>
            <a href="{{route('company.list')}}" class="btn btn-primary">View Companies</a>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Employees</h5>
            <p class="card-text">Manage employees information.</p>
            <a href="{{route('employee.list')}}" class="btn btn-primary">View Employees</a>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Categories</h5>
            <p class="card-text">Manage company categories.</p>
            <a href="{{route('category.list')}}" class="btn btn-primary">View Categories</a>
          </div>
        </div>
      </div>
    </div>


    <hr>

    <div class="row mt-5">
      <div class="col-md-12">
        <h2>About Us</h2>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur euismod suscipit felis, vitae malesuada eros vulputate sit amet.</p>
        <p>Etiam luctus justo in lectus iaculis gravida. Suspendisse potenti. Morbi quis ex arcu.</p>
      </div>
    </div>
  </div>
@endsection
