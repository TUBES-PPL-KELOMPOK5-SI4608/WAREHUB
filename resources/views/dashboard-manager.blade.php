@extends('components-manager')

@section('title', 'Dashboard Manager') <!-- Menentukan title khusus untuk halaman ini -->

@section('content')
    <!-- Data Summary Section -->
    <div class="container mt-5">
        <h3>Data Summary</h3>
        <div class="flex flex-wrap justify-between">
            <!-- Card 1: Total Furniture -->
            <div class="w-full sm:w-1/2 md:w-1/4 p-4">
                <div class="bg-white shadow-lg rounded-lg p-5">
                    <div class="text-lg font-semibold text-gray-700">Total Furniture</div>
                    <div class="text-3xl font-bold text-gray-900">200</div>
                </div>
            </div>
            <!-- Card 2: Furniture Tersedia -->
            <div class="w-full sm:w-1/2 md:w-1/4 p-4">
                <div class="bg-white shadow-lg rounded-lg p-5">
                    <div class="text-lg font-semibold text-gray-700">Furniture Tersedia</div>
                    <div class="text-3xl font-bold text-gray-900">150</div>
                </div>
            </div>
            <!-- Card 3: Furniture Habis -->
            <div class="w-full sm:w-1/2 md:w-1/4 p-4">
                <div class="bg-white shadow-lg rounded-lg p-5">
                    <div class="text-lg font-semibold text-gray-700">Furniture Habis (Low Stock)</div>
                    <div class="text-3xl font-bold text-gray-900">10</div>
                </div>
            </div>
            <!-- Card 4: Furniture Baru Masuk -->
            <div class="w-full sm:w-1/2 md:w-1/4 p-4">
                <div class="bg-white shadow-lg rounded-lg p-5">
                    <div class="text-lg font-semibold text-gray-700">Furniture Baru Masuk</div>
                    <div class="text-3xl font-bold text-gray-900">50</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Top Selling Furniture Section -->
    <div class="container mt-5">
        <h3>Top Selling Furniture</h3>
        <div class="flex flex-wrap justify-between">
            <!-- Card 1: Top Selling Item 1 -->
            <div class="w-full sm:w-1/2 md:w-1/4 p-4">
                <div class="bg-white shadow-lg rounded-lg p-5">
                    <img src="https://via.placeholder.com/300x200" alt="Furniture Image" class="w-full h-40 object-cover rounded-lg mb-3">
                    <div class="text-lg font-semibold text-gray-700">Meja Kayu</div>
                    <div class="text-2xl font-bold text-gray-900">100 pcs</div>
                </div>
            </div>
            <!-- Card 2: Top Selling Item 2 -->
            <div class="w-full sm:w-1/2 md:w-1/4 p-4">
                <div class="bg-white shadow-lg rounded-lg p-5">
                    <img src="https://via.placeholder.com/300x200" alt="Furniture Image" class="w-full h-40 object-cover rounded-lg mb-3">
                    <div class="text-lg font-semibold text-gray-700">Sofa Modern</div>
                    <div class="text-2xl font-bold text-gray-900">85 pcs</div>
                </div>
            </div>
            <!-- Card 3: Top Selling Item 3 -->
            <div class="w-full sm:w-1/2 md:w-1/4 p-4">
                <div class="bg-white shadow-lg rounded-lg p-5">
                    <img src="https://via.placeholder.com/300x200" alt="Furniture Image" class="w-full h-40 object-cover rounded-lg mb-3">
                    <div class="text-lg font-semibold text-gray-700">Rak Buku</div>
                    <div class="text-2xl font-bold text-gray-900">120 pcs</div>
                </div>
            </div>
            <!-- Card 4: Top Selling Item 4 -->
            <div class="w-full sm:w-1/2 md:w-1/4 p-4">
                <div class="bg-white shadow-lg rounded-lg p-5">
                    <img src="https://via.placeholder.com/300x200" alt="Furniture Image" class="w-full h-40 object-cover rounded-lg mb-3">
                    <div class="text-lg font-semibold text-gray-700">Lemari Pakaian</div>
                    <div class="text-2xl font-bold text-gray-900">60 pcs</div>
                </div>
            </div>
        </div>
    </div>

    <!-- 2 Rows with 2 Graphs per Row -->

    <!-- First Row with 2 Charts -->
    <div class="container mt-5">
        <div class="flex flex-wrap justify-between">
            <!-- Chart 1: Stok Barang per Kategori -->
            <div class="w-full sm:w-1/2 p-4">
                <h3>Grafik Stok per Kategori</h3>
                <div id="stockCategoryChart" style="width: 100%; height: 400px;"></div>
            </div>

            <!-- Chart 2: Pergerakan Stok Barang -->
            <div class="w-full sm:w-1/2 p-4">
                <h3>Grafik Pergerakan Stok</h3>
                <div id="stockMovementChart" style="width: 100%; height: 400px;"></div>
            </div>
        </div>
    </div>

    <!-- Second Row with 2 Charts -->
    <div class="container mt-5">
        <div class="flex flex-wrap justify-between">
            <!-- Chart 3: Barang Masuk vs Barang Keluar -->
            <div class="w-full sm:w-1/2 p-4">
                <h3>Grafik Barang Masuk vs Barang Keluar</h3>
                <div id="stockInOutChart" style="width: 100%; height: 400px;"></div>
            </div>

            <!-- Chart 4: Perbandingan Stok per Gudang -->
            <div class="w-full sm:w-1/2 p-4">
                <h3>Perbandingan Stok per Gudang</h3>
                <div id="stockComparisonChart" style="width: 100%; height: 400px;"></div>
            </div>
        </div>
    </div>

    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script>
        google.charts.load('current', {
            packages: ['corechart', 'bar']
        });

        google.charts.setOnLoadCallback(drawCharts);

        function drawCharts() {
            // Stock per Category Chart
            var stockCategoryData = google.visualization.arrayToDataTable([
                ['Category', 'Stock'],
                ['Meja', 50],
                ['Kursi', 30],
                ['Sofa', 80],
                ['Rak', 20],
                ['Lemari', 40]
            ]);

            var stockCategoryOptions = {
                title: 'Stok per Kategori',
                chartArea: { width: '50%' },
                hAxis: {
                    title: 'Stock',
                    minValue: 0
                },
                vAxis: {
                    title: 'Category'
                }
            };

            var stockCategoryChart = new google.visualization.BarChart(document.getElementById('stockCategoryChart'));
            stockCategoryChart.draw(stockCategoryData, stockCategoryOptions);

            // Stock Movement Chart
            var stockMovementData = google.visualization.arrayToDataTable([
                ['Month', 'Stock In', 'Stock Out'],
                ['Jan', 10, 5],
                ['Feb', 15, 10],
                ['Mar', 25, 15],
                ['Apr', 35, 20],
                ['May', 45, 25],
                ['Jun', 50, 30]
            ]);

            var stockMovementOptions = {
                title: 'Pergerakan Stok',
                curveType: 'function',
                legend: { position: 'bottom' }
            };

            var stockMovementChart = new google.visualization.LineChart(document.getElementById('stockMovementChart'));
            stockMovementChart.draw(stockMovementData, stockMovementOptions);

            // Stock In vs Stock Out Chart
            var stockInOutData = google.visualization.arrayToDataTable([
                ['Month', 'Stock In', 'Stock Out'],
                ['Jan', 10, 5],
                ['Feb', 15, 10],
                ['Mar', 25, 15],
                ['Apr', 35, 20],
                ['May', 45, 25],
                ['Jun', 50, 30]
            ]);

            var stockInOutOptions = {
                title: 'Barang Masuk vs Barang Keluar',
                curveType: 'function',
                legend: { position: 'bottom' }
            };

            var stockInOutChart = new google.visualization.LineChart(document.getElementById('stockInOutChart'));
            stockInOutChart.draw(stockInOutData, stockInOutOptions);

            // Stock Comparison per Warehouse
            var stockComparisonData = google.visualization.arrayToDataTable([
                ['Warehouse', 'Stock'],
                ['Gudang A', 120],
                ['Gudang B', 150],
                ['Gudang C', 100]
            ]);

            var stockComparisonOptions = {
                title: 'Perbandingan Stok per Gudang',
                chartArea: { width: '50%' },
                hAxis: {
                    title: 'Stock',
                    minValue: 0
                },
                vAxis: {
                    title: 'Warehouse'
                }
            };

            var stockComparisonChart = new google.visualization.BarChart(document.getElementById('stockComparisonChart'));
            stockComparisonChart.draw(stockComparisonData, stockComparisonOptions);
        }
    </script>
@endsection