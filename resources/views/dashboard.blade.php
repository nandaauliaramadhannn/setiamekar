@extends('layouts.app', ['title' => 'Dashboard'])

@section('content')
<div class="row">
    <div class="col-12 col-lg-8 col-xl-8">
        <div class="card radius-10">
            <div class="card-body">
                <div class="row row-cols-1 row-cols-lg-2 g-3 align-items-center">
                    <div class="col">
                        <h5 class="mb-0">Data Mobilitas perbulan</h5>
                    </div>
                    <div class="col">
                        <div class="d-flex align-items-center justify-content-sm-end gap-3 cursor-pointer">
                            <div class="font-13"><i class="bi bi-circle-fill text-primary"></i><span class="ms-2">Hadir</span></div>
                            <div class="font-13"><i class="bi bi-circle-fill text-success"></i><span class="ms-2">Izin</span></div>
                        </div>
                    </div>
                </div>
                <div id="mobilitas-chart" style="height: 400px;"></div>
            </div>
        </div>
    </div>

    <!-- Pie Chart Section (Samping Data Perbulan) -->
    <div class="col-12 col-lg-4 col-xl-4">
        <div class="card radius-10 h-100">
            <div class="card-body h-100 d-flex flex-column justify-content-between">
                <h5 class="mb-4">Presentase Hadir dan Izin</h5>
                <div id="pie-chart" style="height: 100%;"></div>
            </div>
        </div>
    </div>

{{-- Statistik Cards --}}
<div class="row row-cols-1 row-cols-sm-3 row-cols-md-3 row-cols-xl-3 row-cols-xxl-6 mt-3">
    @can('user')
    <div class="col">
        <div class="card radius-10">
            <div class="card-body text-center">
                <div class="widget-icon mx-auto mb-3 bg-light-success text-success">
                    <i class="bi bi-people-fill"></i>
                </div>
                <p class="mb-0">Total Mobilitas</p>
                <h3 class="mt-4 mb-0">{{ $mobilitasuser }}</h3>
            </div>
        </div>
    </div>

    @endcan
    @can('admin')
    <div class="col">
        <div class="card radius-10">
            <div class="card-body text-center">
                <div class="widget-icon mx-auto mb-3 bg-light-success text-success">
                    <i class="bi bi-people-fill"></i>
                </div>
                <p class="mb-0">Total User</p>
                <h3 class="mt-4 mb-0">{{ $usertotal }}</h3>
            </div>
        </div>
    </div>
    @endcan
    @if(Auth::user()->role === 'admin' || Auth::user()->role === 'superadmin')
    <div class="col">
        <div class="card radius-10">
            <div class="card-body text-center">
                <div class="widget-icon mx-auto mb-3 bg-light-primary text-primary">
                    <i class="bi bi-person-check-fill"></i>
                </div>
                <p class="mb-0">Total Hadir (Admin View)</p>
                <h3 class="mt-4 mb-0">{{ $chartData['hadir'] }}</h3>
            </div>
        </div>
    </div>

    <div class="col">
        <div class="card radius-10">
            <div class="card-body text-center">
                <div class="widget-icon mx-auto mb-3 bg-light-warning text-warning">
                    <i class="bi bi-person-x-fill"></i>
                </div>
                <p class="mb-0">Total Izin (Admin View)</p>
                <h3 class="mt-4 mb-0">{{ $chartData['izin'] }}</h3>
            </div>
        </div>
    </div>
    @else
    <div class="col">
        <div class="card radius-10">
            <div class="card-body text-center">
                <div class="widget-icon mx-auto mb-3 bg-light-success text-success">
                    <i class="bi bi-person-check-fill"></i>
                </div>
                <p class="mb-0">Hadir</p>
                <h3 class="mt-4 mb-0">{{ $chartData['hadir'] }}</h3>
            </div>
        </div>
    </div>

    <div class="col">
        <div class="card radius-10">
            <div class="card-body text-center">
                <div class="widget-icon mx-auto mb-3 bg-light-warning text-warning">
                    <i class="bi bi-person-x-fill"></i>
                </div>
                <p class="mb-0">Izin</p>
                <h3 class="mt-4 mb-0">{{ $chartData['izin'] }}</h3>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection

@push('js')
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
// Data untuk Chart Mobilitas (Area Chart)
fetch('/mobilitas/chart-data')
    .then(response => response.json())
    .then(data => {
        const months = [
            'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
            'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
        ];

        const hadirData = Array(12).fill(0);
        const izinData = Array(12).fill(0);

        Object.values(data).forEach(user => {
            const hadir = user.hadir || {};
            const izin = user.izin || {};

            Object.entries(hadir).forEach(([month, count]) => {
                const index = parseInt(month.split('-')[1]) - 1;
                hadirData[index] += count;
            });

            Object.entries(izin).forEach(([month, count]) => {
                const index = parseInt(month.split('-')[1]) - 1;
                izinData[index] += count;
            });
        });

        const options = {
            chart: {
                type: 'area',
                height: 400,
                toolbar: { show: false }
            },
            series: [
                {
                    name: 'Hadir',
                    data: hadirData
                },
                {
                    name: 'Izin',
                    data: izinData
                }
            ],
            xaxis: {
                categories: months,
                title: {
                    text: 'Bulan'
                }
            },
            yaxis: {
                title: {
                    text: 'Jumlah'
                }
            },
            tooltip: {
                shared: true,
                intersect: false,
                y: {
                    formatter: val => val + " orang"
                }
            },
            colors: ['#0d6efd', '#198754'],
            stroke: {
                curve: 'smooth'
            },
            fill: {
                type: 'solid' // Ganti gradient jadi solid
            },
            dataLabels: {
                enabled: false
            }
        };

        const chart = new ApexCharts(document.querySelector("#mobilitas-chart"), options);
        chart.render();

        // Donut chart untuk Presentase Hadir vs Izin
        fetch('/data/pie/chart')
    .then(response => response.json())
    .then(data => {
        const pieOptions = {
            chart: {
                type: 'donut',
                height: 350
            },
            series: [data.hadir, data.izin],
            labels: ['Hadir', 'Izin'],
            fill: {
                type: 'gradient',
                gradient: {
                    shade: 'light',
                    type: "vertical",
                    shadeIntensity: 0.4,
                    gradientToColors: ["#31d2f2", "#71dd37"], // Warna akhir gradient
                    inverseColors: true,
                    opacityFrom: 1,
                    opacityTo: 1,
                }
            },
            colors: ["#0d6efd", "#fe5196"], // Warna awal gradient
            tooltip: {
                y: {
                    formatter: val => val + " data"
                }
            },
            plotOptions: {
                pie: {
                    donut: {
                        size: '65%',
                        labels: {
                            show: false // Tidak ada tulisan di tengah
                        }
                    }
                }
            },
            legend: {
                show: false // Kamu bisa ubah ke true kalau mau tampilkan legend
            },
            dataLabels: {
                enabled: true,
                style: {
                    fontSize: '14px',
                    fontWeight: 'bold',
                    colors: ['#fff']
                },
                formatter: function (val) {
                    return val.toFixed(1) + '%';
                }
            },
            responsive: [{
                breakpoint: 480,
                options: {
                    chart: {
                        height: 260
                    },
                    legend: {
                        position: 'bottom'
                    }
                }
            }]
        };

        const pieChart = new ApexCharts(document.querySelector("#pie-chart"), pieOptions);
        pieChart.render();
    });
    });
</script>
@endpush
