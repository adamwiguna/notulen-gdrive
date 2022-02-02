@extends('operator.layouts.app')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Dashboard</h1>
  
</div>
<div class="row">

    <div class="col-xl-3 col-md-6 mb-4">
        <a href="/operator/position?canShare=false&canReceive=false&perPage=25&free=true" class=" text-decoration-none text-secondary">
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
        <a href="/operator/user?isNotHavePosition=true&isMutasi=false&perPage=25&disabled=true" class=" text-decoration-none text-secondary">
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
        <a href="/operator/user?isNotHavePosition=false&isMutasi=true&perPage=25&disabled=true" class=" text-decoration-none text-secondary">
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
              Notulen dibuat 6 Bulan terkahir
          </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col"> Bulan   </th>
                            @foreach ($months as $key => $item)
                               <th scope="col">
                                    {{ $item }}
                                </th>
                            @endforeach
                            <th>
                                Total
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th>
                                Total Notulen
                            </th>
                            @foreach ($data['data'] as $item)
                                <td>
                                    {{ $item }}
                                </td>
                            @endforeach
                            <th>
                                {{ array_sum($data['data']) }}
                            </th>
                        </tr>
                        <tr>
                            <th>
                                Pengiriman Notulen
                            </th>
                            @foreach ($data['send'] as $item)
                                <td>
                                    {{ $item }}
                                </td>
                            @endforeach
                            <th>
                                {{ array_sum($data['send']) }}
                            </th>
                        </tr>
                        <tr>
                            <th>
                                Notulen Dibaca
                            </th>
                            @foreach ($data['read'] as $item)
                                <td>
                                    {{ $item }}
                                </td>
                            @endforeach
                            <th>
                                {{ array_sum($data['read']) }}
                            </th>
                        </tr>
                    </tbody>
                </table>
              {{-- <div id="chart" style="height: 600px;"></div> --}}
            </div>
        </div>
    </div>
</div>

<!-- Charting library -->
<script src="https://unpkg.com/chart.js@^2.9.3/dist/Chart.min.js"></script>
<!-- Chartisan -->
<script src="https://unpkg.com/@chartisan/chartjs@^2.1.0/dist/chartisan_chartjs.umd.js"></script>

{{-- <script>
    const notulen_chart = new Chartisan({
      el: '#chart',
      url: "@chart('notulen_per_organization')",
      hooks: new ChartisanHooks()
          .colors()
          .borderColors()
          .datasets([{ type: 'line', fill: false }])       
          .legend({position: 'bottom'})
          // .tooltip(),
    });
  </script> --}}
<!-- Your application script -->
@endsection