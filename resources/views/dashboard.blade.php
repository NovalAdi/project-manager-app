@extends('layout.master')

@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
        </div>

        <!-- Content Row -->
        <div class="row">

            <!-- Total Employee -->
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Employee</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalEmployee }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-user fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Project -->
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Project</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalProject }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-wrench fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Task -->
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                    Task</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalTask }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- Content Row -->

        <div class="row">

            <!-- Pie Chart -->
            <div class="col-xl-4 col-lg-5">
                <div class="card shadow mb-4">
                    <!-- Card Header -->
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Task Status</h6>
                    </div>
                    <!-- Card Body -->
                    <div class="card-body">
                        @if ($totalTask == 0)
                            <p>Data is Empty</p>
                        @else
                            <div class="chart-pie pt-4 pb-2">
                                <canvas id="myPieChart"></canvas>
                            </div>
                            <div class="mt-4 text-center small">
                                <span class="mr-2">
                                    <i class="fas fa-circle text-success"></i> Done
                                </span>
                                <span class="mr-2">
                                    <i class="fas fa-circle text-warning"></i> Pending
                                </span>
                                <span class="mr-2">
                                    <i class="fas fa-circle text-danger"></i> Undone
                                </span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Project Card Example -->
            <div class="col-xl-8 col-lg-7">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Projects</h6>
                    </div>
                    @if (count($listProject) == 0)
                        <p class="m-4">Data is Empty</p>
                    @else
                        <div class="card-body">

                            @foreach ($listProject as $key => $project)
                                {{-- project --}}
                                <h4 class="small font-weight-bold">{{ $project->name }}
                                    <span class="float-right">{{ $percentage[$key] }}%</span>
                                </h4>
                                <div class="progress mb-4">
                                    <div class="progress-bar" role="progressbar" style="width: {{ $percentage[$key] }}%"
                                        aria-valuenow="{{ $percentage[$key] }}" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            @endforeach

                        </div>
                    @endif
                </div>
            </div>

        </div>

    </div>
@endsection

@push('js')
    <script>
        // Set new default font family and font color to mimic Bootstrap's default styling
        Chart.defaults.global.defaultFontFamily = 'Nunito',
            '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
        Chart.defaults.global.defaultFontColor = '#858796';

        // Pie Chart Example
        var ctx = document.getElementById("myPieChart");
        var myPieChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ["Done", "Pending", "Undone"],
                datasets: [{
                    data: [{{ count($done) }}, {{ count($pending) }}, {{ count($undone) }}],
                    backgroundColor: ['#1cc88a', '#f6c23e', '#e74a3b'],
                    hoverBackgroundColor: ['#1cc88a', '#f6c23e', '#e74a3b'],
                    hoverBorderColor: "rgba(234, 236, 244, 1)",
                }],
            },
            options: {
                maintainAspectRatio: false,
                tooltips: {
                    backgroundColor: "rgb(255,255,255)",
                    bodyFontColor: "#858796",
                    borderColor: '#dddfeb',
                    borderWidth: 1,
                    xPadding: 15,
                    yPadding: 15,
                    displayColors: false,
                    caretPadding: 10,
                },
                legend: {
                    display: false
                },
                cutoutPercentage: 80,
            },
        });
    </script>
@endpush
