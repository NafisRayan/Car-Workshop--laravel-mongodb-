<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Mechanic;

class MechanicController extends Controller
{
    public function getAvailableMechanics(Request $request)
    {
        $date = $request->input('date');
        // Logic to retrieve mechanics with less than 4 appointments on the given date
        // This will be implemented later once the Appointment model is ready for interaction
        $mechanics = Mechanic::all(); // Placeholder for now
        return response()->json($mechanics);
    }
}
