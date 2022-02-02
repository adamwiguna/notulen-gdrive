@extends('admin.layouts.app')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Dashboard</h1>
</div>
    <div class="row">

      <div class="col-xl-3 col-md-6 mb-4">
          <a href="/admin/position?canShare=false&canReceive=false&free=true" class=" text-decoration-none text-secondary">
          <div class="card border-3 border-primary shadow h-100">
              <div class="card-body">
                  <div class="row no-gutters align-items-center">
                      <div class="col mr-2">
                          <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                              Jabatan / Jabatan Kosong
                          </div>
                          <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalPosition }} / {{ $freePosition }}</div>
                      </div>
                      <div class="col-auto">
                      <h1 class=" text-secondary">
                          <i class="bi bi-diagram-3"></i>
                          </h1>
                      </div>
                  </div>
              </div>
          </div>
          </a>
      </div>
  
      <div class="col-xl-3 col-md-6 mb-4">
          <a href="/admin/user?isOperator=false&isNotInOrganization=false&isNotHavePosition=false&isNotHavePositionButHaveOrganization=true" class=" text-decoration-none text-secondary">
          <div class="card border-success border-3 shadow h-100 ">
              <div class="card-body">
                  <div class="row no-gutters align-items-center">
                      <div class="col mr-2">
                          <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                              User / User tanpa Jabatan
                          </div>
                          <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalUser }} / {{ $freeUser }}</div>
                      </div>
                      <div class="col-auto">
                         <h1 class=" text-secondary">
                          <i class="bi bi-people"></i>
                         </h1>
                      </div>
                  </div>
              </div>
          </div>
          </a>
      </div>
  
      <div class="col-xl-3 col-md-6 mb-4">
          <div class="card border-info border-3 shadow h-100 ">
              <div class="card-body">
                  <div class="row no-gutters align-items-center">
                      <div class="col mr-2">
                          <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                              Notulen Dibuat (Pengiriman/Dibaca)
                          </div>
                          <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $notesCount }} ({{ $notesDistributions }}/{{ $notesReadCount}})</div>
                      </div>
                          <div class="col-auto">
                              <h1 class=" text-secondary">
                                  <i class="bi bi-stickies"></i>
                              </h1>
                      </div>
                      <div class="col-auto">
                          <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  
      <div class="col-xl-3 col-md-6 mb-4">
          <a href="/admin/user?isOperator=false&isNotInOrganization=true&isNotHavePosition=true&isNotHavePositionButHaveOrganization=false" class=" text-decoration-none text-secondary">
          <div class="card border-warning border-3 shadow h-100 ">
              <div class="card-body">
                  <div class="row no-gutters align-items-center">
                      <div class="col mr-2">
                          <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                             Mutasi User
                          </div>
                          <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $userMutaiCount}}</div>
                      </div>
                      <div class="col-auto">
                          <h1 class=" text-secondary">
                              <i class="bi bi-arrow-repeat"></i>
                          </h1>
                      </div>
                      <div class="col-auto">
                          <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                      </div>
                  </div>
              </div>
          </div>
          </a>
      </div>
  
  </div>

  <div class="row">

    <div class="col-xl-12 col-md-12 mb-4">
        <div class="card shadow h-100">
          <div class="card-header">
              Notulen dibuat Bulan terkahir
          </div>
            <div class="card-body">
              <div id="chart" style="height: 600px;"></div>
            </div>
        </div>
    </div>

    <div class="col-xl-12 col-md-12 mb-4">
        <div class="card shadow h-100 ">
          <div class="card-header">
            Notulen dibuat Bulan terkahir Per Instansi
        </div>
            <div class="card-body">
                <!-- Chart's container -->
                <div id="notulenchart" style="height: 600px; width: 100%;"></div>
            </div>
        </div>
    </div>
    <div class="col-xl-12 col-md-12 mb-4">
        <div class="card shadow h-100 ">
          <div class="card-header">
            Notulen dibuat Per Instansi hingga sekarang
        </div>
            <div class="card-body">
                <!-- Chart's container -->
                <div id="pie" style="height: 600px; width: 100%;"></div>
            </div>
        </div>
    </div>
</div>
   
  <!-- Charting library -->
  <script src="https://unpkg.com/chart.js@^2.9.3/dist/Chart.min.js"></script>
  <!-- Chartisan -->
  <script src="https://unpkg.com/@chartisan/chartjs@^2.1.0/dist/chartisan_chartjs.umd.js"></script>
  <!-- Your application script -->

   {{-- <script>
    const notulen_chart = new Chartisan({
      el: '#notulenchart',
      url: "@chart('notulen_chart')",
      hooks: new ChartisanHooks()
          .colors()
          .borderColors()
          .datasets([{ type: 'line', fill: false }])       
          .legend({position: 'bottom'})
          // .tooltip(),
    });
  </script>

   <script>
    const pie_chart = new Chartisan({
      el: '#pie',
      url: "@chart('pie_chart')",
      hooks: new ChartisanHooks()
      .datasets('pie')
      .legend({position: 'bottom'})
    .pieColors(),
      
    });
  </script>


  <script>
    const chart = new Chartisan({
      el: '#chart',
      url: "@chart('sample_chart')",
      hooks: new ChartisanHooks()
          .colors()
          .datasets([{ type: 'line', fill: true }])
          // .tooltip(),
    });
  </script> --}}

  {{-- <canvas class="my-4 w-100" id="myChart" width="900" height="380"></canvas> --}}
{{-- 
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
  </div> --}}

  {{-- <canvas width="971" height="485" style="display: block; box-sizing: border-box; height: 485px; width: 971px;"></canvas> --}}

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
          type: "bar",
          data: data,
          options: options
        });
   
    });
  </script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  const labels = JSON.parse(`<?php echo $label; ?>`)

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