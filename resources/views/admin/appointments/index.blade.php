<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Appointments</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 p-8">
    <div class="max-w-7xl mx-auto bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-2xl font-bold mb-6 text-center">All Appointments</h2>

        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-300">
                <thead>
                    <tr>
                        <th class="py-2 px-4 border-b">Client Name</th>
                        <th class="py-2 px-4 border-b">Phone</th>
                        <th class="py-2 px-4 border-b">Car License</th>
                        <th class="py-2 px-4 border-b">Appointment Date</th>
                        <th class="py-2 px-4 border-b">Mechanic</th>
                        <th class="py-2 px-4 border-b">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($appointments as $appointment)
                        <tr class="hover:bg-gray-50">
                            <td class="py-2 px-4 border-b">{{ $appointment->client_name }}</td>
                            <td class="py-2 px-4 border-b">{{ $appointment->client_phone }}</td>
                            <td class="py-2 px-4 border-b">{{ $appointment->car_license_no }}</td>
                            <td class="py-2 px-4 border-b">{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('Y-m-d') }}</td>
                            <td class="py-2 px-4 border-b">{{ $appointment->mechanic_name }}</td>
                            <td class="py-2 px-4 border-b text-center">
                                <a href="{{ route('admin.appointments.edit', $appointment->id) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-3 rounded text-xs">Edit</a>
                                <form action="{{ route('admin.appointments.destroy', $appointment->id) }}" method="POST" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-3 rounded text-xs" onclick="return confirm('Are you sure you want to delete this appointment?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-4 px-4 text-center text-gray-500">No appointments found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>