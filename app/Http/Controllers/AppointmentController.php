<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Mechanic;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class AppointmentController extends Controller
{
    public function create()
    {
        $mechanics = Mechanic::all();
        return view('appointments.create', compact('mechanics'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'client_name' => 'required|string|max:255',
            'client_address' => 'required|string|max:255',
            'client_phone' => 'required|numeric',
            'car_license_no' => 'required|string|max:255',
            'car_engine_no' => 'required|numeric',
            'appointment_date' => 'required|date|after_or_equal:today',
            'mechanic_id' => 'required|exists:mechanics,_id',
        ]);

        $mechanic = Mechanic::find($request->mechanic_id);

        if (!$mechanic) {
            return redirect()->back()->withErrors(['mechanic_id' => 'Selected mechanic not found.'])->withInput();
        }

        // Check for duplicate booking for the same client on the same day
        $existingAppointment = Appointment::where('client_phone', $request->client_phone)
                                        ->where('appointment_date', $request->appointment_date)
                                        ->first();
        if ($existingAppointment) {
            return redirect()->back()->withErrors(['client_phone' => 'You already have an appointment on this date.'])->withInput();
        }

        // Check mechanic workload
        $appointmentsToday = Appointment::where('mechanic_id', $mechanic->_id)
                                        ->where('appointment_date', $request->appointment_date)
                                        ->count();
        if ($appointmentsToday >= 4) {
            return redirect()->back()->withErrors(['mechanic_id' => 'This mechanic is fully booked for the selected date.'])->withInput();
        }

        Appointment::create([
            'client_name' => $request->client_name,
            'client_address' => $request->client_address,
            'client_phone' => $request->client_phone,
            'car_license_no' => $request->car_license_no,
            'car_engine_no' => $request->car_engine_no,
            'appointment_date' => $request->appointment_date,
            'mechanic_id' => $mechanic->_id,
            'mechanic_name' => $mechanic->name,
        ]);

        // Increment mechanic's appointment count for the specific date
        // This requires a more complex update or a separate collection for daily mechanic workload
        // For simplicity, we'll increment a general count on the mechanic model for now,
        // but a more robust solution would involve a subdocument or a new collection for daily counts.
        $mechanic->increment('appointments_count');


        return redirect()->route('appointments.create')->with('success', 'Appointment booked successfully!');
    }

    public function index()
    {
        $appointments = Appointment::all();
        return view('admin.appointments.index', compact('appointments'));
    }

    public function edit(Appointment $appointment)
    {
        $mechanics = Mechanic::all();
        return view('admin.appointments.edit', compact('appointment', 'mechanics'));
    }

    public function update(Request $request, Appointment $appointment)
    {
        $request->validate([
            'client_name' => 'required|string|max:255',
            'client_address' => 'required|string|max:255',
            'client_phone' => 'required|numeric',
            'car_license_no' => 'required|string|max:255',
            'car_engine_no' => 'required|numeric',
            'appointment_date' => 'required|date|after_or_equal:today',
            'mechanic_id' => 'required|exists:mechanics,_id',
        ]);

        $oldMechanic = Mechanic::find($appointment->mechanic_id);
        $newMechanic = Mechanic::find($request->mechanic_id);

        if (!$newMechanic) {
            throw ValidationException::withMessages(['mechanic_id' => 'Selected mechanic not found.']);
        }

        // Check if mechanic is changing
        if ($oldMechanic->_id != $newMechanic->_id || $appointment->appointment_date != $request->appointment_date) {
            // Decrement old mechanic's count if date or mechanic changed
            if ($oldMechanic) {
                $oldMechanic->decrement('appointments_count');
            }

            // Check new mechanic workload for the new date
            $appointmentsToday = Appointment::where('mechanic_id', $newMechanic->_id)
                                            ->where('appointment_date', $request->appointment_date)
                                            ->count();
            if ($appointmentsToday >= 4) {
                throw ValidationException::withMessages(['mechanic_id' => 'This mechanic is fully booked for the selected date.']);
            }
            $newMechanic->increment('appointments_count');
        }

        $appointment->update([
            'client_name' => $request->client_name,
            'client_address' => $request->client_address,
            'client_phone' => $request->client_phone,
            'car_license_no' => $request->car_license_no,
            'car_engine_no' => $request->car_engine_no,
            'appointment_date' => $request->appointment_date,
            'mechanic_id' => $newMechanic->_id,
            'mechanic_name' => $newMechanic->name,
        ]);

        return redirect()->route('admin.appointments.index')->with('success', 'Appointment updated successfully!');
    }

    public function destroy(Appointment $appointment)
    {
        $mechanic = Mechanic::find($appointment->mechanic_id);
        if ($mechanic) {
            $mechanic->decrement('appointments_count');
        }
        $appointment->delete();
        return redirect()->route('admin.appointments.index')->with('success', 'Appointment deleted successfully.');
    }
}
