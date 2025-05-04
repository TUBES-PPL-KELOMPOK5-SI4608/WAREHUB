@extends('components.components-manager')


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WareHub Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Noto Sans', sans-serif;
            background-color: #FBFAF5;
            display: flex;
            flex-direction: row; 
            margin: 0;
            padding: 0;
        }

        /* Sidebar */
        .sidebar {
            width: 250px;
            position: fixed;
            top: 0;
            left: 0;
            background-color: #74512D;
            height: 100vh;
            color: white;
            display: flex;
            flex-direction: column;
            padding-top: 50px;
        }

        .sidebar h3 {
            margin-left: 20px;
            font-size: 24px;
            color: #FEBA17;
        }

        .sidebar .nav-item a {
            color: white;
        }

        .sidebar .nav-item a:hover {
            background-color: #FEBA17;
        }

        .sidebar .nav-item.active a {
            background-color: #FEBA17;
        }

        /* Main Content */
        .main-content {
            margin-left: 250px; /* Memberikan ruang untuk sidebar */
            padding-top: 20px; /* Memberikan ruang antara header dan data summary */
            flex: 1; /* Mengambil ruang yang tersisa */
        }

        /* Data Summary Section */
        .data-summary {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            gap: 20px;
            margin-bottom: 30px;
        }

        .col-md-3 {
            flex: 1 1 calc(25% - 20px);
        }

        /* Card Style */
        .card {
            background-color: #E4E0E1;
        }

        .card-header {
            font-size: 16px;
            font-weight: bold;
        }

        .card-body {
            font-size: 14px;
        }

        /* Chart Container */
        .chart-container {
            display: grid;
            grid-template-columns: 1fr 1fr; /* Two columns layout for charts */
            gap: 20px;
        }

        .chart-left,
        .chart-right {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

    </style>
</head>

<body>
    <!-- Sidebar with Include -->
    @include('components.components-manager') <!-- This will include your sidebar from components-admin.blade.php -->

    <!-- Main Content -->
    <div class="main-content">
        <!-- Data Summary -->
        <div class="data-summary">
            <div class="col-md-3">
                <div class="card p-3">
                    <div class="card-header">Total Stok Furniture</div>
                    <div class="card-body">200</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card p-3">
                    <div class="card-header">Furniture Tersedia</div>
                    <div class="card-body">150</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card p-3">
                    <div class="card-header">Furniture Baru Masuk</div>
                    <div class="card-body">50</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card p-3">
                    <div class="card-header">Total Earnings</div>
                    <div class="card-body">$334,945</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card p-3">
                    <div class="card-header">Total Orders</div>
                    <div class="card-body">2,802</div>
                </div>
            </div>
        </div>

        <!-- Charts Section -->
        <div class="container chart-container">
            <div class="chart-left">
                <h3>Grafik Pergerakan Stok</h3>
                <canvas id="stockMovementChart" width="500" height="300"></canvas>
            </div>
            <div class="chart-right">
                <div class="top">
                    <h3>Grafik Stok per Kategori</h3>
                    <canvas id="stockCategoryChart" width="400" height="200"></canvas>
                </div>
                <div class="bottom">
                    <h3>Grafik Trend Penjualan</h3>
                    <canvas id="salesTrendChart" width="400" height="200"></canvas>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const currentDate = new Date();
        const day = currentDate.toLocaleString('en-GB', { weekday: 'long' });
        const date = currentDate.toLocaleString('en-GB', { day: '2-digit', month: 'long', year: 'numeric' });
        const time = currentDate.toLocaleString('en-GB', { hour: '2-digit', minute: '2-digit', hour12: false });

        const dateTimeString = `${day}, ${date}, ${time}`;
        document.getElementById('current-date-time').textContent = dateTimeString;

        var stockMovementChart = new Chart(document.getElementById('stockMovementChart').getContext('2d'), {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                datasets: [{
                    label: 'Stock In',
                    data: [10, 15, 25, 35, 45, 50],
                    borderColor: 'rgba(54, 162, 235, 1)',
                    fill: false
                }, {
                    label: 'Stock Out',
                    data: [5, 10, 15, 20, 25, 30],
                    borderColor: 'rgba(255, 99, 132, 1)',
                    fill: false
                }]
            }
        });

        var stockCategoryChart = new Chart(document.getElementById('stockCategoryChart').getContext('2d'), {
            type: 'bar',
            data: {
                labels: ['Meja', 'Kursi', 'Sofa', 'Rak', 'Lemari'],
                datasets: [{
                    label: 'Stock per Category',
                    data: [50, 30, 80, 20, 40],
                    backgroundColor: ['rgba(54, 162, 235, 0.2)', 'rgba(75, 192, 192, 0.2)', 'rgba(153, 102, 255, 0.2)', 'rgba(255, 159, 64, 0.2)', 'rgba(255, 99, 132, 0.2)'],
                    borderColor: ['rgba(54, 162, 235, 1)', 'rgba(75, 192, 192, 1)', 'rgba(153, 102, 255, 1)', 'rgba(255, 159, 64, 1)', 'rgba(255, 99, 132, 1)'],
                    borderWidth: 1
                }]
            }
        });

        var salesTrendChart = new Chart(document.getElementById('salesTrendChart').getContext('2d'), {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                datasets: [{
                    label: 'Sales Trend',
                    data: [5, 10, 15, 20, 25, 30],
                    borderColor: 'rgba(75, 192, 192, 1)',
                    fill: false
                }]
            }
        });
    </script>

</body>
</html>