@extends('layouts.core')

@section('content')

  <div class="row">
    <div class="col-12 grid-margin">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title">Monthly Analytics</h4>
          <p class="card-description">Products that are creating the most revenue and their sales throughout the year and the variation in behavior of sales.</p>
          <div id="js-legend" class="chartjs-legend mt-4 mb-5 analytics-legend"></div>
          <div class="demo-chart">
            <canvas id="dashboard-monthly-analytics"></canvas>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
