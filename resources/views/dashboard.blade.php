<x-app-layout>
    <x-slot name="title">{{ $title }}</x-slot>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("Welcome! Use the navigation bar to control LEDs or monitor the sensors.") }}
                </div>
            </div>

            <div class="mt-6 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="font-semibold text-lg mb-4">{{ __('Latest Sensor Data') }}</h3>
                    <div id="sensor-data" class="grid grid-cols-2 gap-4">
                        <div class="p-4 bg-gray-200 dark:bg-gray-700 rounded-lg">
                            <h4 class="text-md font-semibold">{{ __('Temperature') }}</h4>
                            <p class="text-lg" id="temp">{{ $sensor->temp }}°C</p>
                        </div>
                        <div class="p-4 bg-gray-200 dark:bg-gray-700 rounded-lg">
                            <h4 class="text-md font-semibold">{{ __('Humidity') }}</h4>
                            <p class="text-lg" id="humi">{{ $sensor->humi }}%</p>
                        </div>
                        <div class="p-4 bg-gray-200 dark:bg-gray-700 rounded-lg">
                            <h4 class="text-md font-semibold">{{ __('Rain') }}</h4>
                            <p class="text-lg" id="rain">{{ $sensor->rain }} mm</p>
                        </div>
                        <div class="p-4 bg-gray-200 dark:bg-gray-700 rounded-lg">
                            <h4 class="text-md font-semibold">{{ __('Gas') }}</h4>
                            <p class="text-lg" id="gas">{{ $sensor->gas }} ppm</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-6 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="font-semibold text-lg mb-4">{{ __('LED Information') }}</h3>
                    <ul>
                        @forelse($leds as $led)
                            <li>{{ $led->led_name }}: {{ $led->status ? 'On' : 'Off' }}</li>
                        @empty
                            <li>{{ __('No LED information available.') }}</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function updateSensorData() {
            $.ajax({
                url: '{{ url('/sensor/latest3') }}',
                method: 'GET',
                success: function(data) {
                    $('#temp').text(data.temp + '°C');
                    $('#humi').text(data.humi + '%');
                    $('#rain').text(data.rain + ' mm');
                    $('#gas').text(data.gas + ' ppm');
                }
            });
        }

        setInterval(updateSensorData, 1000);
    </script>
</x-app-layout>
