<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Appointment;

class AppointmentController extends Controller
{
    public function create(Request $request)
    {
        if (Auth::check()) {
            $this->validate($request, [
                'consultant_name' => 'required',
                'service_name' => 'required',
                'date' => 'required',
            ]);
            Appointment::create($request->all());
        }
        return back();
    }

    public function delete($id)
    {
        if (Auth::check()) {
            $appointment = Appointment::find($id);
            $appointment->delete();
        }

        return back();
    }
}
