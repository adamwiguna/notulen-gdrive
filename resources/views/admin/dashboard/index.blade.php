@extends('admin.layouts.app')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Dashboard</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
      <div class="btn-group me-2">
        <button type="button" class="btn btn-sm btn-outline-secondary">Share</button>
        <button type="button" class="btn btn-sm btn-outline-secondary">Export</button>
      </div>
      <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle">
        <span data-feather="calendar"></span>
        This week
      </button>
    </div>
  </div>

  {{-- <canvas class="my-4 w-100" id="myChart" width="900" height="380"></canvas> --}}

  <div class="chart-container">
    <div class="pie-chart-container">
      <canvas id="pie-chart"></canvas>
    </div>
  </div>

  <br>
  <br>
  <br>

  <div>
    <canvas id="myChart"></canvas>
  </div>

  <canvas width="971" height="485" style="display: block; box-sizing: border-box; height: 485px; width: 971px;"></canvas>

  <script>
    $(function(){
        //get the pie chart canvas
        var cData = JSON.parse(`<?php echo $data['chart_data']; ?>`);
        var ctx = $("#pie-chart");
        var array = {!! json_encode($bgcolor) !!};

        console.log(array);
        //pie chart data
        var data = {
          labels: cData.label,
          datasets: [
            {
              label: "Total Notulen",
              data: cData.data,
              backgroundColor: 
                array
              ,
              borderColor: [
              
              ],
              borderWidth: [1, 1, 1, 1, 1,1,1]
            }
          ]
        };
   
        //options
        var options = {
          responsive: true,
          title: {
            display: true,
            position: "top",
            text: "Notulen Yang Terkirim Tiap Instansi",
            fontSize: 18,
            fontColor: "#111"
          },
          legend: {
            display: true,
            position: "bottom",
            labels: {
              fontColor: "#333",
              fontSize: 16
            }
          }
        };
   
        //create Pie Chart class object
        var chart1 = new Chart(ctx, {
          type: "pie",
          data: data,
          options: options
        });
   
    });
  </script>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  const labels = [
    'January',
    'February',
    'March',
    'April',
    'May',
    'June',
  ];

  const data = {
    labels: labels,
    datasets: [
      {
        label: 'My First dataset',
        backgroundColor: 'rgb(255, 99, 132)',
        // borderColor: 'rgb(2, 3, 4)',
        data: [45, 30, 20, 5, 2, 10, 0],
       },
       {
        label: 'My Second dataset',
        backgroundColor: 'rgb(1, 99, 132)',
        // borderColor: 'rgb(1, 2, 3)',
        data: [0, 10, 5, 2, 20, 30, 45],
       },
    ]
  };

  const config = {
    type: 'line',
    data: data,
    options: {
      responsive: true,
      title: {
        display: true,
        position: "top",
        text: "Notulen Yang Terkirim Tiap Instansi",
        fontSize: 18,
        fontColor: "#111"
      },
      legend: {
        display: true,
        position: "bottom",
        labels: {
          fontColor: "#333",
          fontSize: 16
        }
      }
    }
  };
</script>

<script>
  const myChart = new Chart(
    document.getElementById('myChart'),
    config,
  );
</script>
      
@endsection