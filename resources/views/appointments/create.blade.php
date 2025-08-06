<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Appointment</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-md">
        <h2 class="text-2xl font-bold mb-6 text-center">Book Your Car Service Appointment</h2>

        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('appointments.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="client_name" class="block text-gray-700 text-sm font-bold mb-2">Your Name:</label>
                <input type="text" name="client_name" id="client_name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{ old('client_name') }}" required>
            </div>
            <div class="mb-4">
                <label for="client_address" class="block text-gray-700 text-sm font-bold mb-2">Your Address:</label>
                <input type="text" name="client_address" id="client_address" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{ old('client_address') }}" required>
            </div>
            <div class="mb-4">
                <label for="client_phone" class="block text-gray-700 text-sm font-bold mb-2">Phone Number:</label>
                <input type="text" name="client_phone" id="client_phone" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{ old('client_phone') }}" required>
            </div>
            <div class="mb-4">
                <label for="car_license_no" class="block text-gray-700 text-sm font-bold mb-2">Car License No.:</label>
                <input type="text" name="car_license_no" id="car_license_no" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{ old('car_license_no') }}" required>
            </div>
            <div class="mb-4">
                <label for="car_engine_no" class="block text-gray-700 text-sm font-bold mb-2">Car Engine No.:</label>
                <input type="text" name="car_engine_no" id="car_engine_no" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{ old('car_engine_no') }}" required>
            </div>
            <div class="mb-4">
                <label for="appointment_date" class="block text-gray-700 text-sm font-bold mb-2">Appointment Date:</label>
                <input type="date" name="appointment_date" id="appointment_date" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{ old('appointment_date') }}" required>
            </div>
            <div class="mb-6">
                <label for="mechanic_id" class="block text-gray-700 text-sm font-bold mb-2">Preferred Mechanic:</label>
                <select name="mechanic_id" id="mechanic_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                    <option value="">Select a Mechanic</option>
                    @foreach ($mechanics as $mechanic)
                        <option value="{{ $mechanic->_id }}" {{ old('mechanic_id') == $mechanic->_id ? 'selected' : '' }}>
                            {{ $mechanic->name }} (Appointments: {{ $mechanic->appointments_count }}/4)
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="flex items-center justify-between">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Book Appointment
                </button>
            </div>
        </form>
    </div>

    <script>
        document.getElementById('appointment_date').addEventListener('change', function() {
            const selectedDate = this.value;
            const mechanicSelect = document.getElementById('mechanic_id');
            mechanicSelect.innerHTML = '<option value="">Loading Mechanics...</option>';

            fetch(`/mechanics/available?date=${selectedDate}`)
                .then(response => response.json())
                .then(data => {
                    mechanicSelect.innerHTML = '<option value="">Select a Mechanic</option>';
                    if (data.length > 0) {
                        data.forEach(mechanic => {
                            const option = document.createElement('option');
                            option.value = mechanic._id;
                            option.textContent = `${mechanic.name} (Appointments: ${mechanic.appointments_count}/4)`;
                            mechanicSelect.appendChild(option);
                        });
                    } else {
                        mechanicSelect.innerHTML = '<option value="">No mechanics available for this date</option>';
                    }
                })
                .catch(error => {
                    console.error('Error fetching mechanics:', error);
                    mechanicSelect.innerHTML = '<option value="">Error loading mechanics</option>';
                });
        });
    </script>
</body>
</html>