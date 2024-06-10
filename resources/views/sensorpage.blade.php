<x-app-layout>
    <x-slot name="title">{{ $title }}</x-slot>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Sensor Data') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if ($sensordata->count() > 0)
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <canvas id="temperatureChart" width="400" height="200"></canvas>
                            </div>
                            <div>
                                <canvas id="humidityChart" width="400" height="200"></canvas>
                            </div>
                            <div>
                                <canvas id="rainfallChart" width="400" height="200"></canvas>
                            </div>
                            <div>
                                <canvas id="gasChart" width="400" height="200"></canvas>
                            </div>
                        </div>
                    @else
                        <p>No sensor data available.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        var sensorData = @json($sensordata);

        function extractData(data) {
            var labels = [];
            var temps = [];
            var humis = [];
            var rains = [];
            var gases = [];

            data.forEach(function(item) {
                labels.push(new Date(item.created_at).toLocaleString());
                temps.push(item.temp);
                humis.push(item.humi);
                rains.push(item.rain);
                gases.push(item.gas);
            });

            return { labels: labels, temps: temps, humis: humis, rains: rains, gases: gases };
        }

        var extractedData = extractData(sensorData);

        var tempCtx = document.getElementById('temperatureChart').getContext('2d');
        var tempChart = new Chart(tempCtx, {
            type: 'line',
            data: {
                labels: extractedData.labels,
                datasets: [{
                    label: 'Temperature (°C)',
                    data: extractedData.temps,
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1,
                    fill: false
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });

        var humiCtx = document.getElementById('humidityChart').getContext('2d');
        var humiChart = new Chart(humiCtx, {
            type: 'line',
            data: {
                labels: extractedData.labels,
                datasets: [{
                    label: 'Humidity (%)',
                    data: extractedData.humis,
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1,
                    fill: false
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });

        var rainCtx = document.getElementById('rainfallChart').getContext('2d');
        var rainChart = new Chart(rainCtx, {
            type: 'line',
            data: {
                labels: extractedData.labels,
                datasets: [{
                    label: 'Rainfall (mm)',
                    data: extractedData.rains,
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1,
                    fill: false
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });

        var gasCtx = document.getElementById('gasChart').getContext('2d');
        var gasChart = new Chart(gasCtx, {
            type: 'line',
            data: {
                labels: extractedData.labels,
                datasets: [{
                    label: 'Gas Concentration (ppm)',
                    data: extractedData.gases,
                    borderColor: 'rgba(255, 206, 86, 1)',
                    borderWidth: 1,
                    fill: false
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });

        function updateCharts() {
            $.ajax({
                url: '{{ url('/sensor/latest') }}',
                method: 'GET',
                success: function(data) {
                    var newData = extractData(data);

                    tempChart.data.labels = newData.labels;
                    tempChart.data.datasets[0].data = newData.temps;
                    tempChart.update();

                    humiChart.data.labels = newData.labels;
                    humiChart.data.datasets[0].data = newData.humis;
                    humiChart.update();

                    rainChart.data.labels = newData.labels;
                    rainChart.data.datasets[0].data = newData.rains;
                    rainChart.update();

                    gasChart.data.labels = newData.labels;
                    gasChart.data.datasets[0].data = newData.gases;
                    gasChart.update();
                }
            });
        }

        setInterval(updateCharts, 1000);
    </script>
</x-app-layout>
