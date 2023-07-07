<?php

// app/Http/Controllers/AppointmentController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\histories;

class AppointmentController extends Controller
{
    public function checkStylistAvailability(Request $request)
    {
        $appointmentDate = $request->input('appointment_date');
        $appointmentTime = $request->input('appointment_time');
        $stylistId = $request->input('stylist_id');

        // Kiểm tra sự khả dụng của stylist trong bảng Histories
        $isStylistAvailable = !histories::where('appointment_date', $appointmentDate)
            ->where('appointment_time', $appointmentTime)
            ->where('stylist_id', $stylistId)
            ->exists();

        return response()->json(['available' => $isStylistAvailable]);
    }
}
