@extends('templates.app')

@section('content')
    @if (Session::get('success'))
        <div class="alert alert-success w-100">
            {{ Session::get('success') }}
            <b>Selamat Datang, {{ Auth::user()->name }}</b>
        </div>
    @endif

    @if (Session::get('logout'))
        <div class="alert alert-warning">{{ Session::get('logout') }}</div>
    @endif

    <div class="container mt-4">

        <h3>Dashboard Admin</h3>

        <div class="row mt-4">
            <!-- CARD PENJUALAN HARIAN -->
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-header bg-success text-white">
                        Penjualan Harian
                    </div>
                    <div class="card-body">
                        <canvas id="chartBar" height="200"></canvas>
                    </div>
                </div>
            </div>

            <!-- CARD MENU TERLARIS -->
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        Menu Terlaris
                    </div>
                    <div class="card-body">
                        <canvas id="chartPie" height="200"></canvas>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

@push('script')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>


    <script>
        $(function() {
            $.ajax({
                url: "{{ route('admin.chart') }}",
                method: "GET",
                success: function(res) {

                    // ======================
                    // BAR CHART PENJUALAN
                    // ======================
                    new Chart(document.getElementById('chartBar'), {
                        type: 'bar',
                        data: {
                            labels: res.penjualan.labels,
                            datasets: [{
                                label: 'Total Penjualan (Rp)',
                                data: res.penjualan.data,
                                backgroundColor: 'rgba(40, 167, 69, 0.6)',
                                borderColor: 'rgba(40, 167, 69, 1)',
                                borderWidth: 1
                            }]
                        }
                    });

                    // ======================
                    // PIE CHART MENU TERLARIS
                    // ======================
                    new Chart(document.getElementById('chartPie'), {
                        type: 'pie',
                        data: {
                            labels: res.menu.labels,
                            datasets: [{
                                data: res.menu.data,
                                backgroundColor: [
                                    '#007bff', '#6610f2', '#6f42c1',
                                    '#e83e8c', '#dc3545'
                                ]
                            }]
                        }
                    });

                }
            });
        });
    </script>
@endpush
