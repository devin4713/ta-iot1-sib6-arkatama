<x-app-layout>
    <x-slot name="title">{{ $title }}</x-slot>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('LED Control') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h2 class="text-2xl font-semibold mb-4">Add New LED</h2>
                    <form id="addLedForm" class="mb-6">
                        <div class="mb-4">
                            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">LED Name:</label>
                            <input type="text" id="name" name="name" required class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-white">
                        </div>
                        <div class="mb-4">
                            <label for="pin" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Pin Number:</label>
                            <input type="number" id="pin" name="pin" required class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-white">
                        </div>
                        <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md border border-indigo-600">Add LED</button>
                    </form>

                    <h2 class="text-2xl font-semibold mb-4">Existing LEDs</h2>
                    <div id="leds">
                        @foreach ($leddata as $led)
                            <div class="mb-4 p-4 bg-gray-100 dark:bg-gray-700 rounded-lg flex items-center justify-between">
                                <div>
                                    <h3 class="text-lg font-medium">{{ $led->led_name }} (Pin: {{ $led->pin }})</h3>
                                    <label class="switch mt-2">
                                        <input type="checkbox" data-id="{{ $led->id }}" {{ $led->status ? 'checked' : '' }}>
                                        <span class="slider"></span>
                                    </label>
                                </div>
                                <button data-id="{{ $led->id }}" class="delete-btn px-4 py-2 bg-red-600 text-white rounded-md">Delete</button>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .switch {
            position: relative;
            display: inline-block;
            width: 60px;
            height: 34px;
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #555;
            transition: .4s;
            border-radius: 34px;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 26px;
            width: 26px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            transition: .4s;
            border-radius: 50%;
        }

        input:checked + .slider {
            background-color: #4A90E2;
        }

        input:checked + .slider:before {
            transform: translateX(26px);
        }

        .slider.round {
            border-radius: 34px;
        }

        .slider.round:before {
            border-radius: 50%;
        }
    </style>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const addLedForm = document.getElementById('addLedForm');
            addLedForm.addEventListener('submit', function(e) {
                e.preventDefault();

                const formData = new FormData(addLedForm);
                const data = {
                    led_name: formData.get('name'),
                    pin: parseInt(formData.get('pin'))
                };

                fetch('/led', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify(data)
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.message) {
                            window.location.reload();
                        }
                    });
            });

            document.querySelectorAll('input[type="checkbox"]').forEach(function(switchElement) {
                switchElement.addEventListener('change', function() {
                    const id = switchElement.getAttribute('data-id');
                    const status = switchElement.checked ? 1 : 0;

                    fetch(`/led/${id}`, {
                            method: 'PUT',
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                status: status
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            console.log(data.message);
                        });
                });
            });

            document.querySelectorAll('.delete-btn').forEach(function(button) {
                button.addEventListener('click', function() {
                    const id = button.getAttribute('data-id');

                    fetch(`/led/${id}`, {
                            method: 'DELETE',
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.message) {
                                window.location.reload();
                            }
                        });
                });
            });
        });
    </script>
</x-app-layout>
