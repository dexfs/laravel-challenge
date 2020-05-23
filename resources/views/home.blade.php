@extends('layouts.app')
@push('user_scripts')
    <link rel="stylesheet" href="https://cdn3.devexpress.com/jslib/20.1.3/css/dx.common.css">
    <link rel="stylesheet" href="https://cdn3.devexpress.com/jslib/20.1.3/css/dx.light.css">
    <!-- DevExtreme library -->
    <script type="text/javascript" src="https://cdn3.devexpress.com/jslib/20.1.3/js/dx.all.js"></script>
@endpush

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg">
                <div class="card">
                    <div class="card-header">Dashboard</div>

                    <div class="card-body">

                        <div class="row">
                            <div class="col-sm">

                            <div id="chart-status"></div>
                            </div>
                            <div class="col-sm">

                            <div id="chart-user"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(function(){
            $("#chart-status").dxChart({
                dataSource: '/api/dashboard/tasks/status',
                series: {
                    argumentField: "status",
                    valueField: "total",
                    name: "Total de tarefas por status no mês atual",
                    type: "bar",
                    color: '#007B51'
                },
                legend: {
                    position: "outside", // or "outside"
                    horizontalAlignment: "center", // or "left" | "right"
                    verticalAlignment: "top" // or "bottom"
                }
            });
            $("#chart-user").dxChart({
                dataSource: '/api/dashboard/tasks/users',
                series: {
                    argumentField: "user",
                    valueField: "total",
                    name: "Total de tarefas por usuário no mês atual",
                    type: "bar",
                    color: 'blue'
                },
                legend: {
                    position: "outside", // or "outside"
                    horizontalAlignment: "center", // or "left" | "right"
                    verticalAlignment: "top" // or "bottom"
                }
            });
        });
    </script>
@endsection
